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
    // Phương thức đăng ký (đã có trong code của bạn)
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

        // Tạo OTP và lưu vào cơ sở dữ liệu
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
            'isActive' => false, // Chưa kích hoạt
        ]);

        // Gửi OTP qua email
        Mail::to($request->email)->send(new OtpMail($otp, $request->FullName));

        return response()->json([
            'message' => 'Đăng ký thành công, mã OTP đã được gửi qua email. Vui lòng nhập OTP để xác thực tài khoản.',
            'id' => $customer->id,
        ], 201);
    }

    // Phương thức xác thực OTP (đã có trong code của bạn)
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

        // Kích hoạt tài khoản
        $customer->isActive = true;
        $customer->otp = null;  // Xóa OTP sau khi xác thực
        $customer->save();

        // Tạo token sau khi xác thực
        $token = $customer->createToken('YourAppName')->plainTextToken;

        return response()->json([
            'message' => 'Xác thực OTP thành công',
            'token' => $token, // Trả về token
        ], 200);
    }

    // Phương thức đăng nhập bằng email và password
    public function loginWithOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('mail', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json(['message' => 'Email hoặc mật khẩu không đúng'], 401);
        }

        // Tạo token sau khi đăng nhập thành công
        $token = $customer->createToken('YourAppName')->plainTextToken;

        return response()->json([
            'message' => 'Đăng nhập thành công',
            'token' => $token, // Trả về token
        ], 200);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Tìm khách hàng theo email
        $customer = Customer::where('mail', $request->email)->first();

        if (!$customer) {
            return response()->json(['message' => 'Email không tồn tại'], 404);
        }

        // Tạo OTP mới
        $otp = rand(100000, 999999);

        // Cập nhật OTP vào cơ sở dữ liệu
        $customer->otp = $otp;
        $customer->save();

        // Gửi OTP qua email
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
            'password' => 'required|string|min:6|confirmed', // Xác nhận mật khẩu
        ]);

        // Tìm khách hàng theo email
        $customer = Customer::where('mail', $request->email)->first();

        if (!$customer || $customer->otp !== $request->otp) {
            return response()->json(['message' => 'OTP không hợp lệ hoặc email không đúng'], 401);
        }

        // Cập nhật mật khẩu mới
        $customer->password = Hash::make($request->password);
        $customer->otp = null;  // Xóa OTP sau khi đổi mật khẩu
        $customer->save();

        return response()->json([
            'message' => 'Mật khẩu đã được thay đổi thành công',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete(); // hoặc auth()->logout();

        return response()->json([
            'message' => 'Đăng xuất thành công'
        ]);
    }
}
