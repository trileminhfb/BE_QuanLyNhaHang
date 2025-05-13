<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    // Lấy toàn bộ giỏ hàng
    public function index()
    {
        return response()->json(Cart::all(), 200);
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


    // Lấy thông tin chi tiết một cart
    public function show($id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }
        return response()->json($cart);
    }

    // Cập nhật một cart
    // fix: bắt điều kiện tại, lỡ như cập nhật số lượng âm
    public function update(Request $request, $id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $cart->update($request->all());
        return response()->json($cart);
    }

    // Xóa một cart
    public function destroy($id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $cart->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
