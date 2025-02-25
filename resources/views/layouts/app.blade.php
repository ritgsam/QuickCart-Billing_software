<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Software</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        @yield('content')
    </div>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="text-red-600">Logout</button>
</form>
</body>
</html>
