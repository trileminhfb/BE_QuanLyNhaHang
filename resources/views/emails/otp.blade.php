<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Mã OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .logo img {
            width: 120px;
            margin-bottom: 20px;
        }

        .otp {
            font-size: 36px;
            font-weight: bold;
            color: #27ae60;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="logo">
            <img src="https://png.pngtree.com/element_pic/17/03/18/93848c6966321c046d75644a4d21abb0.jpg" alt="Nhà hàng Logo">
        </div>
        <h2>Xin chào {{ $name }},</h2>
        <p>Mã OTP của bạn là:</p>
        <div class="otp">{{ $otp }}</div>
        <p>Mã này sẽ hết hạn sau 5 phút. Vui lòng không chia sẻ mã này cho bất kỳ ai.</p>
        <p>Cảm ơn bạn đã sử dụng dịch vụ của <strong>Nhà Hàng ABC</strong>.</p>
    </div>
</body>

</html>