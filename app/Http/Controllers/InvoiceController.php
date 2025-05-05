<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    // Lấy danh sách hóa đơn
    public function index()
    {
        try {
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
            Log::error('Lỗi khi lấy danh sách hóa đơn: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi khi lấy danh sách hóa đơn'], 500);
        }
    }

    // Tạo hóa đơn mới
    public function store(InvoiceRequest $request)
    {
        $data = $request->validated();

        // Nếu frontend gửi sai tên field
        if (isset($data['id_custumer'])) {
            $data['id_customer'] = $data['id_custumer'];
            unset($data['id_custumer']);
        }

        try {
            $invoice = Invoice::create($data);
            Log::info('Hóa đơn đã được tạo:', $invoice->toArray());

            return response()->json([
                'message' => 'Hóa đơn được tạo thành công',
                'invoice' => $invoice
            ], 201);
        } catch (\Exception $e) {
            Log::error('Lỗi tạo hóa đơn: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi tạo hóa đơn'], 500);
        }
    }

    // Xem chi tiết hóa đơn
    public function show($id)
    {
        try {
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
        $validated = $request->validate([
            'id_table' => 'required|exists:tables,id',
            'id_user' => 'required|exists:users,id',
            'total' => 'required|numeric',
            'timeEnd' => 'required|date',
            'id_customer' => 'required|exists:customers,id',
        ]);

        try {
            $invoice = Invoice::find($id);

            if (!$invoice) {
                return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
            }

            $invoice->update($validated);

            return response()->json([
                'message' => 'Hóa đơn được cập nhật thành công',
                'invoice' => $invoice
            ], 200);
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật hóa đơn: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi cập nhật hóa đơn'], 500);
        }
    }

    // Xoá hóa đơn
    public function delete($id)
    {
        try {
            $invoice = Invoice::find($id);

            if (!$invoice) {
                return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
            }

            $invoice->delete();

            return response()->json(['message' => 'Hóa đơn đã được xóa thành công'], 200);
        } catch (\Exception $e) {
            Log::error('Lỗi xóa hóa đơn: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi xóa hóa đơn'], 500);
        }
    }
}
