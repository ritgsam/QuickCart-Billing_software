<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Software</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-gray-100">

    @if(!in_array(Route::currentRouteName(), ['login', 'register', 'password.request']))
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">QuickCart</a>

                <div class="ms-auto d-flex align-items-center">
                    <a href="{{ route('dashboard') }}" class="me-2">Dashboard</a>

                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Masters
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/customers') }}">Customers</a></li>
                            <li><a class="dropdown-item" href="{{ url('/suppliers') }}">Suppliers</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
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
                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                             Purchase
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/purchase_invoices/') }}">All Invoices</a></li>
                            <li><a class="dropdown-item" href="{{ url('/purchase_invoices/create') }}">Create Invoices</a></li>
                            <li><a class="dropdown-item" href="{{ url('/purchase_payments') }}">Purchase Payment Record</a></li>
                            <li><a class="dropdown-item" href="{{ url('/debit_notes') }}">Debit Note</a></li>
                        </ul>
                    </li>

                    <a href="{{ url('/categories') }}" class="me-2">Categories</a>
                    <a href="{{ url('/products') }}" class="me-2">Products</a>
                    <a href="{{ url('/reports') }}" class="me-2">Reports</a>
                    <a href="{{ url('/users') }}" class="me-2">Users & Roles</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
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



{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Software</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-gray-100">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">QuickCart</a>

            <div class="ms-auto d-flex align-items-center">
                <a href="{{ route('dashboard') }}" class=" me-2">Dashboard</a>

                    <li class="nav-item dropdown">
                        <a class=" dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Masters
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/customers">Customers</a></li>
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/suppliers">Suppliers</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class=" dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Sales
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/sale_invoices">All Invoices</a></li>
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/sale_invoices/create">Create Invoices</a></li>
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/sale_payments">Sale Payment Record</a></li>
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/credit_notes">Credit Note</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class=" dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                             Purchase
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/purchase_invoices/"> All Invoices</a></li>
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/purchase_invoices/create">Create Invoices</a></li>
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/purchase_payments">Purchase Payment Record</a></li>
                            <li><a class="dropdown-item" href="http://127.0.0.1:8000/debit_notes">Debit Note</a></li>
                        </ul>
                    </li>
                                    <a href="http://127.0.0.1:8000/categories" class=" me-2">Categories</a>
                                    <a href="http://127.0.0.1:8000/products" class=" me-2">Products</a>

                                    <a href="http://127.0.0.1:8000/reports" class=" me-2">Reports</a>

                                    <a href="http://127.0.0.1:8000/users" class=" me-2">Users&Roles</a>


                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>
</body>
</html> --}}


{{--  --}}
{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Software</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-gray-100">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">QuickCart</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>

                    <!-- Masters Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Masters
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('customers.index') }}">Customers</a></li>
                            <li><a class="dropdown-item" href="{{ route('suppliers.index') }}">Suppliers</a></li>
                        </ul>
                    </li>

                    <!-- Logout -->
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

</body>
</html> --}}
