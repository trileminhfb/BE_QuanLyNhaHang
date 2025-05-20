<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|email|unique:customers,mail',
            'FullName' => 'required|string|max:255',
            'phoneNumber' => 'required|string|unique:customers,phoneNumber',
            'password' => 'required|string|min:6|confirmed',
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

        Mail::to($request->email)->send(new OtpMail($otp, $request->FullName));

        return response()->json([
            'message' => 'Đăng ký thành công, mã OTP đã được gửi qua email. Vui lòng nhập OTP để xác thực tài khoản.',
            'id' => $customer->id,
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

        $token = $customer->createToken('YourAppName')->plainTextToken;

        return response()->json([
            'message' => 'Xác thực OTP thành công',
            'token' => $token, // Trả về token
        ], 200);
    }

    public function loginWithOtp(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $customer = Customer::with('rank')
            ->where('mail', $request->email)
            ->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json([
                'message' => 'Email hoặc mật khẩu/OTP không đúng'
            ], 401);
        }

        $token = $customer->createToken('YourAppName')->plainTextToken;

        return response()->json([
            'message'  => 'Đăng nhập thành công',
            'token'    => $token,
            'customer' => [
                'id'          => $customer->id,
                'phoneNumber' => $customer->phoneNumber,
                'mail'        => $customer->mail,
                'birth'       => $customer->birth,
                'FullName'    => $customer->FullName,
                'image'       => $customer->image,
                'point'       => $customer->point,
                'isActive'    => $customer->isActive,
                'created_at'  => $customer->created_at,
                'updated_at'  => $customer->updated_at,
                'rank'        => $customer->rank
            ]
        ], 200);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $customer = Customer::where('mail', $request->email)->first();

        if (!$customer) {
            return response()->json(['message' => 'Email không tồn tại'], 404);
        }

        $otp = rand(100000, 999999);
        $customer->otp = $otp;
        $customer->save();

        Mail::to($request->email)->send(new OtpMail($otp, $customer->FullName));

        return response()->json([
            'message' => 'OTP đã được gửi qua email, vui lòng kiểm tra.',
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string',
            'old_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $customer = Customer::where('mail', $request->email)->first();

        if (!$customer) {
            return response()->json(['message' => 'Email không tồn tại'], 404);
        }

        if ($customer->otp !== $request->otp) {
            return response()->json(['message' => 'OTP không hợp lệ'], 401);
        }

        if (!Hash::check($request->old_password, $customer->password)) {
            return response()->json(['message' => 'Mật khẩu cũ không đúng'], 403);
        }

        $customer->password = Hash::make($request->password);
        $customer->otp = null;
        $customer->save();

        return response()->json([
            'message' => 'Mật khẩu đã được thay đổi thành công',
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Đăng xuất thành công'
        ]);
    }
}
