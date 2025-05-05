<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        try {
            $customers = Customer::with(['rank:id,nameRank,necessaryPoint,saleRank'])->get();
            return response()->json([
                "customers" => $customers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }
    }    
    public function store(Request $request)
    {
        $customer = new Customer();
        $customer->phoneNumber = $request->phoneNumber;
        $customer->FullName = $request->FullName;
        $customer->otp = $request->otp;
        $customer->point = $request->point ?? 0; // Mặc định là 0 nếu không có giá trị
        $customer->id_rank = $request->id_rank;

        $customer->save(); // Lưu vào DB

        return response()->json([
            'message'  => 'Customer created successfully',
            'customer' => $customer
        ], 201);
    }
    public function show($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'message' => 'Customer not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Customer retrieved successfully',
            'customer' => $customer
        ], 200);
    }
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'message' => 'Customer not found'
            ], 404);
        }

        // Cập nhật dữ liệu từ request
        $customer->phoneNumber = $request->phoneNumber ?? $customer->phoneNumber;
        $customer->FullName = $request->FullName ?? $customer->FullName;
        $customer->otp = $request->otp ?? $customer->otp;
        $customer->point = $request->point ?? $customer->point;
        $customer->id_rank = $request->id_rank ?? $customer->id_rank;

        // Lưu thay đổi
        $customer->save();

        return response()->json([
            'message' => 'Customer updated successfully',
            'customer' => $customer
        ], 200);
    }
    public function delete($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'message' => 'Customer not found'
            ], 404);
        }

        $customer->delete();

        return response()->json([
            'message' => 'Customer deleted successfully'
        ], 200);
    }
}
