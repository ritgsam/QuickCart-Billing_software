<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sale Invoice PDF</title>
    <style>
        body{    font-family: DejaVu Sans, sans-serif;}
        /* body { font-family: Arial, sans-serif; } */
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

<h2 class="text-center">Sale Invoice</h2>

<p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
<p><strong>Customer:</strong> {{ $invoice->customer->name }}</p>
<p><strong>Invoice Date:</strong> {{ $invoice->invoice_date }}</p>

<table>
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

<p class="text-right"><strong>Total Amount: </strong>₹{{ number_format($invoice->total_amount, 2) }}</p>

</body>
</html>
