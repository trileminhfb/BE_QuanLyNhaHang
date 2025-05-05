<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    public function index()
    {
        try {
            // Truy vấn và lấy danh sách hóa đơn
            $invoices = DB::table('invoices')
                ->leftJoin('tables', 'invoices.id_table', '=', 'tables.id')
                ->leftJoin('users', 'invoices.id_user', '=', 'users.id')
                ->leftJoin('customers', 'invoices.id_customer', '=', 'customers.id')
                ->select(
                    'invoices.*',
                    'tables.number as table_number',
                    'users.name as user_name',
                    'users.role',
                    'users.phone_number',
                    'users.email',
                    'customers.FullName as customer_name'
                )
                ->get();

            return response()->json($invoices);
        } catch (\Exception $e) {
            // Ghi lại lỗi chi tiết vào log
            Log::error('Lỗi khi lấy danh sách hóa đơn: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi khi lấy danh sách hóa đơn'], 500);
        }
    }

    // Tạo hóa đơn mới
    public function store(InvoiceRequest $request)
    {
        $data = $request->validated();
    
        // Nếu vẫn gửi sai tên field từ frontend
        if (isset($data['id_custumer'])) {
            $data['id_customer'] = $data['id_custumer'];
            unset($data['id_custumer']);
        }
    
        $invoice = Invoice::create($data);
        Log::info('Hóa đơn đã được tạo:', $invoice->toArray());
    
        return response()->json([
            'message' => 'Hóa đơn được tạo thành công',
            'invoice' => $invoice
        ], 201);
    }
    public function show($id)
    {
        $invoice = Invoice::with(['table', 'user', 'customer'])->find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
        }

            return response()->json($invoice);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
    // Cập nhật hóa đơn
    public function update(Request $request, $id)
    {
        // Validate input
        $validated = $request->validate([
            'id_booking' => 'required|exists:bookings,id',
            'id_user' => 'required|exists:users,id',
            'total' => 'required|numeric',
            'timeEnd' => 'required|date',
            'id_customer' => 'required|exists:customers,id',  // Chú ý đã sửa thành id_customer
        ]);

        try {
            // Tìm hóa đơn cần cập nhật
            $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
        }

        $invoice->update([
            'id_table'    => $request->id_table,
            'timeEnd'     => $request->timeEnd,
            'total'       => $request->total,
            'id_user'     => $request->id_user,
            'id_custumer' => $request->id_custumer,
        ]);

        return response()->json([
            'message' => 'Hóa đơn được cập nhật thành công',
            'invoice' => $invoice
        ], 200);
    }

    // Xoá hóa đơn
    public function delete($id)
    {
        try {
            // Tìm hóa đơn cần xóa
            $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
        }

            // Xóa hóa đơn
            $invoice->delete();

        return response()->json(['message' => 'Hóa đơn đã được xóa thành công'], 200);
    }
}
