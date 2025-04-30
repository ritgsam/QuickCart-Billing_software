<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        body { background-color: #e3d5ca; }
        .dropdown:hover .dropdown-menu { display: block; margin-top: 0; }
        .card { border: none; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); }
        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm" style="background-color: #d5bdaf;">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#" style="color: rgb(59, 57, 57)">QuickCart</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link fw-semibold" href="#"></a></li>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="bi bi-house-door  nav-link fw-semibold" href="#">Dashboard</a></li>
                    <li class="nav-item dropdown">
                        <a class="bi bi-person-lines-fill nav-link dropdown-toggle fw-semibold" href="#" id="mastersDropdown">Masters</a>
                        <ul class="dropdown-menu shadow-sm" aria-labelledby="mastersDropdown">
                            <li><a class="dropdown-item" href="{{ url('/customers') }}">Customers</a></li>
                            <li><a class="dropdown-item" href="{{ url('/suppliers') }}">Suppliers</a></li>
                            <li><a class="dropdown-item" href="{{ url('/products') }}">Products</a></li>
                            <li><a class="dropdown-item" href="{{ url('/categories') }}">Categories</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="bi bi-receipt nav-link dropdown-toggle fw-semibold" href="#" id="salesDropdown">Sales</a>
                        <ul class="dropdown-menu shadow-sm" aria-labelledby="salesDropdown">
                            <li><a class="dropdown-item" href="{{ url('/sale_invoices') }}">All Invoices</a></li>
                            <li><a class="dropdown-item" href="{{ url('/sale_invoices/create') }}">Create Invoices</a></li>
                            <li><a class="dropdown-item" href="{{ url('/sale_payments') }}">Sale Payment Record</a></li>
                            <li><a class="dropdown-item" href="{{ url('/credit_notes') }}">Credit Note</a></li>
                            <li><a class="dropdown-item" href="{{ url('/transportations') }}">Transportations</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="bi bi-receipt nav-link dropdown-toggle fw-semibold" href="#" id="purchaseDropdown">Purchase</a>
                        <ul class="dropdown-menu shadow-sm" aria-labelledby="purchaseDropdown">
                            <li><a class="dropdown-item" href="{{ url('/purchase_invoices/') }}">All Invoices</a></li>
                            <li><a class="dropdown-item" href="{{ url('/purchase_invoices/create') }}">Create Invoices</a></li>
                            <li><a class="dropdown-item" href="{{ url('/purchase_payments') }}">Purchase Payment Record</a></li>
                            <li><a class="dropdown-item" href="{{ url('/debit_notes') }}">Debit Note</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="bi bi-building-fill-gear nav-link fw-semibold" href="{{ url('/reports') }}">Reports</a></li>
                     <li class="nav-item"><a class="bi bi-gear-wide-connected nav-link fw-semibold" href="{{ url('/settings') }}">Settings</a></li>
                </ul>
            </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bi bi-box-arrow-left nav-link text-danger fw-semibold">Logout</button>
                </form>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
<h1 class="text-center fw-bold">{{ $greeting }}, User!</h1>
        <p class="text-center text-muted">Welcome to your QuickCart</p>

        <div class="dashboard-grid mt-4">
            <div class="card text-center p-3 "style="background-color: rgb(238, 231, 231)">
                <h5 class="card-title text-primary" >Total Sales (This Month)</h5>
                <p class="display-6 fw-bold">₹{{ number_format($total_sales_month, 2) }}</p>
            </div>
            <div class="card text-center p-3 "style="background-color: rgb(238, 231, 231)">
                <h5 class="card-title text-success">Total Purchases (This Month)</h5>
                <p class="display-6 fw-bold">₹{{ number_format($total_purchases_month, 2) }}</p>
            </div>
            <div class="card text-center p-3 "style="background-color: rgb(238, 231, 231)">
                <h5 class="card-title text-primary">Total Sales</h5>
                <p class="display-6 fw-bold">₹{{ number_format($total_sales, 2) }}</p>
            </div>
            <div class="card text-center p-3 "style="background-color: rgb(238, 231, 231)">
                <h5 class="card-title text-warning">Pending Customer Payments</h5>
                <p class="display-6 fw-bold">₹{{ number_format($pending_customer_payments, 2) }}</p>
            </div>
            <div class="card text-center p-3 "style="background-color: rgb(238, 231, 231)">
                <h5 class="card-title text-danger">Pending Supplier Payments</h5>
                <p class="display-6 fw-bold">₹{{ number_format($pending_supplier_payments, 2) }}</p>
            </div>
        </div>

      <h2 class="mt-5 text-center fw-bold" >Low Stock Alerts</h2>
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
                    <td style="background-color: rgb(238, 231, 231)">{{ $product->name }}</td>
                    <td class="text-danger fw-bold" style="background-color: rgb(238, 231, 231)">{{ $product->stock }}</td>
                    <td style="background-color: rgb(238, 231, 231)">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn text-white btn-sm" style="background-color: rgba(43, 42, 42, 0.694);">Edit Stock</a>
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
<div class="card p-3 mt-4" style="background-color: #e3d5ca;">
    <h5 class="text-center text-primary">Total Sales Trend (Last 7 Days)</h5>
    <canvas id="totalSalesChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('totalSalesChart').getContext('2d');
    const totalSalesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($sales_days) !!},
            datasets: [{
                label: 'Total Sales (₹)',
                data: {!! json_encode($sales_amounts) !!},
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1000,
                easing: 'easeInOutQuad'
            },
            scales: {
                x: { title: { display: true, text: 'Days' } },
                y: { title: { display: true, text: 'Sales Amount (₹)' }, beginAtZero: true }
            }
        }
    });
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
