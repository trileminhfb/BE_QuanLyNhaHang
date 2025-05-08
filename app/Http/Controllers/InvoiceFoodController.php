<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceFoodRequest;
use App\Models\InvoiceFood;

class InvoiceFoodController extends Controller
{
    public function index()
    {
        $data = InvoiceFood::with(['food', 'invoice'])->get();
        return response()->json([
            'message' => 'Lấy danh sách thành công',
            'data' => $data
        ], 200);
    }

    public function store(InvoiceFoodRequest $request)
    {
        $invoiceFood = InvoiceFood::create($request->all());

        return response()->json([
            'message' => 'Tạo mới thành công',
            'data' => $invoiceFood
        ], 201);
    }

    public function show($id)
    {
        $invoiceFood = InvoiceFood::with(['food', 'invoice'])->findOrFail($id);

        return response()->json([
            'message' => 'Lấy dữ liệu chi tiết thành công',
            'data' => $invoiceFood
        ], 200);
    }

    public function update(InvoiceFoodRequest $request, $id)
    {
        $invoiceFood = InvoiceFood::findOrFail($id);
        $invoiceFood->update($request->validated());

        return response()->json([
            'message' => 'Cập nhật thành công',
            'data' => $invoiceFood
        ], 200);
    }

    public function destroy($id)
    {
        $invoiceFood = InvoiceFood::findOrFail($id);
        $invoiceFood->delete();

        return response()->json([
            'message' => 'Xóa thành công'
        ], 200);
    }
}
