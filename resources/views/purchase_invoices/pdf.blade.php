<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Invoice PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            padding: 20px;
        }
        .invoice-box {
            padding: 20px;
            border: 1px solid #ddd;
        }
        .header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            padding-bottom: 10px;
        }
        .grid-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .details {
            font-size: 16px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
            border: 1px solid black;
        }
        .table th {
            background-color: #eee;
        }
        .highlight {
            background-color: #f9f9f9;
            padding: 10px;
            font-size: 18px;
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <div class="header">Purchase Invoice</div>

    <div class="grid-container">
        <div class="details">
            <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date }}</p>
        </div>
        <div class="details">
            <p><strong>Supplier:</strong> {{ $invoice->supplier->company_name }}</p>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>GST (%)</th>
                <th>Discount (%)</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>₹{{ number_format($item->unit_price, 2) }}</td>
                <td>{{ $item->gst_rate }}%</td>
                <td>{{ $item->discount }}%</td>
                <td>₹{{ number_format($item->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="highlight">Total Amount: ₹{{ number_format($invoice->total_amount, 2) }}</p>
</div>

</body>
</html>
