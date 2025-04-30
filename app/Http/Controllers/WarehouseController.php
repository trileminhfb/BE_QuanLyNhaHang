<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Http\Requests\WarehouseRequest;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function getData()
    {
        $warehouses = Warehouse::all();
        return response()->json($warehouses);
    }

    public function store(WarehouseRequest $request)
    {
        $warehouse = Warehouse::create([
            'id_ingredient' => $request->id_ingredient,
            'quantity'      => $request->quantity,
        ]);

        return response()->json([
            'message' => 'Thêm mới kho thành công.',
            'data'    => $warehouse
        ]);
    }

    public function update(WarehouseRequest $request, $id)
    {
        $warehouse = Warehouse::where('id', $id)->get()->first();

        if (!$warehouse) {
            return response()->json(['message' => 'Kho không tồn tại.'], 404);
        }

        $warehouse->update([
            'id_ingredient' => $request->id_ingredient,
            'quantity'      => $request->quantity,
        ]);

        return response()->json([
            'message' => 'Cập nhật kho thành công.',
            'data'    => $warehouse
        ]);
    }

    public function destroy($id)
    {
        $warehouse = Warehouse::where('id', $id)->get()->first();

        if (!$warehouse) {
            return response()->json(['message' => 'Kho không tồn tại.'], 404);
        }

        $warehouse->delete();

        return response()->json(['message' => 'Xóa kho thành công.']);
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $warehouses = Warehouse::where('id_ingredient', 'like', '%' . $keyword . '%')
                               ->get();

        return response()->json($warehouses);
    }
}
