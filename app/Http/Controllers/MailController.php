<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'nullable|string'
        ]);

        $otp = rand(100000, 999999);
        $email = $request->email;
        $name = $request->name ?? 'Khách hàng';

        Mail::to($email)->send(new OtpMail($otp, $name));

        return response()->json([
            'message' => 'OTP đã được gửi đến email của bạn',
            'otp' => $otp
        ]);
    }
}
