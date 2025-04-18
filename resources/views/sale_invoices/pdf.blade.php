
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sale Invoice PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; padding: 20px; }
        .invoice-box { padding: 20px; border: 1px solid #ddd; }
        .header { text-align: center; font-size: 24px; font-weight: bold; padding-bottom: 10px; }
        .grid-container { display: flex; justify-content: space-between; }
        .details { font-size: 16px; width: 50%; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { padding: 8px; text-align: center; border: 1px solid black; }
        .table th { background-color: #eee; }
        .highlight { background-color: #f9f9f9; padding: 10px; font-size: 18px; font-weight: bold; text-align: right; }
    </style>
</head>
<body>

<div class="invoice-box">
    <div class="header">Sale Invoice</div>

    <div class="grid-container">
        <div class="details">
            <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date }}</p>
        </div>
        <div class="details">
            <p><strong>Customer:</strong> {{ $invoice->customer->name }}</p>
            <p><strong>Due Date:</strong> {{ $invoice->due_date }}</p>
        </div>
    </div>

<thead>
    <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Unit Price</th>
        <th>SGST (%)</th>
        <th>CGST (%)</th>
        <th>IGST (%)</th>
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
        <td>{{ $item->sgst }}%</td>
        <td>{{ $item->cgst }}%</td>
        <td>{{ $item->igst }}%</td>
        <td>{{ $item->discount }}%</td>
        <td>₹{{ number_format($item->total_price, 2) }}</td>
    </tr>
    @endforeach
</tbody>

@if($invoice->transportation)
    <div class="grid-container mt-3">
        <div class="details">
            <h3>Transportation Details</h3>
            <p><strong>Transporter:</strong> {{ $invoice->transportation->transporter_name }}</p>
            <p><strong>Vehicle Number:</strong> {{ $invoice->transportation->vehicle_number }}</p>
            <p><strong>Dispatch Date:</strong> {{ $invoice->transportation->dispatch_date }}</p>
            <p><strong>Expected Delivery:</strong> {{ $invoice->transportation->expected_delivery_date }}</p>
            <p><strong>Status:</strong> {{ $invoice->transportation->status }}</p>
        </div>
    </div>
@endif

<p class="highlight">Final Amount: ₹{{ number_format($invoice->final_amount, 2) }}</p>

    </table>

    {{-- <p class="highlight">Total Amount: ₹{{ number_format($invoice->total_amount, 2) }}</p> --}}
</div>

</body>
</html>
