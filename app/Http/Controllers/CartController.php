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
    public function store(Request $request)
    {
        $request->validate([
            'id_food' => 'required|integer',
            'id_table' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::create($request->all());
        return response()->json($cart, 201);
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
