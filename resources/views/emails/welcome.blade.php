<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Dasmariñas City Veterinary Services</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #066D33 0%, #07A13F 100%); padding: 30px; border-radius: 10px; text-align: center;">
        <h1 style="color: white; margin: 0;">🐾 Welcome!</h1>
    </div>

    <div style="padding: 20px; background: #f9f9f9; border-radius: 10px; margin-top: 20px;">
        <p>Dear <strong>{{ $user->name }}</strong>,</p>
        
        <p>Welcome to <strong>Dasmariñas City Veterinary Services</strong>!</p>
        
        <p>Thank you for registering with us. You can now:</p>
        <ul>
            <li>Register your pets</li>
            <li>Book vaccination appointments</li>
            <li>Report stray animals</li>
            <li>Access veterinary services</li>
        </ul>
        
        <p>Login to your account to get started:</p>
        <p style="text-align: center;">
            <a href="{{ url('/login') }}" style="display: inline-block; background: #066D33; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold;">Login to Dashboard</a>
        </p>
        
        <p>If you have any questions, feel free to contact us.</p>
        
        <p>Best regards,<br>
        <strong>Dasmariñas City Veterinary Office</strong></p>
    </div>

    <div style="text-align: center; margin-top: 20px; padding: 20px; color: #666; font-size: 12px;">
        <p>This is an automated message. Please do not reply to this email.</p>
    </div>
</body>
</html>