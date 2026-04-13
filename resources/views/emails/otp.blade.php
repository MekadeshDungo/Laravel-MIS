<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 5px;
            color: #2563eb;
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 8px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your OTP Verification Code</h2>

        <p>Your One-Time Password (OTP) for verification is:</p>

        <div class="otp-code">
            {{ $otp }}
        </div>

        <p>This OTP will expire in 10 minutes.</p>

        <p>If you did not request this code, please ignore this email.</p>

        <div class="footer">
            <p>This is an automated email from the Vet MIS System. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
