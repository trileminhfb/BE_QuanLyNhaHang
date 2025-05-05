<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Http\Requests\SaleRequest;
use Illuminate\Http\Request;

class SaleController extends Controller
{
     // Lấy danh sách tất cả các chương trình khuyến mãi
     public function index()
    {
        return response()->json([
            'status' => 1,
            'data' => Sale::all()
        ]);
    }

    // Tạo mới một chương trình khuyến mãi
    public function store(Request $request)
    {
        $sale = Sale::create([
            'nameSale'  => $request->nameSale,
            'status'    => $request->status ?? 1,
            'startTime' => $request->startTime,
            'endTime'   => $request->endTime,
            'percent'   => $request->percent
        ]);

        return response()->json([
            'message' => 'Sale created successfully',
            'sale'    => $sale
        ], 201);
    }

    // Hiển thị chi tiết chương trình khuyến mãi theo ID
    public function show($id)
    {
        $sale = Sale::find($id);

        if (!$sale) {
            return response()->json(['message' => 'Sale not found'], 404);
        }

        return response()->json([
            'status' => 1,
            'message' => 'Lấy thông tin thành công.',
            'data' => $sale
        ]);
    }

    // Cập nhật thông tin chương trình khuyến mãi
    public function update(Request $request, $id)
    {
        $sale = Sale::find($id);

        if (!$sale) {
            return response()->json(['message' => 'Sale not found'], 404);
        }

        $sale->update([
            'nameSale'  => $request->nameSale,
            'status'    => $request->status ?? 1,
            'startTime' => $request->startTime,
            'endTime'   => $request->endTime,
            'percent'   => $request->percent
        ]);

        return response()->json([
            'message' => 'Sale updated successfully',
            'sale'    => $sale
        ], 200);
    }

    // Xoá chương trình khuyến mãi theo ID
    public function destroy($id)
    {
        $sale = Sale::find($id);

        if (!$sale) {
            return response()->json(['message' => 'Sale not found'], 404);
        }

        $sale->delete();

        return response()->json(['message' => 'Sale deleted successfully'], 200);
    }

}
