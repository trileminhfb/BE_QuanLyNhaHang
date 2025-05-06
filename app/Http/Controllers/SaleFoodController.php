<?php

namespace App\Http\Controllers;

use App\Models\Sale_food;
use App\Http\Requests\SaleFoodRequest;
use Illuminate\Http\Request;

class SaleFoodController extends Controller
{
    // Lấy danh sách tất cả các món ăn trong các chương trình khuyến mãi
    public function index()
{
    return response()->json([
        'status' => 1,
        'data' => Sale_food::all()
    ], 200);
}
public function store(Request $request)
{
    $validated = $request->validate([
        'id_food' => 'required|exists:foods,id',
        'id_sale' => 'required|exists:sales,id',
    ]);

    $saleFood = new Sale_food();
    $saleFood->id_food = $validated['id_food'];
    $saleFood->id_sale = $validated['id_sale'];

    if ($saleFood->save()) {
        return response()->json([
            'status' => 1,
            'message' => 'Tạo món ăn khuyến mãi thành công.',
            'data' => $saleFood
        ], 201);
    }

    return response()->json([
        'status' => 0,
        'message' => 'Không thể lưu vào cơ sở dữ liệu.',
    ], 500);
}


// Hiển thị chi tiết món ăn khuyến mãi
public function show($id)
{
    $saleFood = Sale_food::find($id);

    if (!$saleFood) {
        return response()->json([
            'status' => 0,
            'message' => 'Không tìm thấy món ăn khuyến mãi.'
        ], 404);
    }

    return response()->json([
        'status' => 1,
        'data' => $saleFood
    ], 200);
}

// Cập nhật món ăn khuyến mãi
public function update(Request $request, $id)
{
    $saleFood = Sale_food::find($id);

    if (!$saleFood) {
        return response()->json([
            'status' => 0,
            'message' => 'Không tìm thấy món ăn khuyến mãi.'
        ], 404);
    }

    $saleFood->update($request->validate([
        'id_food' => 'required|exists:foods,id',
        'id_sale' => 'required|exists:sales,id',

    ]));

    return response()->json([
        'status' => 1,
        'message' => 'Cập nhật món ăn khuyến mãi thành công.',
        'data' => $saleFood
    ]);
}

// Xóa món ăn khuyến mãi
public function destroy($id)
{
    $saleFood = Sale_food::find($id);

    if (!$saleFood) {
        return response()->json([
            'status' => 0,
            'message' => 'Không tìm thấy món ăn khuyến mãi.'
        ], 404);
    }

    $saleFood->delete();

    return response()->json([
        'status' => 1,
        'message' => 'Xóa món ăn khuyến mãi thành công.'
    ], 200);
}


}
