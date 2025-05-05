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
                ->leftJoin('customers', 'bookings.id_customer', '=', 'customers.id')
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
                    'bookings.id_customer',
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
        $validated = $request->validate([
            'id_booking' => 'required|exists:bookings,id',
            'id_user' => 'required|exists:users,id',
            'total' => 'required|numeric',
            'timeEnd' => 'required|date',
            'id_customer' => 'required|exists:customers,id',
        ]);

        try {
            $invoice = Invoice::create($validated);

            $invoiceData = DB::table('invoices')
                ->leftJoin('bookings', 'invoices.id_booking', '=', 'bookings.id')
                ->leftJoin('users', 'invoices.id_user', '=', 'users.id')
                ->leftJoin('foods', 'bookings.id_food', '=', 'foods.id')
                ->leftJoin('tables', 'bookings.id_table', '=', 'tables.id')
                ->leftJoin('customers', 'bookings.id_customer', '=', 'customers.id')
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
                ->first();

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
            $invoice = DB::table('invoices')
                ->leftJoin('bookings', 'invoices.id_booking', '=', 'bookings.id')
                ->leftJoin('users', 'invoices.id_user', '=', 'users.id')
                ->leftJoin('foods', 'bookings.id_food', '=', 'foods.id')
                ->leftJoin('tables', 'bookings.id_table', '=', 'tables.id')
                ->leftJoin('customers', 'bookings.id_customer', '=', 'customers.id')
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
                ->first();

            if (!$invoice) {
                return response()->json(['message' => 'Invoice not found'], 404);
            }

            return response()->json($invoice);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_booking' => 'required|exists:bookings,id',
            'id_user' => 'required|exists:users,id',
            'total' => 'required|numeric',
            'timeEnd' => 'required|date',
            'id_customer' => 'required|exists:customers,id',
        ]);

        try {
            $invoice = Invoice::find($id);

            if (!$invoice) {
                return response()->json(['message' => 'Invoice not found'], 404);
            }

            $invoice->update($validated);

            $invoiceData = DB::table('invoices')
                ->leftJoin('bookings', 'invoices.id_booking', '=', 'bookings.id')
                ->leftJoin('users', 'invoices.id_user', '=', 'users.id')
                ->leftJoin('foods', 'bookings.id_food', '=', 'foods.id')
                ->leftJoin('tables', 'bookings.id_table', '=', 'tables.id')
                ->leftJoin('customers', 'bookings.id_customer', '=', 'customers.id')
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
                ->first();

            return response()->json([
                'message' => 'Invoice updated successfully',
                'invoice' => $invoiceData
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $invoice = Invoice::find($id);

            if (!$invoice) {
                return response()->json(['message' => 'Invoice not found'], 404);
            }

            $invoice->delete();

            return response()->json(['message' => 'Invoice deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
}
