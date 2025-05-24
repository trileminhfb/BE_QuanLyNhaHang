<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    // Lấy toàn bộ giỏ hàng
    public function index()
    {
        $carts = Cart::with('food')->get();

        $formatted = $carts->map(function ($cart) {
            return [
                'id' => $cart->id,
                'id_table' => $cart->id_table,
                'quantity' => $cart->quantity,
                'created_at' => $cart->created_at,
                'updated_at' => $cart->updated_at,
                'food' => $cart->food ? [
                    'id' => $cart->food->id,
                    'name' => $cart->food->name,
                    'cost' => $cart->food->cost,
                    'image' => $cart->food->image,
                    'detail' => $cart->food->detail,
                ] : null
            ];
        });
        return response()->json($formatted);
    }

    // Tạo mới 1 giỏ hàng
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'id_food' => 'required|integer',
    //         'id_table' => 'required|integer',
    //         'quantity' => 'required|integer|min:1',
    //     ]);

    //     $cart = Cart::create($request->all());
    //     return response()->json($cart, 201);
    // }
    public function store(Request $request)
    {
        $request->validate([
            'id_food' => 'required|integer',
            'id_table' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);



        // Kiểm tra xem món ăn đã tồn tại trong cart của bàn chưa
        $existingCart = Cart::where('id_food', $request->id_food)
            ->where('id_table', $request->id_table)
            ->first();


        if ($existingCart) {
            // Nếu đã có thì cập nhật số lượng (cộng thêm)
            $existingCart->quantity += $request->quantity;
            $existingCart->save();

            return response()->json([
                'message' => 'Cart updated with new quantity',
                'data' => $existingCart
            ], 200);
        } else {
            // Nếu chưa có thì tạo mới
            $cart = Cart::create($request->all());

            return response()->json([
                'message' => 'Cart created',
                'data' => $cart
            ], 201);
        }
    }

    public function show($id_table)
    {
        $carts = Cart::with('food')->where('id_table', $id_table)->get();

        if ($carts->isEmpty()) {
            return response()->json(['message' => 'Không tìm thấy giỏ hàng cho bàn này'], 404);
        }

        $formatted = $carts->map(function ($cart) {
            return [
                'id' => $cart->id,
                'id_table' => $cart->id_table,
                'quantity' => $cart->quantity,
                'created_at' => $cart->created_at,
                'updated_at' => $cart->updated_at,
                'food' => $cart->food ? [
                    'id' => $cart->food->id,
                    'name' => $cart->food->name,
                    'cost' => $cart->food->cost,
                    'image' => $cart->food->image,
                    'detail' => $cart->food->detail,
                ] : null
            ];
        });

        return response()->json($formatted);
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $cart->update($request->all());
        return response()->json($cart);
    }

    public function destroy($id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $cart->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    public function clearCart()
    {
        $userId = auth()->id();

        Cart::where('user_id', $userId)->delete();

        return response()->json(['message' => 'Đã xóa toàn bộ giỏ hàng'], 200);
    }

    public function destroyByTable($id_table)
    {
        $carts = Cart::where('id_table', $id_table)->get();

        if ($carts->isEmpty()) {
            return response()->json(['message' => 'Không tìm thấy cart nào cho bàn này'], 404);
        }

        foreach ($carts as $cart) {
            $cart->delete();
        }

        return response()->json(['message' => 'Đã xóa tất cả cart theo bàn thành công'], 200);
    }
}
