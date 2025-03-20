<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .dropdown:hover .dropdown-menu { display: block; margin-top: 0; }
        .card { border: none; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); }
        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">QuickCart</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link fw-semibold" href="#"></a></li>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link fw-semibold" href="#">Dashboard</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold" href="#" id="mastersDropdown">Masters</a>
                        <ul class="dropdown-menu shadow-sm" aria-labelledby="mastersDropdown">
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/customers">Customers</a></li>
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/suppliers">Suppliers</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold" href="#" id="salesDropdown">Sales</a>
                        <ul class="dropdown-menu shadow-sm" aria-labelledby="salesDropdown">
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/sale_invoices">All Invoices</a></li>
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/sale_invoices/create">Create Invoices</a></li>
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/sale_payments">Sale Payment Record</a></li>
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/credit_notes">Credit Note</a></li>
                            {{-- <li><a class="dropdown-item" href="http://127.0.0.1:8000/sale_payments/create">Sale Payments</a></li> --}}
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold" href="#" id="purchaseDropdown">Purchase</a>
                        <ul class="dropdown-menu shadow-sm" aria-labelledby="purchaseDropdown">
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/purchase_invoices/">All Invoices</a></li>
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/purchase_invoices/create">Create Invoices</a></li>
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/purchase_payments">Purchase Payment Record</a></li>
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/debit_notes">Debit Note</a></li>
                            {{-- <li><a class="dropdown-item" href="http://127.0.0.1:8000/purchase_payments/create">Purchase Payments</a></li> --}}
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="http://127.0.0.1:8000/categories">Categories</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="http://127.0.0.1:8000/products">Products</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="http://127.0.0.1:8000/reports">Reports</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="http://127.0.0.1:8000/users">Users & Roles</a></li>
                </ul>
            </div>

                    <li class="nav-item"><a class="nav-link text-danger fw-semibold" href="http://127.0.0.1:8000/">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
<h1 class="text-center fw-bold">{{ $greeting }}, User!</h1>
        {{-- <h1 class="text-center fw-bold">{{ $greeting }}, User!</h1> --}}
{{-- <h1 class="text-center fw-bold">{{ $greeting }}, {{ auth()->user()->name ?? 'User' }}!</h1> --}}
        <p class="text-center text-muted">Welcome to your QuickCart</p>

        <div class="dashboard-grid mt-4">
            <div class="card text-center p-3 bg-white">
                <h5 class="card-title text-primary">Total Sales (This Month)</h5>
                <p class="display-6 fw-bold">₹{{ number_format($total_sales_month, 2) }}</p>
            </div>
            <div class="card text-center p-3 bg-white">
                <h5 class="card-title text-success">Total Purchases (This Month)</h5>
                <p class="display-6 fw-bold">₹{{ number_format($total_purchases_month, 2) }}</p>
            </div>
            <div class="card text-center p-3 bg-white">
                <h5 class="card-title text-primary">Total Sales</h5>
                <p class="display-6 fw-bold">₹{{ number_format($total_sales, 2) }}</p>
            </div>
            <div class="card text-center p-3 bg-white">
                <h5 class="card-title text-warning">Pending Customer Payments</h5>
                <p class="display-6 fw-bold">₹{{ number_format($pending_customer_payments, 2) }}</p>
            </div>
            <div class="card text-center p-3 bg-white">
                <h5 class="card-title text-danger">Pending Supplier Payments</h5>
                <p class="display-6 fw-bold">₹{{ number_format($pending_supplier_payments, 2) }}</p>
            </div>
        </div>

      <h2 class="mt-5 text-center fw-bold">Low Stock Alerts</h2>
@if ($low_stock_products->isEmpty())
    <p class="text-center text-muted">All products have sufficient stock.</p>
@else
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Product Name</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($low_stock_products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td class="text-danger fw-bold">{{ $product->stock }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit Stock</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

                <tbody>
                    @forelse ($low_stock_products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td class="text-danger fw-bold">{{ $product->stock }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-success">All products have sufficient stock!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
