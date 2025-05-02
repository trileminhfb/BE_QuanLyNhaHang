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
            $invoices = DB::table('invoices')
                ->leftJoin('bookings', 'invoices.id_booking', '=', 'bookings.id')
                ->leftJoin('users', 'invoices.id_user', '=', 'users.id')
                ->leftJoin('foods', 'bookings.id_food', '=', 'foods.id')
                ->leftJoin('tables', 'bookings.id_table', '=', 'tables.id')
                ->leftJoin('customers', 'bookings.id_customer', '=', 'customers.id') // Đã sửa tên cột thành `id_customer`
                ->select(
                    'invoices.id as invoice_id',
                    'invoices.total',
                    'invoices.timeEnd',
                    'users.name as user_name',
                    'users.phone_number',
                    'users.email',
                    'bookings.id_table',
                    'bookings.timeBooking',
                    'bookings.quantity',
                    'bookings.id_customer', // Sửa từ `id_cutomer` thành `id_customer`
                    'foods.name as food_name',
                    'foods.cost as food_cost',
                    'foods.detail as food_detail',
                    'tables.number as table_number',
                    'customers.FullName as customer_name'
                )
                ->get();

            return response()->json($invoices);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
    public function store(Request $request)
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
            // Tạo hóa đơn mới
            $invoice = Invoice::create([
                'id_booking' => $validated['id_booking'],
                'id_user' => $validated['id_user'],
                'total' => $validated['total'],
                'timeEnd' => $validated['timeEnd'],
                'id_customer' => $validated['id_customer'],  // Chú ý đã sửa thành id_customer
            ]);

            // Lấy thông tin thêm từ bảng liên quan
            $invoiceData = DB::table('invoices')
                ->leftJoin('bookings', 'invoices.id_booking', '=', 'bookings.id')
                ->leftJoin('users', 'invoices.id_user', '=', 'users.id')
                ->leftJoin('foods', 'bookings.id_food', '=', 'foods.id')
                ->leftJoin('tables', 'bookings.id_table', '=', 'tables.id')
                ->leftJoin('customers', 'bookings.id_customer', '=', 'customers.id')  // Sửa tên cột thành id_customer
                ->select(
                    'invoices.id as invoice_id',
                    'invoices.total',
                    'invoices.timeEnd',
                    'users.name as user_name',
                    'users.role as user_role',
                    'users.phone_number as user_phone',
                    'users.email as user_email',
                    'bookings.timeBooking',
                    'bookings.quantity',
                    'foods.name as food_name',
                    'foods.cost as food_cost',
                    'tables.number as table_number',
                    'customers.FullName as customer_name'
                )
                ->where('invoices.id', $invoice->id)
                ->first();  // Lấy một bản ghi duy nhất

            return response()->json([
                'message' => 'Invoice created successfully',
                'invoice' => $invoiceData
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
    public function show($id)
    {
        try {
            // Lấy thông tin hóa đơn theo ID
            $invoice = DB::table('invoices')
                ->leftJoin('bookings', 'invoices.id_booking', '=', 'bookings.id')
                ->leftJoin('users', 'invoices.id_user', '=', 'users.id')
                ->leftJoin('foods', 'bookings.id_food', '=', 'foods.id')
                ->leftJoin('tables', 'bookings.id_table', '=', 'tables.id')
                ->leftJoin('customers', 'bookings.id_cutomer', '=', 'customers.id')
                ->select(
                    'invoices.id as invoice_id',
                    'invoices.total',
                    'invoices.timeEnd',
                    'users.name as user_name',
                    'users.role as user_role',
                    'users.phone_number as user_phone',
                    'users.email as user_email',
                    'bookings.timeBooking',
                    'bookings.quantity',
                    'foods.name as food_name',
                    'foods.cost as food_cost',
                    'tables.number as table_number',
                    'customers.FullName as customer_name'
                )
                ->where('invoices.id', $id)
                ->first(); // Lấy một bản ghi duy nhất

            // Kiểm tra nếu không có hóa đơn
            if (!$invoice) {
                return response()->json(['message' => 'Invoice not found'], 404);
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
                return response()->json(['message' => 'Invoice not found'], 404);
            }

            // Cập nhật thông tin hóa đơn
            $invoice->update([
                'id_booking' => $validated['id_booking'],
                'id_user' => $validated['id_user'],
                'total' => $validated['total'],
                'timeEnd' => $validated['timeEnd'],
                'id_customer' => $validated['id_customer'],  // Chú ý đã sửa thành id_customer
            ]);

            // Lấy thông tin hóa đơn sau khi cập nhật
            $invoiceData = DB::table('invoices')
                ->leftJoin('bookings', 'invoices.id_booking', '=', 'bookings.id')
                ->leftJoin('users', 'invoices.id_user', '=', 'users.id')
                ->leftJoin('foods', 'bookings.id_food', '=', 'foods.id')
                ->leftJoin('tables', 'bookings.id_table', '=', 'tables.id')
                ->leftJoin('customers', 'bookings.id_customer', '=', 'customers.id')  // Sửa tên cột thành id_customer
                ->select(
                    'invoices.id as invoice_id',
                    'invoices.total',
                    'invoices.timeEnd',
                    'users.name as user_name',
                    'users.role as user_role',
                    'users.phone_number as user_phone',
                    'users.email as user_email',
                    'bookings.timeBooking',
                    'bookings.quantity',
                    'foods.name as food_name',
                    'foods.cost as food_cost',
                    'tables.number as table_number',
                    'customers.FullName as customer_name'
                )
                ->where('invoices.id', $invoice->id)
                ->first();  // Lấy một bản ghi duy nhất

            return response()->json([
                'message' => 'Invoice updated successfully',
                'invoice' => $invoiceData
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
    // Xoá hóa đơn
    public function delete($id)
    {
        try {
            // Tìm hóa đơn cần xóa
            $invoice = Invoice::find($id);

            // Kiểm tra nếu hóa đơn không tồn tại
            if (!$invoice) {
                return response()->json(['message' => 'Invoice not found'], 404);
            }

            // Xóa hóa đơn
            $invoice->delete();

            // Trả về thông báo thành công
            return response()->json(['message' => 'Invoice deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
}
