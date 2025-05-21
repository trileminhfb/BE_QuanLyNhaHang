<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use App\Http\Requests\SaleRequest;
use Illuminate\Support\Carbon;

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

    // Lấy danh sách các chương trình khuyến mãi đang hoạt động (status = 1)
    public function activeSales()
    {
        $activeSales = Sale::where('status', 1)->get();

        return response()->json([
            'status' => 1,
            'data' => $activeSales
        ]);
    }

    // Tạo mới một chương trình khuyến mãi
    public function store(Request $request)
    {
        // Kiểm tra thời gian
        if (strtotime($request->startTime) >= strtotime($request->endTime)) {
            return response()->json([
                'message' => 'Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc.'
            ], 400);
        }

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

        // Kiểm tra thời gian
        if (strtotime($request->startTime) >= strtotime($request->endTime)) {
            return response()->json([
                'message' => 'Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc.'
            ], 400);
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
