<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbox</title>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
</head>
<body>
    <h1>Chatbox</h1>
    <div id="messages"></div>
    <input type="text" id="message" placeholder="Type your message here">
    <button onclick="sendMessage()">Send</button>

    <script>
        // Cấu hình Pusher
        Pusher.logToConsole = true;
        var pusher = new Pusher('4d2bac1f31d8009a34cd', {
            cluster: 'ap1'
        });

        // Kết nối với channel chat
        var channel = pusher.subscribe('chat.1.2'); // Đây là ví dụ, thay id customer và staff thực tế
        channel.bind('App\\Events\\MessageSent', function(data) {
            var messagesDiv = document.getElementById('messages');
            var newMessage = document.createElement('p');
            newMessage.textContent = data.message + ' - ' + data.timestamp;
            messagesDiv.appendChild(newMessage);
        });

        // Gửi tin nhắn
        function sendMessage() {
            var messageContent = document.getElementById('message').value;
            fetch('/chat/send-message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id_customer: 1, // Ví dụ id khách hàng
                    id_user: 2, // Ví dụ id nhân viên
                    message: messageContent
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.getElementById('message').value = '';
            });
        }
    </script>
</body>
</html>
