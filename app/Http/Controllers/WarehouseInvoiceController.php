<?php

namespace App\Http\Controllers;

use App\Models\WarehouseInvoice;
use App\Http\Requests\WarehouseInvoiceRequest;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseInvoiceController extends Controller
{
    // Lấy danh sách hóa đơn kho
    public function getData()
    {
        $invoices = WarehouseInvoice::with(['ingredient:id,image,name_ingredient,unit'])->get();
        return response()->json([
            'status' => 1,
            'data' => $invoices
        ]);
    }

    // Lấy hóa đơn kho theo ID
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
        DB::beginTransaction();

        try {
            $data = $request->only(['id_ingredient', 'quantity', 'price', 'stock_in_date']);

            $invoice = WarehouseInvoice::create($data);

            $warehouse = Warehouse::firstOrCreate(
                ['id_ingredient' => $data['id_ingredient']],
                ['quantity' => 0]
            );

            $warehouse->increment('quantity', $data['quantity']);

            DB::commit();

            return response()->json([
                'status'  => 1,
                'message' => 'Thêm mới hóa đơn kho thành công.',
                'data'    => $invoice
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 0,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }

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
            'stock_in_date' => $request->stock_in_date,
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
