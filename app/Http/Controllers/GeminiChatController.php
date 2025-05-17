<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GeminiChatController extends Controller
{
    public function index()
    {
        return view('chatbot');
    }

    public function send(Request $request)
    {
        $message = strtolower($request->input('message')); // chuyển thành chữ thường để so sánh
        $apiKey = env('GEMINI_API_KEY');

        // Nếu người dùng chỉ chào
        if (preg_match('/^(chào|hi|hello|xin chào)$/i', trim($message))) {
            return response()->json(['reply' => 'Xin chào! Tôi là botAI – trợ lý của nhà hàng. Bạn cần tư vấn món ăn gì không?']);
        }

        // Nếu người dùng hỏi liên quan đến tư vấn món ăn
        $foods = DB::table('foods')->where('status', 1)->get();
        $menuText = $foods->map(function ($food) {
            return "{$food->name} - {$food->detail} - Giá: {$food->cost} VND";
        })->implode("\n");

        $fullPrompt = "Dưới đây là thực đơn nhà hàng:\n" . $menuText .
            "\n\nKhách hàng hỏi: \"$message\"\nHãy tư vấn món ăn phù hợp theo khẩu vị khách hàng.";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post(
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}",
            [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $fullPrompt]
                        ]
                    ]
                ]
            ]
        );

        if (!$response->successful()) {
            return response()->json([
                'reply' => 'Đã xảy ra lỗi khi gọi Gemini API.',
                'error' => $response->body()
            ], 500);
        }

        $data = $response->json();
        $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Không có phản hồi từ Gemini.';

        return response()->json(['reply' => $reply]);
    }

}
