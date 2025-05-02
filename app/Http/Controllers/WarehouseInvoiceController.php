<?php

namespace App\Http\Controllers;

use App\Models\WarehouseInvoice;
use App\Http\Requests\WarehouseInvoiceRequest;
use Illuminate\Http\Request;

class WarehouseInvoiceController extends Controller
{
    // Lấy danh sách hóa đơn kho
    public function getData()
    {
        $invoices = WarehouseInvoice::with('ingredient')->get();
        return response()->json([
            'status' => 1,
            'data' => $invoices
        ]);
    }

    //Lấy hóa đơn kho theo ID
    public function show($id)
    {
        $invoice = WarehouseInvoice::with('ingredient')->find($id);

        if (!$invoice) {
            return response()->json([
                'status' => 0,
                'message' => 'Hóa đơn kho không tồn tại.'
            ]);
        }

        return response()->json([
            'status' => 1,
            'data' => $invoice
        ]);
    }

    // Thêm mới hóa đơn kho
    public function store(WarehouseInvoiceRequest $request)
    {
        $invoice = WarehouseInvoice::create([
            'id_ingredient' => $request->id_ingredient,
            'quantity'      => $request->quantity,
            'price'         => $request->price,
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Thêm mới hóa đơn kho thành công.',
            'data'    => $invoice
        ]);
    }

    // Cập nhật hóa đơn kho
    public function update(WarehouseInvoiceRequest $request, $id)
    {
        $invoice = WarehouseInvoice::find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Hóa đơn kho không tồn tại.']);
        }

        $invoice->update([
            'id_ingredient' => $request->id_ingredient,
            'quantity'      => $request->quantity,
            'price'         => $request->price,
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Cập nhật hóa đơn kho thành công.',
            'data'    => $invoice
        ]);
    }

    // Xóa hóa đơn kho
    public function destroy($id)
    {
        $invoice = WarehouseInvoice::find($id);

        if (!$invoice) {
            return response()->json([
                'status' => 0,
                'message' => 'Hóa đơn kho không tồn tại.'
            ]);
        }

        $invoice->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Xóa hóa đơn kho thành công.'
        ]);
    }

    // Tìm kiếm hóa đơn kho
    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $invoices = WarehouseInvoice::where('id_ingredient', $keyword)
            ->orWhereHas('ingredient', function ($query) use ($keyword) {
                $query->where('name_ingredient', 'like', '%' . $keyword . '%');
            })
            ->get();

        return response()->json([
            'status' => 1,
            'data' => $invoices
        ]);
    }
}
