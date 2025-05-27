<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hủy đặt sân</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/pickle_court.png') }}">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #da534a, #d32f2f);
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
        }
        .container {
            background: white;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 90%;
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .icon {
            font-size: 64px;
            color: #f44336;
            margin-bottom: 10px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .message {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        .buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .button {
            background: #00c853;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }
        .button:hover {
            background: #009688;
        }
        .button.secondary {
            background: #ff9800;
        }
        .button.secondary:hover {
            background: #f57c00;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">❌</div>
        <div class="title">Hết thời gian giữ sân</div>
        <div class="message">Lịch đặt sân của bạn đã bị hủy</div>
        <div class="buttons">
            <a href="{{ route('client.index') }}" class="button">🏠 Quay về trang chủ</a>
            <a href="{{ route('client.findOrderByCode', ['code' => $order->code]) }}" class="button secondary">
                📅 Xem trạng thái sân vừa đặt
            </a>   
        </div>
    </div>
</body>
</html>
