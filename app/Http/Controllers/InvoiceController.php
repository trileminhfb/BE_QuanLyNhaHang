<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\FacadesDB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;
use App\Models\Food;
use App\Models\InvoiceFood;
use App\Models\Sale;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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
                ->get();

            if ($invoices->isEmpty()) {
                return response()->json([
                    'message' => 'Không tìm thấy hóa đơn nào cho khách hàng này.'
                ], 404);
            }

            return response()->json([
                'data' => $invoices
            ], 200);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy hóa đơn theo khách hàng: ' . $e->getMessage());
            return response()->json([
                'error' => 'Lỗi khi lấy hóa đơn: ' . $e->getMessage() // log ra lỗi thật
            ], 500);
        }
    }

    public function store(InvoiceRequest $request)
    {
        DB::beginTransaction();
        try {
            $idTable = $request->id_table;
            $user = $request->user();
            $role = $user->role ?? 'guest';

            $carts = Cart::where('id_table', $idTable)->get();

            if ($carts->isEmpty()) {
                return response()->json(['message' => 'Không có món nào trong giỏ hàng'], 400);
            }

            // $total = 0;
            // foreach ($carts as $cart) {
            //     $food = Food::find($cart->id_food);
            //     if (!$food) {
            //         return response()->json(['message' => "Món ăn với ID {$cart->id_food} không tồn tại."], 400);
            //     }
            //     $total += $cart['quantity'] * $food->cost;
            // }
            $total = $request->input('total', 0);

            $idSale = null;
            $discountPercent = 0;

            if ($request->filled('nameSale')) {
                $sale = Sale::where('nameSale', $request->nameSale)->first();
                if ($sale) {
                    $discountPercent = $sale->percent;
                    $idSale = $sale->id;
                    $total -= ($total * $discountPercent / 100);
                }
            }

            $invoice = Invoice::create([
                'id_table' => $idTable,
                'timeEnd' => Carbon::now(),
                'total' => $total,
                'id_user' => $role === 'staff' ? $user->id : null,
                'id_customer' => $role === 'customer' ? $user->id : null,
                'id_sale' => $idSale,
                'status' => 1,
            ]);

            foreach ($carts as $cart) {
                InvoiceFood::create([
                    'id_invoice' => $invoice->id,
                    'id_food' => $cart->id_food,
                    'quantity' => $cart->quantity,
                ]);
            }

            Cart::where('id_table', $idTable)->delete();

            DB::commit();

            return response()->json([
                'message' => 'Tạo hóa đơn thành công',
                'data' => $invoice
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

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
            'id_customer' => 'required|exists:customers,id',
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

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:1,2,3',
        ]);

        try {
            $invoice = Invoice::find($id);

            if (!$invoice) {
                return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
            }

            $invoice->status = $validated['status'];
            $invoice->save();

            return response()->json([
                'message' => 'Cập nhật trạng thái hóa đơn thành công',
                'invoice' => $invoice
            ], 200);
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật trạng thái hóa đơn: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi cập nhật trạng thái hóa đơn'], 500);
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

        $amount = $invoice->total;

        $paymentUrl = $this->createPayOSPayment($invoice->id);

        return response()->json([
            'message' => 'Tạo thanh toán thành công',
            'payment_url' => $paymentUrl,
            'amount' => $amount
        ]);
    }
    public function createPayOSPayment($invoiceId)
    {
        $invoice = Invoice::with('foods')->findOrFail($invoiceId);
        $foods = $invoice->foods;

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
        $amount = $invoice->total;

        $items = $foods->map(function ($food) {
            return [
                'name' => $food->name,
                'quantity' => $food->pivot->quantity,
                'price' => $food->cost,
            ];
        })->toArray();

        $body = [
            'orderCode' => (int) (time() . rand(10, 99)),
            'amount' => (int) 2000,
            'description' => 'Thanh toán hóa đơn #' . $invoiceId,
            "items" => $items,
            'returnUrl' => 'http://localhost:5173/?status=success',
            'cancelUrl' => 'http://localhost:5173/?status=error',
        ];

        $response = $payOS->createPaymentLink($body);

        return $response['checkoutUrl'];
    }
    public function handlePayOSCallback(Request $request)
    {
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

        if (in_array($status, ['PAID', 'SUCCESS'])) {
            $invoice->status = 1;
            $invoice->save();

            Cart::where('user_id', $invoice->user_id)->delete();

            return response()->json(['message' => 'Thanh toán thành công, đã xóa giỏ hàng'], 200);
        }

        return response()->json(['message' => 'Thanh toán không thành công'], 400);
    }

    public function handlePaymentResult(Request $request)
    {
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

            Cart::where('invoice_id', $invoice->id)->delete();

            return response()->json(['message' => 'Thanh toán thành công, giỏ hàng đã được xóa'], 200);
        }

        return response()->json(['message' => 'Thanh toán không thành công'], 400);
    }

    public function clearCartByInvoice($invoiceId)
    {
        $invoice = Invoice::with('cartItems')->find($invoiceId);

        if (!$invoice) {
            return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
        }

        Cart::where('invoice_id', $invoiceId)->delete();

        return response()->json(['message' => 'Đã xóa giỏ hàng liên quan đến hóa đơn']);
    }

    public function destroy($id)
    {
        $cartItem = Cart::find($id);
        if (!$cartItem) {
            return response()->json(['message' => 'Không tìm thấy món trong giỏ hàng'], 404);
        }

        $cartItem->delete();

        return response()->json(['message' => 'Xóa món khỏi giỏ hàng thành công']);
    }
}
