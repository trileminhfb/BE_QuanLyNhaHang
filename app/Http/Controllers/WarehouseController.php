<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Http\Requests\WarehouseRequest;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    // Lấy danh sách kho
    public function getData()
    {
        $warehouses = Warehouse::all();

        return response()->json([
            'status' => 1,
            'data' => $warehouses
        ]);
    }

    // Thêm mới kho
    public function store(WarehouseRequest $request)
    {
        $warehouse = Warehouse::create([
            'id_ingredient' => $request->id_ingredient,
            'quantity'      => $request->quantity,
        ]);

        return response()->json([
            'status'  => 1,
            'message' => 'Thêm mới kho thành công.',
            'data'    => $warehouse
        ]);
    }

    // Cập nhật kho
    public function update(WarehouseRequest $request, $id)
    {
        $warehouse = Warehouse::find($id);

        if (!$warehouse) {
            return response()->json([
                'status' => 0,
                'message' => 'Kho không tồn tại.'
            ]);
        }

        $warehouse->update([
            'id_ingredient' => $request->id_ingredient,
            'quantity'      => $request->quantity,
        ]);

        return response()->json([
            'status'  => 1,
            'message' => 'Cập nhật kho thành công.',
            'data'    => $warehouse
        ]);
    }

    // Xóa kho
    public function destroy($id)
    {
        $warehouse = Warehouse::find($id);

        if (!$warehouse) {
            return response()->json([
                'status' => 0,
                'message' => 'Kho không tồn tại.'
            ]);
        }

        $warehouse->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Xóa kho thành công.'
        ]);
    }

    // Tìm kiếm kho theo ID nguyên liệu
    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $warehouses = Warehouse::when($keyword, function ($query, $keyword) {
            return $query->where('id_ingredient', 'like', '%' . $keyword . '%');
        })->get();

        return response()->json([
            'status' => 1,
            'data' => $warehouses
        ]);
    }
}
