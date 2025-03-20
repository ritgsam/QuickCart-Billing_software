{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dropdown:hover .dropdown-menu {
            display: block;
            margin-top: 0;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Billing Software</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link fw-semibold" href="#">Dashboard</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold" href="#" id="mastersDropdown">Masters</a>
                        <ul class="dropdown-menu shadow-sm" aria-labelledby="mastersDropdown">
                            <li><a class="dropdown-item" href="{{ route('customers.index') }}">Customers</a></li>
                            <li><a class="dropdown-item" href="{{ route('suppliers.index') }}">Suppliers</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold" href="#" id="salesDropdown">Sales</a>
                        <ul class="dropdown-menu shadow-sm" aria-labelledby="salesDropdown">
                            <li><a class="dropdown-item" href="{{ route('sale_invoices.index') }}">All Invoices</a></li>
                            <li><a class="dropdown-item" href="{{ route('sale_invoices.create') }}">Create Invoice</a></li>
                            <li><a class="dropdown-item" href="{{ route('sale_payments.index') }}">Payments Record List</a></li>
                            <li><a class="dropdown-item" href="{{ route('sale_payments.create') }}">Create Payment Record</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold" href="#" id="purchaseDropdown">Purchase</a>
                        <ul class="dropdown-menu shadow-sm" aria-labelledby="purchaseDropdown">
                            <li><a class="dropdown-item" href="{{ route('purchase_invoices.index') }}">All Invoices</a></li>
                            <li><a class="dropdown-item" href="{{ route('purchase_invoices.create') }}">Create Invoice</a></li>
                            <li><a class="dropdown-item" href="{{ route('purchase_payments.index') }}">Payments Record List</a></li>
                            <li><a class="dropdown-item" href="{{ route('purchase_payments.create') }}">Create Payment Record</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="{{ route('reports.index') }}">Reports</a></li>
                    <li class="nav-item"><a class="nav-link fw-semibold" href="{{ route('users.index') }}">Users & Roles</a></li>
                    <li class="nav-item"><a class="nav-link text-danger fw-semibold" href="{{ route('logout') }}">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <h1 class="text-center fw-bold" id="greetingMessage"></h1>
        <p class="text-center text-muted">Welcome to your billing dashboard.</p>

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
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Product</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($low_stock_products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td class="text-danger fw-bold">{{ $product->stock }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function updateGreeting() {
            let greetingElement = document.getElementById("greetingMessage");
            let hour = new Date().getHours();
            let greeting = "";

            if (hour < 12) {
                greeting = "Good Morning";
            } else if (hour < 18) {
                greeting = "Good Afternoon";
            } else if (hour < 21) {
                greeting = "Good Evening";
            } else {
                greeting = "Good Night";
            }

            greetingElement.innerText = greeting + ", User!";
        }

        window.onload = updateGreeting;
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> --}}
