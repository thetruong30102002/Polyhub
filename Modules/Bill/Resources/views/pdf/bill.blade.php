<!DOCTYPE html>
<html>
<head>
    <title>Your Bill</title>
</head>
<body>
    <h1>Invoice #{{ $bill->id }}</h1>
    <p>Create At: {{ $bill->created_at }}</p>
    <p>Grand Total: {{ $bill->grand_total }}</p>
    <img src="data:image/png;base64,{{ $bill->checkin->checkin_code }}" alt="Checkin Barcode">
</body>
</html>
