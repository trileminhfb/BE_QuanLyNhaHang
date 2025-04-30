<?php

namespace App\Http\Controllers;

use App\Models\WarehouseInvoice;
use App\Http\Requests\WarehouseInvoiceRequest;
use Illuminate\Http\Request;

class WarehouseInvoiceController extends Controller
{
    public function getData()
    {
        $invoices = WarehouseInvoice::all();  
        return response()->json($invoices);
    }

    public function store(WarehouseInvoiceRequest $request)
    {
        $invoice = WarehouseInvoice::create([
            'id_ingredient' => $request->id_ingredient,
            'quantity'      => $request->quantity,
            'price'         => $request->price,
        ]);

        return response()->json([
            'message' => 'Thêm mới hóa đơn kho thành công.',
            'data'    => $invoice
        ]);
    }

    public function update(WarehouseInvoiceRequest $request, $id)
    {
        $invoice = WarehouseInvoice::where('id', $id)->get()->first();

        if (!$invoice) {
            return response()->json(['message' => 'Hóa đơn kho không tồn tại.'], 404);
        }

        $invoice->update([
            'id_ingredient' => $request->id_ingredient,
            'quantity'      => $request->quantity,
            'price'         => $request->price,
        ]);

        return response()->json([
            'message' => 'Cập nhật hóa đơn kho thành công.',
            'data'    => $invoice
        ]);
    }

    public function destroy($id)
    {
        $invoice = WarehouseInvoice::where('id', $id)->get()->first();

        if (!$invoice) {
            return response()->json(['message' => 'Hóa đơn kho không tồn tại.'], 404);
        }

        $invoice->delete();

        return response()->json(['message' => 'Xóa hóa đơn kho thành công.']);
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $invoices = WarehouseInvoice::where('id_ingredient', 'like', '%' . $keyword . '%')
                                    ->get();

        return response()->json($invoices);
    }
}
