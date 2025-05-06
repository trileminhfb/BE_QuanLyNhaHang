<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function index()
    {
        try {
            $customers = Customer::with(['rank:id,nameRank,necessaryPoint,saleRank'])->get();
            return response()->json([
                'customers' => $customers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'phoneNumber' => 'required|string|unique:customers,phoneNumber',
            'FullName' => 'required|string|max:255',
            'otp' => 'nullable|string|max:6',
            'point' => 'nullable|integer',
            'id_rank' => 'nullable|integer',
            'mail' => 'nullable|email|max:255',
            'birth' => 'nullable|date',
            'image' => 'nullable|string',
        ]);

        $customer = Customer::create($validated);

        return response()->json([
            'message' => 'Khách hàng đã được tạo thành công',
            'customer' => $customer
        ], 201);
    }

    public function show($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'message' => 'Không tìm thấy khách hàng'
            ], 404);
        }

        return response()->json([
            'message' => 'Khách hàng đã được lấy thành công',
            'customer' => $customer
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'message' => 'Không tìm thấy khách hàng'
            ], 404);
        }

        $validated = $request->validate([
            'phoneNumber' => 'nullable|string|unique:customers,phoneNumber,' . $id,
            'FullName' => 'nullable|string|max:255',
            'otp' => 'nullable|string|max:6',
            'point' => 'nullable|integer',
            'id_rank' => 'nullable|integer',
            'mail' => 'nullable|email|max:255',
            'birth' => 'nullable|date',
            'image' => 'nullable|string',
        ]);

        $customer->update($validated);

        return response()->json([
            'message' => 'Khách hàng đã được cập nhật thành công',
            'customer' => $customer
        ], 200);
    }

    public function delete($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'message' => 'Không tìm thấy khách hàng'
            ], 404);
        }

        $customer->delete();

        return response()->json([
            'message' => 'Khách hàng đã được xóa thành công'
        ], 200);
    }
}
