<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    // Lấy danh sách hóa đơn
    public function index()
    {
        $invoices = Invoice::all();
        return response()->json($invoices, 200);
    }

    // Tạo hóa đơn mới với InvoiceRequest
    public function store(InvoiceRequest $request)
    {
        $invoice = Invoice::create($request->validated());

        return response()->json([
            'message' => 'Invoice created successfully',
            'invoice' => $invoice
        ], 201);
    }

    // Hiển thị hóa đơn theo ID
    public function show($id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        return response()->json($invoice, 200);
    }

    // Cập nhật hóa đơn
    public function update(Request $request, $id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $invoice->update([
            'id_booking' => $request->id_booking,
            'timeEnd'    => $request->timeEnd,
            'total'      => $request->total,
            'id_user'    => $request->id_user,
        ]);

        return response()->json([
            'message' => 'Invoice updated successfully',
            'invoice' => $invoice
        ], 200);
    }


    // Xoá hóa đơn
    public function delete($id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $invoice->delete();

        return response()->json(['message' => 'Invoice deleted successfully'], 200);
    }
}
