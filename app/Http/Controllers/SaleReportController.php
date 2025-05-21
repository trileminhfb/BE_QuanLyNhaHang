<?php

namespace App\Http\Controllers;

use App\Models\SaleReport;
use Illuminate\Http\Request;

class SaleReportController extends Controller
{
    // Lấy danh sách tất cả báo cáo doanh thu
    public function index()
    {
        return response()->json([
            'status' => 1,
            'message' => 'Lấy danh sách báo cáo thành công.',
            'data' => SaleReport::all()
        ]);
    }

    // Tạo mới báo cáo doanh thu
    public function store(Request $request)
    {
        $report = SaleReport::create([
            'report_type'       => $request->report_type,
            'report_date'       => $request->report_date,
            'total_revenue'     => $request->total_revenue,
            'total_orders'      => $request->total_orders,
            'top_food_name'     => $request->top_food_name,
            'top_food_quantity' => $request->top_food_quantity ?? 0,
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Tạo báo cáo doanh thu thành công.',
            'data' => $report
        ], 201);
    }

    // Hiển thị chi tiết báo cáo theo ID
    public function show($id)
    {
        $report = SaleReport::find($id);

        if (!$report) {
            return response()->json([
                'status' => 0,
                'message' => 'Không tìm thấy báo cáo doanh thu.'
            ], 404);
        }

        return response()->json([
            'status' => 1,
            'message' => 'Lấy thông tin báo cáo thành công.',
            'data' => $report
        ]);
    }

    // Cập nhật báo cáo doanh thu
    public function update(Request $request, $id)
    {
        $report = SaleReport::find($id);

        if (!$report) {
            return response()->json([
                'status' => 0,
                'message' => 'Không tìm thấy báo cáo doanh thu.'
            ], 404);
        }

        $report->update([
            'report_type'       => $request->report_type,
            'report_date'       => $request->report_date,
            'total_revenue'     => $request->total_revenue,
            'total_orders'      => $request->total_orders,
            'top_food_name'     => $request->top_food_name,
            'top_food_quantity' => $request->top_food_quantity ?? 0,
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Cập nhật báo cáo doanh thu thành công.',
            'data' => $report
        ]);
    }

    // Xoá báo cáo doanh thu theo ID
    public function destroy($id)
    {
        $report = SaleReport::find($id);

        if (!$report) {
            return response()->json([
                'status' => 0,
                'message' => 'Không tìm thấy báo cáo doanh thu.'
            ], 404);
        }

        $report->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Xoá báo cáo doanh thu thành công.'
        ]);
    }
}
