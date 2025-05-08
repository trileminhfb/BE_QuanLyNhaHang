<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|email|unique:customers,mail',
            'FullName' => 'required|string|max:255',
            'phoneNumber' => 'required|string|unique:customers,phoneNumber',
        ]);
        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        $otp = rand(100000, 999999);

        $customer = Customer::create([
            'mail' => $request->email,
            'FullName' => $request->FullName,
            'phoneNumber' => $request->phoneNumber,
            'otp' => $otp,
            'isActive' => false,
        ]);
        Mail::to($request->email)->send(new OtpMail($otp, $request->FullName));

        return response()->json([
            'message' => 'Đăng ký thành công, mã OTP đã được gửi',
            'id' => $customer->id
        ], 201);
    }
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string',
        ]);
        $customer = Customer::where('mail', $request->email)->first();

        if (!$customer || $customer->otp !== $request->otp) {
            return response()->json(['message' => 'OTP không hợp lệ'], 401);
        }
        $customer->isActive = true;
        $customer->otp = null; 
        $customer->save();

        return response()->json(['message' => 'Xác thực thành công'], 200);
    }
    public function loginWithOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $customer = Customer::where('mail', $request->email)->where('isActive', true)->first();

        if (!$customer) {
            return response()->json(['message' => 'Tài khoản chưa được xác thực hoặc không tồn tại'], 401);
        }
        $otp = rand(100000, 999999);
        $customer->otp = $otp;
        $customer->save();

        Mail::to($customer->mail)->send(new OtpMail($otp, $customer->FullName));

        return response()->json([
            'message' => 'OTP đăng nhập đã được gửi qua email',
        ]);
    }
}
