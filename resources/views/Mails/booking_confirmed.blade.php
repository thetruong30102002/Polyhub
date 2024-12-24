<!-- resources/views/Mails/booking_confirmed_pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmed PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        .content {
            margin: 20px;
        }
        .header, .footer {
            text-align: center;
        }
        .details {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Booking Confirmed</h1>
    </div>
    <div class="content">
        <p>Thank you for your booking!</p>
        <div class="details">
            <p><strong>Bill Details:</strong></p>
            <p>User ID: {{ $bill->user_id }}</p>
            <p>Grand Total: {{ $bill->grand_total }}</p>
            <p><strong>Checkin Details:</strong></p>
            <p>Name: {{ $checkin->name }}</p>
            <a href="http://127.0.0.1:8000/print-bill/{{ $bill->id }}" class="btn btn-primary">Print the invoice</a>
        </div>
    </div>
    <div class="footer">
        <p>Generated on {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html>
