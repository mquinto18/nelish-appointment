<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .container { width: 700px; margin: auto; padding: 20px;  }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .details, .footer { margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #000; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>NELISH SERENITY SPA</h2>
            <p>Hotel Lucky Chinatown 6th Floor<br>
            21 Reina Regente St. Binondo, Manila</p>
        </div>

        <div class="details">
            <p><strong>Bill To:</strong> {{ $appointment->name }}</p>
            <p><strong>Email:</strong> {{ $appointment->email }}</p>
            <p><strong>Date:</strong> {{ $date }}</p>
            <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($time)->format('h:i A') }}</p>
            <p><strong>Therapist:</strong> {{ $therapist }}</p>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Qty</th>
                    <th>Service Type</th>
                    <th>Duration</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                <tr>
                    <td>{{ $quantity }}</td>
                    <td>{{ $service }}</td>
                    <td>{{ $duration }} mins</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p><strong>Grand Total:</strong> {{ number_format($total, 2) }}</p>
        
        <div class="footer">
            <p><strong>Payment Method:</strong> GCash</p>
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>
</html>
