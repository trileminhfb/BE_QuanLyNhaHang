<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;
use App\Models\Food;
use App\Models\InvoiceFood;
use App\Models\Sale;
use Illuminate\Support\Carbon;

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
            ])->get(); // ngắn gọn

            return response()->json([
                'data' => $invoices
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy danh sách hóa đơn: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi khi lấy danh sách hóa đơn'], 500);
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

            $total = 0;

            foreach ($carts as $cart) {
                $food = Food::find($cart->id_food);

                if (!$food) {
                    return response()->json(['message' => "Món ăn với ID {$cart->id_food} không tồn tại."], 400);
                }

                $total += $cart['quantity'] * $food->cost;
            }

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
                'status' => 0,
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
            'status' => 'nullable|in:0,1,2',
        ]);

        try {
            $invoice = Invoice::find($id);

            if (!$invoice) {
                return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
            }

            $invoice->update($validated);

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
        } catch (\Exception $e) {
            Log::error('Lỗi xóa hóa đơn: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi xóa hóa đơn'], 500);
        }
    }
}
