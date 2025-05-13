<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeminiChatController;


// Route cho chat bot
Route::get('/chatbot', [GeminiChatController::class, 'index']);
Route::post('/chatbot/send', [GeminiChatController::class, 'send']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/chat', function () {
    return view('chat');
});
