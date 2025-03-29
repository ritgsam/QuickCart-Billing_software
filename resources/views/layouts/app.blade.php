<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Software</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="text-black" style="background-color: #e3d5ca;">

    @if(!in_array(Route::currentRouteName(), ['login', 'register', 'password.request']))
        <nav class="navbar navbar-expand-lg navbar-light shadow-sm" style="background-color: #d5bdaf;">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">QuickCart</a>

                <div class="ms-auto d-flex align-items-center">
                    <a href="{{ route('dashboard') }}" class="bi bi-house-door me-2 ">Dashboard </a>

                    <li class="nav-item dropdown">
                        <a class="bi bi-person-lines-fill dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Masters
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/customers') }}">Customers</a></li>
                            <li><a class="dropdown-item" href="{{ url('/suppliers') }}">Suppliers</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="bi bi-receipt dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Sales
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/sale_invoices') }}">All Invoices</a></li>
                            <li><a class="dropdown-item" href="{{ url('/sale_invoices/create') }}">Create Invoices</a></li>
                            <li><a class="dropdown-item" href="{{ url('/sale_payments') }}">Sale Payment Record</a></li>
                            <li><a class="dropdown-item" href="{{ url('/credit_notes') }}">Credit Note</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="bi bi-receipt dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                             Purchase
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/purchase_invoices/') }}">All Invoices</a></li>
                            <li><a class="dropdown-item" href="{{ url('/purchase_invoices/create') }}">Create Invoices</a></li>
                            <li><a class="dropdown-item" href="{{ url('/purchase_payments') }}">Purchase Payment Record</a></li>
                            <li><a class="dropdown-item" href="{{ url('/debit_notes') }}">Debit Note</a></li>
                        </ul>
                    </li>

                    <a href="{{ url('/categories') }}" class="bi bi-list-stars me-2">Categories</a>
                    <a href="{{ url('/products') }}" class="bi bi-box me-2">Products</a>
                    <a href="{{ url('/reports') }}" class="bi bi-building-fill-gear me-2">Reports</a>
                    {{-- <a href="{{ url('/users') }}" class="me-2">Users & Roles</a> --}}
                    <a href="{{ url('/settings') }}" class="bi bi-gear-wide-connected me-2">Settings</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bi bi-box-arrow-left btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
    @endif
    <div class="container mt-4">
        @yield('content')
    </div>
</body>
</html>
