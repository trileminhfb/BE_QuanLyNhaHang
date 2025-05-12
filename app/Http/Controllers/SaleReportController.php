<?php

namespace App\Http\Controllers;

use App\Models\SaleReport;
use Illuminate\Http\Request;

class SaleReportController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 1,
            'data' => SaleReport::with('foods')->get()
        ]);
    }

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
            'message' => 'Sale report created successfully',
            'data'    => $report
        ], 201);
    }

    public function show($id)
    {
        $report = SaleReport::with('foods')->find($id);

        if (!$report) {
            return response()->json(['message' => 'Sale report not found'], 404);
        }

        return response()->json([
            'status' => 1,
            'data'   => $report
        ]);
    }

    public function update(Request $request, $id)
    {
        $report = SaleReport::find($id);

        if (!$report) {
            return response()->json(['message' => 'Sale report not found'], 404);
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
            'message' => 'Sale report updated successfully',
            'data'    => $report
        ]);
    }

    public function destroy($id)
    {
        $report = SaleReport::find($id);

        if (!$report) {
            return response()->json(['message' => 'Sale report not found'], 404);
        }

        $report->delete();

        return response()->json(['message' => 'Sale report deleted successfully']);
    }
}

