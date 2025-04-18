
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Invoice PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            padding: 20px;
            color: #000;
        }

        .invoice-box {
            border: 1px solid #ddd;
            padding: 20px;
        }

        .header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .details {
            font-size: 16px;
            line-height: 1.6;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .summary {
            margin-top: 20px;
            text-align: right;
            font-size: 16px;
        }

        .summary p {
            margin: 4px 0;
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
            <p><strong>Supplier:</strong> {{ $invoice->supplier->company_name ?? '-' }}</p>
        </div>
    </div>

    <table class="table">
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
                    <td>{{ $item->sgst ?? 0 }}%</td>
                    <td>{{ $item->cgst ?? 0 }}%</td>
                    <td>{{ $item->igst ?? 0 }}%</td>
                    <td>{{ $item->discount ?? 0 }}%</td>
                    <td>₹{{ number_format($item->total_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <p><strong>Subtotal:</strong> ₹{{ number_format($invoice->subtotal ?? 0, 2) }}</p>
        <p><strong>Total SGST:</strong> ₹{{ number_format($invoice->total_sgst ?? 0, 2) }}</p>
        <p><strong>Total CGST:</strong> ₹{{ number_format($invoice->total_cgst ?? 0, 2) }}</p>
        <p><strong>Total IGST:</strong> ₹{{ number_format($invoice->total_igst ?? 0, 2) }}</p>
        <p><strong>Total Discount:</strong> ₹{{ number_format($invoice->total_discount ?? 0, 2) }}</p>
        <p><strong>Round Off:</strong> ₹{{ number_format($invoice->round_off ?? 0, 2) }}</p>
        <p><strong>Final Amount:</strong> ₹{{ number_format($invoice->final_amount ?? $invoice->total_amount, 2) }}</p>
    </div>
</div>

</body>
</html>
