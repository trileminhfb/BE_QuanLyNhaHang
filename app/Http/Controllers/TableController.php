<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Http\Requests\TableRequest;
use Illuminate\Http\Request;

class TableController extends Controller
{
    // Lấy danh sách tất cả các bàn
    // Lấy danh sách tất cả các bàn
    public function index()
    {
        return response()->json([
            'status' => 1,
            'data' => Table::all()
        ]);
    }

    // Tạo mới một bàn
    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|integer',
            'status' => 'required|integer'
        ]);

        $table = Table::create($validated);

        return response()->json([
            'status' => 1,
            'message' => 'Tạo bàn thành công.',
            'data' => $table
        ]);
    }


    // Hiển thị chi tiết bàn theo ID
    public function show($id)
    {
        $table = Table::find($id);

        if (!$table) {
            return response()->json([
                'status' => 0,
                'message' => 'Không tìm thấy bàn.'
            ], 404);
        }

        return response()->json([
            'status' => 1,
            'data' => $table
        ]);
    }


    // Cập nhật thông tin bàn
    public function update(Request $request, $id)
    {
        $table = Table::find($id);

        if (!$table) {
            return response()->json([
                'status' => 0,
                'message' => 'Không tìm thấy bàn.'
            ], 404);
        }

        $validated = $request->validate([
            'number' => 'required|integer',
            'status' => 'required|integer'
        ]);

        $table->update($validated);

        return response()->json([
            'status' => 1,
            'message' => 'Cập nhật bàn thành công.',
            'data' => $table
        ]);
    }


    // Xoá bàn theo ID
    public function destroy($id)
    {
        $table = Table::find($id);

        if (!$table) {
            return response()->json([
                'status' => 0,
                'message' => 'Không tìm thấy bàn.'
            ], 404);
        }

        $table->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Xoá bàn thành công.'
        ]);
    }

}
