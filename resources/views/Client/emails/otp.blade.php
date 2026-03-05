<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OTP Verification - Dasmariñas City Veterinary Services</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e5e7eb;
        }
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        .logo {
            width: 50px;
            height: 50px;
        }
        .header h1 {
            color: #066D33;
            margin: 0;
            font-size: 20px;
        }
        .header p {
            color: #6b7280;
            margin: 5px 0 0 0;
            font-size: 12px;
        }
        .content {
            text-align: center;
        }
        .content h2 {
            color: #333;
            margin-bottom: 15px;
        }
        .content p {
            color: #666;
            line-height: 1.6;
        }
        .otp-code {
            font-size: 36px;
            font-weight: bold;
            color: #066D33;
            letter-spacing: 8px;
            margin: 20px 0;
            padding: 15px;
            background-color: #f0fdf4;
            border-radius: 8px;
            border: 2px dashed #066D33;
        }
        .expiry {
            color: #dc2626;
            font-weight: 600;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-container">
                <!-- Dasmariñas City Logo SVG -->
                <svg class="logo" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="45" fill="#066D33"/>
                    <text x="50" y="58" text-anchor="middle" fill="white" font-size="24" font-weight="bold">DV</text>
                </svg>
            </div>
            <h1>Dasmariñas City Veterinary Services</h1>
            <p>Official Veterinary Office of Dasmariñas City</p>
        </div>
        
        <div class="content">
            <h2>Email Verification</h2>
            <p>Your verification code is:</p>
            
            <div class="otp-code">{{ $otpCode }}</div>
            
            <p>Please enter this code to verify your email address.</p>
            <p class="expiry">This code will expire in 10 minutes.</p>
        </div>
        
        <div class="footer">
            <p>If you didn't request this code, please ignore this email.</p>
            <p>&copy; {{ date('Y') }} Dasmariñas City Veterinary Services.<br>All rights reserved.</p>
        </div>
    </div>
</body>
</html>
