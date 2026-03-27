<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Vendo | Premium Multi-Vendor Marketplace')</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Core CSS (From your previous static frontend) -->
    <link rel="stylesheet" href="{{ asset('ecommerce_frontend/css/style.css') }}">
    
    <!-- Custom Page CSS -->
    @stack('styles')
</head>
<body>

    @include('partials.navbar')

    <!-- MAIN CONTENT -->
    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- App JS (Authenticates the static state) -->
    <script src="{{ asset('ecommerce_frontend/js/app.js') }}"></script>
    
    <!-- Custom Page Scripts -->
    @stack('scripts')
</body>
</html>
