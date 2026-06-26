<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt Notification</title>
</head>
<body style="font-family: sans-serif; background-color: #f4f4f5; padding: 20px; color: #1f2937;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 8px; border: 1px solid #e5e7eb;">
        <h2 style="color: #2563eb; margin-top: 0;">Payment Receipt / Invoice</h2>
        <p>Dear {{ $receipt->shipment->sender_name }},</p>
        <p>Your payment receipt for shipment tracking number <strong>{{ $receipt->shipment->tracking_number }}</strong> has been successfully processed.</p>
        <p><strong>Receipt Number:</strong> {{ $receipt->receipt_number }}<br>
        <strong>Amount:</strong> ${{ number_format($receipt->amount, 2) }} USD<br>
        <strong>Status:</strong> {{ ucfirst($receipt->payment_status) }}</p>
        <p>We have attached the official printable invoice PDF to this email for your records.</p>
        <p>If you have any questions, feel free to reply to this email or contact support at support@blueorientlogistics.org.</p>
        <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 20px 0;">
        <p style="font-size: 12px; color: #6b7280; text-align: center;">Blue Orient Logistics &copy; {{ date('Y') }}. All rights reserved.</p>
    </div>
</body>
</html>
