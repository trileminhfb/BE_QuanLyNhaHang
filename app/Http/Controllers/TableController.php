<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Http\Requests\TableRequest;

class TableController extends Controller
{
    // Lấy danh sách tất cả các bàn
    public function index()
    {
        $tables = Table::all();
        return response()->json($tables, 200);
    }

    // Tạo mới một bàn
    public function store(TableRequest $request)
    {
        $table = Table::create($request->validated());

        return response()->json([
            'message' => 'Table created successfully',
            'table'   => $table
        ], 201);
    }

    // Hiển thị chi tiết bàn theo ID
    public function show($id)
    {
        $table = Table::find($id);

        if (!$table) {
            return response()->json(['message' => 'Table not found'], 404);
        }

        return response()->json($table, 200);
    }

    // Cập nhật thông tin bàn
    public function update(TableRequest $request, $id)
    {
        $table = Table::find($id);

        if (!$table) {
            return response()->json(['message' => 'Table not found'], 404);
        }

        $table->update($request->validated());

        return response()->json([
            'message' => 'Table updated successfully',
            'table'   => $table
        ], 200);
    }

    // Xoá bàn theo ID
    public function destroy($id)
    {
        $table = Table::find($id);

        if (!$table) {
            return response()->json(['message' => 'Table not found'], 404);
        }

        $table->delete();

        return response()->json(['message' => 'Table deleted successfully'], 200);
    }
}
