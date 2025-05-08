<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    // Lấy danh sách tất cả loại món ăn
    public function index()
    {
        return response()->json([
            'status' => 1,
            'data' => Type::all()
        ]);
    }

    // Tạo mới một loại món ăn
    public function store(Request $request)
    {
        try {
            $type = Type::create([
                'status'      => $request->status ?? 1, // Nếu không có giá trị, mặc định là 1
                'name'        => $request->name,
            ]);

            return response()->json([
                'status'  => 1,
                'message' => 'Tạo loại món ăn thành công.',
                'data'    => $type
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 0,
                'message' => 'Đã xảy ra lỗi khi tạo loại món ăn.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }



    // Hiển thị chi tiết loại món ăn theo ID
    public function show($id)
    {
        $type = Type::find($id);

        if (!$type) {
            return response()->json(['message' => 'Type not found'], 404);
        }

        return response()->json([
            'status' => 1,
            'message' => 'Lấy thông tin thành công.',
            'data' => $type
        ]);
    }

    // Cập nhật thông tin loại món ăn
    public function update(Request $request, $id)
    {
        $type = Type::find($id);

        if (!$type) {
            return response()->json(['message' => 'Type not found'], 404);
        }

        try {
            $type->update([
                'status'      => $request->status ?? 1,
                'name'        => $request->name,
            ]);

            return response()->json([
                'message' => 'Type updated successfully',
                'type'    => $type
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating type',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    // Xóa loại món ăn theo ID
    public function destroy($id)
    {
        $type = Type::find($id);

        if (!$type) {
            return response()->json(['message' => 'Type not found'], 404);
        }

        $type->delete();

        return response()->json(['message' => 'Type deleted successfully'], 200);
    }
}
