<?php

namespace App\Http\Controllers;

use App\Models\SaleReportFood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleReportFoodController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 1,
            'data' => SaleReportFood::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_sale_report' => 'required|exists:sale_reports,id',
            'id_food'        => 'required|exists:foods,id',
            'quantity'       => 'required|integer',
            'total_price'    => 'required|numeric',
        ]);

        $item = SaleReportFood::create([
            'id_sale_report' => $request->id_sale_report,
            'id_food'        => $request->id_food,
            'quantity'       => $request->quantity,
            'total_price'    => $request->total_price
        ]);

        return response()->json([
            'message' => 'Sale report food created successfully',
            'data'    => $item
        ], 201);
    }

    public function show($id)
    {
        $item = SaleReportFood::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        return response()->json([
            'status' => 1,
            'data'   => $item
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = SaleReportFood::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->update([
            'id_sale_report' => $request->id_sale_report,
            'id_food'        => $request->id_food,
            'quantity'       => $request->quantity,
            'total_price'    => $request->total_price
        ]);

        return response()->json([
            'message' => 'Item updated successfully',
            'data'    => $item
        ]);
    }

    public function destroy($id)
    {
        $item = SaleReportFood::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Item deleted successfully']);
    }

    public function generateReportFoods(Request $request)
    {
        $request->validate([
            'id_sale_report' => 'required|exists:sale_reports,id',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date'
        ]);

        $reportData = DB::table('invoice_food as ifd')
            ->join('invoices as i', 'i.id', '=', 'ifd.id_invoice')
            ->join('foods as f', 'f.id', '=', 'ifd.id_food')  // Chỉnh sửa từ 'food' thành 'foods'
            ->whereBetween('i.timeEnd', [$request->start_date, $request->end_date])
            ->select(
                'f.id as id_food',
                DB::raw('SUM(ifd.quantity) as quantity'),
                DB::raw('SUM(ifd.quantity * f.cost) as total_price')
            )
            ->groupBy('f.id')
            ->get();

        $inserted = [];
        foreach ($reportData as $item) {
            $inserted[] = SaleReportFood::create([
                'id_sale_report' => $request->id_sale_report,
                'id_food'        => $item->id_food,
                'quantity'       => $item->quantity,
                'total_price'    => $item->total_price,
            ]);
        }

        return response()->json([
            'message' => 'Generated sale report food successfully',
            'data'    => $inserted,
        ]);
    }
}
