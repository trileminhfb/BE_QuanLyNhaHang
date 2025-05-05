<?php

namespace App\Http\Controllers;

use App\Models\CategoryFood;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryFoodRequest;

class CategoryFoodController extends Controller
{
    // Lấy danh sách
    public function getData()
    {
        $data = CategoryFood::all();

        return response()->json([
            'status' => 1,
            'data'   => $data
        ]);
    }

    // Tạo mới
    public function store(CategoryFoodRequest $request)
    {
        $item = CategoryFood::create([
            'id_category' => $request->id_category,
            'id_food'     => $request->id_food,
        ]);

        return response()->json([
            'status'  => 1,
            'message' => 'Tạo thành công.',
            'data'    => $item
        ]);
    }

    // Cập nhật
    public function update(CategoryFoodRequest $request, $id)
    {
        $item = CategoryFood::find($id);

        if (!$item) {
            return response()->json([
                'status'  => 0,
                'message' => 'Không tìm thấy bản ghi.'
            ]);
        }

        $item->update([
            'id_category' => $request->id_category,
            'id_food'     => $request->id_food,
        ]);

        return response()->json([
            'status'  => 1,
            'message' => 'Cập nhật thành công.',
            'data'    => $item
        ]);
    }

    // Xoá
    public function destroy($id)
    {
        $item = CategoryFood::find($id);

        if (!$item) {
            return response()->json([
                'status'  => 0,
                'message' => 'Không tìm thấy bản ghi.'
            ]);
        }

        $item->delete();

        return response()->json([
            'status'  => 1,
            'message' => 'Xoá thành công.'
        ]);
    }

    // Tìm theo ID
    public function findById($id)
    {
        $item = CategoryFood::find($id);

        if (!$item) {
            return response()->json([
                'status'  => 0,
                'message' => 'Không tìm thấy bản ghi.'
            ]);
        }

        return response()->json([
            'status' => 1,
            'data'   => $item
        ]);
    }
}
