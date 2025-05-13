<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'id_customer' => 'required|exists:customers,id', // chỉnh nếu dùng bảng customers riêng
            'id_user' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'id_customer' => $request->id_customer,
            'id_user' => $request->id_user,
            'content' => $request->message,
            'sender' => 'customer',
        ]);

        event(new MessageSent($message));

        return response()->json(['message' => 'Tin nhắn đã được gửi']);
    }

    public function replyMessage(Request $request)
    {
        $request->validate([
            'id_customer' => 'required|exists:customers,id',
            'id_user' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'id_customer' => $request->id_customer,
            'id_user' => $request->id_user,
            'content' => $request->message,
            'sender' => 'user',
        ]);

        event(new MessageSent($message));

        return response()->json(['message' => 'Tin nhắn đã được gửi']);
    }

    public function getMessages($customerId, $staffId)
    {
        $messages = Message::where(function ($query) use ($customerId, $staffId) {
            $query->where('id_customer', $customerId)
                  ->where('id_user', $staffId);
        })
        ->orWhere(function ($query) use ($customerId, $staffId) {
            $query->where('id_customer', $customerId)
                  ->where('id_user', $staffId);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json(['messages' => $messages]);
    }
}
