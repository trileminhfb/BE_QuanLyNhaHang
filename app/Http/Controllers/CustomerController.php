<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{
    public function register(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|email|unique:customers,mail',
            'FullName' => 'required|string|max:255',
            'phoneNumber' => 'required|string|unique:customers,phoneNumber',
            'password' => 'required|string|min:6|confirmed', // thêm xác nhận mật khẩu
            'birth' => 'nullable|date',
            'image' => 'nullable|string',
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        $otp = rand(100000, 999999);

        $customer = Customer::create([
            'mail' => $request->email,
            'FullName' => $request->FullName,
            'phoneNumber' => $request->phoneNumber,
            'birth' => $request->birth,
            'image' => $request->image,
            'password' => Hash::make($request->password),
            'otp' => $otp,
            'point' => 0,
            'id_rank' => 1,
            'isActive' => false,
        ]);

        // Gửi OTP qua email
        Mail::to($request->email)->send(new OtpMail($otp, $request->FullName));

        return response()->json([
            'message' => 'Đăng ký thành công. Vui lòng xác nhận OTP được gửi qua email.',
            'id' => $customer->id
        ], 201);
    }


    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum');
    // }
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
