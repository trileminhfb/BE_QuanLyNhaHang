<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;
use App\Models\Food;
use App\Models\InvoiceFood;
use App\Models\Sale;
use Illuminate\Support\Carbon;
use PayOS\PayOS;

class InvoiceController extends Controller
{
    public function index()
    {
        try {
            $invoices = Invoice::with([
                'user',
                'customer',
                'table',
                'sale',
                'invoiceFoods.food'
            ])->get();

            return response()->json([
                'data' => $invoices
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy danh sách hóa đơn: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi khi lấy danh sách hóa đơn'], 500);
        }
    }

    public function getByCustomer($customerId)
    {
        try {
            $invoices = Invoice::with([
                'user',
                'customer',
                'table',
                'sale',
                'invoiceFoods.food'
            ])
                ->where('id_customer', $customerId)
                ->whereIn('status', [ 2, 3])
                ->get();

            if ($invoices->isEmpty()) {
                return response()->json([
                    'message' => 'Không tìm thấy hóa đơn nào cho khách hàng này với trạng thái phù hợp.'
                ], 404);
            }

            // Thêm trường reward_points vào mỗi hóa đơn
            $invoices = $invoices->map(function ($invoice) {
                $total = $invoice->invoiceFoods->sum(function ($item) {
                    return ($item->quantity ?? 0) * ($item->food->cost ?? 0);
                });
                $invoice->reward_points = round(($total * 0.05) / 1000);
                return $invoice;
            });

            return response()->json([
                'data' => $invoices
            ], 200);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy hóa đơn theo khách hàng: ' . $e->getMessage());
            return response()->json([
                'error' => 'Lỗi khi lấy hóa đơn: ' . $e->getMessage()
            ], 500);
        }
    }

    public function payBooking($id)
    {
        try {
            // Tìm đặt bàn
            $booking = Booking::find($id);
            if (!$booking) {
                return response()->json(['message' => 'Không tìm thấy đặt bàn'], 404);
            }

            // Kiểm tra trạng thái đặt bàn
            if ($booking->status == 2) {
                return response()->json(['message' => 'Đặt bàn đã được thanh toán'], 400);
            }

            // Tìm hóa đơn liên quan đến đặt bàn
            $invoice = Invoice::where('id_booking', $booking->id)->first();
            if (!$invoice) {
                return response()->json(['message' => 'Không tìm thấy hóa đơn cho đặt bàn này'], 404);
            }

            // Tạo liên kết thanh toán PayOS
            $paymentUrl = $this->createPayOSPayment($invoice->id);

            return response()->json([
                'message' => 'Tạo liên kết thanh toán thành công',
                'payment_url' => $paymentUrl,
                'amount' => $invoice->total
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi tạo liên kết thanh toán cho đặt bàn: ' . $e->getMessage());
            return response()->json([
                'message' => 'Lỗi khi tạo liên kết thanh toán',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(InvoiceRequest $request)
    {
        DB::beginTransaction();
        try {
            $idTable = $request->id_table;
            $idBooking = $request->input('id_booking');
            $user = $request->user();
            $idUser = $user ? $user->id : $request->input('id_user', null);
            $idCustomer = $request->input('id_customer', null);
            $idSale = $request->input('id_sale', null);
            $role = $user->role ?? 'guest';

            $items = $request->input('items', []);
            if (empty($items)) {
                $carts = Cart::where('id_table', $idTable)->get();
                if ($carts->isEmpty()) {
                    return response()->json(['message' => 'Không có món nào trong giỏ hàng'], 400);
                }
                $items = $carts->map(function ($cart) {
                    return [
                        'id_food' => $cart->id_food,
                        'quantity' => $cart->quantity,
                        'price' => $cart->food->cost,
                        'name' => $cart->food->name,
                    ];
                })->toArray();
            }

            $total = $request->input('total', 0);
            if (!$total) {
                $total = collect($items)->sum(function ($item) {
                    return $item['price'] * $item['quantity'];
                });
            }

            $discountPercent = 0;
            if ($idSale) {
                $sale = Sale::find($idSale);
                if ($sale) {
                    $discountPercent = $sale->percent;
                    $total -= ($total * $discountPercent / 100);
                }
            }

            $invoice = Invoice::create([
                'id_table' => $idTable,
                'id_booking' => $idBooking,
                'timeEnd' => Carbon::now(),
                'total' => $total,
                'id_user' => $idUser,
                'id_customer' => $idCustomer,
                'id_sale' => $idSale,
                'status' => 1,
                'note' => $request->input('note', ''),
            ]);

            foreach ($items as $item) {
                InvoiceFood::create([
                    'id_invoice' => $invoice->id,
                    'id_food' => $item['id_food'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Tạo hóa đơn thành công',
                'data' => $invoice
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi tạo hóa đơn: ' . $e->getMessage());
            return response()->json([
                'message' => 'Lỗi khi tạo hóa đơn',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $invoice = Invoice::with(['table', 'user', 'customer'])->find($id);

            if (!$invoice) {
                return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
            }

            return response()->json($invoice);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_table' => 'required|exists:tables,id',
            'id_user' => 'required|exists:users,id',
            'total' => 'required|numeric',
            'timeEnd' => 'required|date',
            'id_customer' => 'nullable|exists:customers,id',
            'status' => 'nullable|in:1,2,3',
            'foods' => 'nullable|array',
            'foods.*.id' => 'required|exists:foods,id',
            'foods.*.quantity' => 'required|integer|min:0',
        ]);

        try {
            $invoice = Invoice::find($id);

            if (!$invoice) {
                return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
            }

            $invoice->update($validated);

            if ($request->has('foods')) {
                $foods = $request->input('foods');

                foreach ($foods as $item) {
                    if ($item['quantity'] === 0) {
                        DB::table('invoice_food')
                            ->where('id_invoice', $id)
                            ->where('id_food', $item['id'])
                            ->delete();
                    } else {
                        DB::table('invoice_food')->updateOrInsert(
                            [
                                'id_invoice' => $id,
                                'id_food' => $item['id'],
                            ],
                            [
                                'quantity' => $item['quantity'],
                            ]
                        );
                    }
                }
            }

            return response()->json([
                'message' => 'Hóa đơn được cập nhật thành công',
                'invoice' => $invoice
            ], 200);
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật hóa đơn: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi cập nhật hóa đơn'], 500);
        }
    }

    public function delete($id)
    {
        try {
            $invoice = Invoice::find($id);

            if (!$invoice) {
                return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
            }

            $invoice->delete();
            return response()->json(['message' => 'Xóa hóa đơn thành công']);
        } catch (\Exception $e) {
            Log::error('Lỗi xóa hóa đơn: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi xóa hóa đơn'], 500);
        }
    }

    public function payByTransfer($id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
        }

        if ($invoice->status == 2) {
            return response()->json(['message' => 'Hóa đơn đã được thanh toán'], 400);
        }

        $paymentUrl = $this->createPayOSPayment($invoice->id);

        return response()->json([
            'message' => 'Tạo thanh toán thành công',
            'payment_url' => $paymentUrl,
            'amount' => $invoice->total
        ]);
    }

    public function createPayOSPayment($invoiceId)
    {
        try {
            $invoice = Invoice::with('invoiceFoods.food')->findOrFail($invoiceId);

            if (!$invoice) {
                return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
            }

            $clientId = env('PAYOS_CLIENT_ID');
            $apiKey = env('PAYOS_API_KEY');
            $checksumKey = env('PAYOS_CHECKSUM_KEY');
            $payOS = new PayOS(
                clientId: $clientId,
                apiKey: $apiKey,
                checksumKey: $checksumKey
            );

            $items = $invoice->invoiceFoods->map(function ($invoiceFood) {
                return [
                    'name' => $invoiceFood->food->name ?? 'Không rõ tên',
                    'quantity' => (int) $invoiceFood->quantity,
                    'price' => (int) ($invoiceFood->price ?? $invoiceFood->food->cost), // Sử dụng price từ InvoiceFood
                ];
            })->toArray();

            $body = [
                'orderCode' => rand(0, 99999),
                'amount' => (int) $invoice->total,
                'description' => 'Thanh toán hóa đơn #' . $invoiceId . ($invoice->note ? ' - Ghi chú: ' . $invoice->note : ''),
                'items' => $items,
                'returnUrl' => 'http://172.20.10.3:3000/?status=success',
                'cancelUrl' => 'http://172.20.10.3:3000/?status=error',
            ];

            $response = $payOS->createPaymentLink($body);

            return $response['checkoutUrl'];
        } catch (\Exception $e) {
            Log::error('Lỗi tạo liên kết thanh toán PayOS: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi tạo liên kết thanh toán'], 500);
        }
    }

    public function handlePayOSCallback(Request $request)
    {
        try {
            $orderCode = $request->input('orderCode');
            $status = $request->input('status');

            if (!$orderCode || !$status) {
                return response()->json(['message' => 'Thiếu thông tin thanh toán'], 400);
            }

            $booking = Booking::find($orderCode);
            if (!$booking) {
                return response()->json(['message' => 'Không tìm thấy đặt bàn'], 404);
            }

            if ($booking->status == 2) {
                return response()->json(['message' => 'Đặt bàn đã được thanh toán trước đó'], 200);
            }

            if (in_array($status, ['PAID', 'SUCCESS'])) {
                $booking->status = 2;
                $booking->save();

                return response()->json(['message' => 'Thanh toán đặt bàn thành công'], 200);
            }

            return response()->json(['message' => 'Thanh toán không thành công'], 400);
        } catch (\Exception $e) {
            Log::error('Lỗi xử lý callback PayOS: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi xử lý callback thanh toán'], 500);
        }
    }

    public function handlePaymentResult(Request $request)
    {
        try {
            $orderCode = $request->input('orderCode');
            $status = $request->input('status');

            if (!$orderCode || !$status) {
                return response()->json(['message' => 'Thiếu thông tin thanh toán'], 400);
            }

            $invoice = Invoice::find($orderCode);
            if (!$invoice) {
                return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
            }

            if ($invoice->status == 1) {
                return response()->json(['message' => 'Hóa đơn đã được thanh toán trước đó'], 200);
            }

            if ($status === 'PAID' || $status === 'SUCCESS') {
                $invoice->status = 1;
                $invoice->save();

                Cart::where('id_table', $invoice->id_table)->delete();

                return response()->json(['message' => 'Thanh toán thành công, giỏ hàng đã được xóa'], 200);
            }

            return response()->json(['message' => 'Thanh toán không thành công'], 400);
        } catch (\Exception $e) {
            Log::error('Lỗi xử lý kết quả thanh toán: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi xử lý kết quả thanh toán'], 500);
        }
    }

    public function clearCartByInvoice($invoiceId)
    {
        try {
            $invoice = Invoice::find($invoiceId);

            if (!$invoice) {
                return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
            }

            Cart::where('id_table', $invoice->id_table)->delete();

            return response()->json(['message' => 'Đã xóa giỏ hàng liên quan đến hóa đơn']);
        } catch (\Exception $e) {
            Log::error('Lỗi xóa giỏ hàng theo hóa đơn: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi xóa giỏ hàng'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $cartItem = Cart::find($id);
            if (!$cartItem) {
                return response()->json(['message' => 'Không tìm thấy món trong giỏ hàng'], 404);
            }

            $cartItem->delete();

            return response()->json(['message' => 'Xóa món khỏi giỏ hàng thành công']);
        } catch (\Exception $e) {
            Log::error('Lỗi xóa món trong giỏ hàng: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi xóa món trong giỏ hàng'], 500);
        }
    }
}
