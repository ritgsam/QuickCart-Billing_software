@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2> Financial Report</h2>

    <table class="table table-bordered">
        <tr>
            <th>Total Sales (₹)</th>
            <td>₹{{ number_format($total_sales, 2) }}</td>
        </tr>
        <tr>
            <th>Total Purchases (₹)</th>
            <td>₹{{ number_format($total_purchases, 2) }}</td>
        </tr>
        <tr>
            <th>Net Profit (₹)</th>
            <td class="{{ $profit >= 0 ? 'text-success' : 'text-danger' }}">
                ₹{{ number_format($profit, 2) }}
            </td>
        </tr>
    </table>
</div>
@endsection
