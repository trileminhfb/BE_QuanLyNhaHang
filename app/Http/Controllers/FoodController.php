<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Http\Requests\FoodRequest;
use Illuminate\Http\Request;

class FoodController extends Controller
{

    public function index()
    {
        return response()->json([
            'status' => 1,
            'data' => Food::all()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'id_type' => 'required|integer',
                'id_category' => 'required|integer',
                'cost' => 'required|numeric',
                'detail' => 'nullable|string',
                'status' => 'required|boolean',
                'bestSeller' => 'nullable|boolean'
            ]);
            $food = Food::create($validated);

            return response()->json([
                'status'  => 1,
                'message' => 'Tạo món ăn thành công.',
                'data'    => $food
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Đã xảy ra lỗi khi tạo món ăn.',
                'error'   => $e->getMessage()
            ], 500);
        }

    }

    public function show($id)
{
    $food = Food::find($id);
    if (!$food) {
        return response()->json([
            'status' => 0,
            'message' => 'Không tìm thấy món ăn.'
        ], 404);
    }

    return response()->json([
        'status' => 1,
        'message' => 'Lấy thông tin món ăn thành công.',
        'data' => $food
    ]);
}

    public function update(Request $request, $id)
    {
        $food = Food::findOrFail($id);

        $food->update($request->validate([
            'name' => 'required|string|max:255',
            'id_type' => 'required|integer',
            'id_category' => 'required|integer',
            'cost' => 'required|numeric',
            'detail' => 'nullable|string',
            'status' => 'required|boolean',
            'bestSeller' => 'nullable|boolean'
        ]));

        return response()->json([
            'status' => 1,
            'message' => 'Cập nhật món ăn thành công.',
            'data' => $food
        ]);
    }

    public function destroy($id)
    {
        $food = Food::findOrFail($id);
        $food->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Xóa món ăn thành công.'
        ]);
    }

    public function sales($id)
    {
        $food = Food::findOrFail($id);
        return response()->json([
            'status' => 1,
            'sales' => $food->sales
        ]);
    }

    public function category($id)
    {
        $food = Food::findOrFail($id);
        return response()->json([
            'status' => 1,
            'category' => $food->category
        ]);
    }

    public function type($id)
    {
        $food = Food::findOrFail($id);
        return response()->json([
            'status' => 1,
            'type' => $food->type
        ]);
    }
}
