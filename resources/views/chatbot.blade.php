<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Gemini Chatbot</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-container {
            max-width: 700px;
            margin: 50px auto;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            height: 600px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: #f8f9fa;
        }
        .message { margin-bottom: 10px; }
        .message.user { text-align: right; color: #0d6efd; }
        .message.bot { text-align: left; color: #198754; }
        .chat-input {
            padding: 15px;
            border-top: 1px solid #dee2e6;
            background: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="chat-container">
            <div id="chat-box" class="chat-messages"></div>
            <div class="chat-input d-flex">
                <input type="text" id="message" class="form-control me-2" placeholder="Nhập câu hỏi..." />
                <button class="btn btn-primary" onclick="sendMessage()">Gửi</button>
            </div>
        </div>
    </div>

<script>
    function sendMessage() {
        const message = document.getElementById("message").value.trim();
        if (!message) return;

        const chatBox = document.getElementById("chat-box");
        chatBox.innerHTML += `<div class="message user"><strong>Bạn:</strong> ${message}</div>`;
        document.getElementById("message").value = "";

        fetch("/chatbot/send", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({ message })
        })
        .then(res => res.json())
        .then(data => {
            chatBox.innerHTML += `<div class="message bot"><strong>Gemini:</strong> ${data.reply}</div>`;
            chatBox.scrollTop = chatBox.scrollHeight;
        })
        .catch(() => {
            chatBox.innerHTML += `<div class="message bot"><strong>Lỗi:</strong> Không thể gửi yêu cầu đến Gemini.</div>`;
        });
    }
</script>
</body>
</html>
