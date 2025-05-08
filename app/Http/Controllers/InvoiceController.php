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
                ->leftJoin('tables', 'invoices.id_table', '=', 'tables.id')
                ->leftJoin('users', 'invoices.id_user', '=', 'users.id')
                ->leftJoin('customers', 'invoices.id_customer', '=', 'customers.id')
                ->leftJoin('sales', 'invoices.id_sale', '=', 'sales.id')
                ->select(
                    'invoices.*',
                    'tables.number as table_number',
                    'users.name as user_name',
                    'users.role',
                    'users.phone_number',
                    'users.email',
                    'customers.FullName as customer_name',
                    'sales.*'
                )
                ->get();

            return response()->json($invoices);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy danh sách hóa đơn: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi khi lấy danh sách hóa đơn'], 500);
        }
    }


    public function store(InvoiceRequest $request)
    {
        $data = $request->validated();

        $fieldMapping = [
            'id_custumer' => 'id_customer',
        ];
        foreach ($fieldMapping as $wrongField => $correctField) {
            if (isset($data[$wrongField])) {
                $data[$correctField] = $data[$wrongField];
                unset($data[$wrongField]);
            }
        }

        $total = $this->calculateTotal($data['items']);
        $data['total'] = $total;

        try {
            Log::info('Dữ liệu hóa đơn:', $data);

            $invoice = Invoice::create($data);

            if (!$invoice) {
                Log::error('Không thể tạo hóa đơn:', $data);
                return response()->json(['error' => 'Lỗi tạo hóa đơn'], 500);
            }

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

    private function calculateTotal($items)
    {
        $total = 0;

        foreach ($items as $item) {
            $total += $item['quantity'] * $item['unit_price'];
        }

        return $total;
    }

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

    public function delete($id)
    {
        try {
            $invoice = Invoice::find($id);

            if (!$invoice) {
                return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
            }

            $invoice->delete();
        } catch (\Exception $e) {
            Log::error('Lỗi xóa hóa đơn: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi xóa hóa đơn'], 500);
        }
    }
}
