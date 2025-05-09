<?php

namespace App\Http\Controllers;

use App\Models\SaleReportFood;
use Illuminate\Http\Request;

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
}

