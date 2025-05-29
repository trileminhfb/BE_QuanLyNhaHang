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

        // Nếu người dùng hỏi "có được ăn free không" hoặc tương tự
        if (preg_match('/(ăn.*(miễn phí|free)|có.*(free|miễn phí))/i', $message)) {
            return response()->json(['reply' => 'Có chứ! Cứ thoải mái ăn, hôm nay có bé Tôm bao nhé 😄']);
        }

        // Nếu người dùng hỏi liên hệ
        if (preg_match('/liên hệ (với )?(nhân viên|hỗ trợ|tư vấn|chăm sóc khách hàng)/i', $message)
            || str_contains($message, 'tôi muốn liên hệ với nhân viên hỗ trợ')) {
            return response()->json([
                'reply' => "Cảm ơn bạn đã liên hệ với bộ phận hỗ trợ của chúng tôi! 🧡\n"
                    . "Bạn có thể liên hệ trực tiếp qua:\n"
                    . "- 📞 Điện thoại: 0123 456 789\n"
                    . "- 📧 Email: khanhtran12232003@gmail.com\n"
                    . "- 🏠 Địa chỉ: CAMPUCHIA \n\n"
                    . "Nhân viên của chúng tôi sẽ phản hồi bạn sớm nhất có thể. Cảm ơn bạn đã tin tưởng!"
            ]);
        }

        // Nếu người dùng hỏi về địa chỉ hoặc tên quán
        if (preg_match('/(địa chỉ|tên quán|ở đâu|nhà hàng tên gì)/i', $message)) {
            return response()->json([
                'reply' => "Chào bạn! Nhà hàng của chúng tôi mang tên **PheFood** – nơi hội tụ những món ăn ngon khó cưỡng! 😋\n"
                    . "Bạn có thể ghé thăm chúng tôi tại địa chỉ: **123 Hồ Tùng Mậu, TP. Hồ Chí Minh**. \n"
                    . "Hãy đến để tận hưởng không gian ấm cúng và những món ăn tuyệt vời nhé! Chờ bạn đó! 🏠🍽️"
            ]);
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
