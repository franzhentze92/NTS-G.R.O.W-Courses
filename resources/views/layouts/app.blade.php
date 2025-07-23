<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NTS G.R.O.W LMS</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- jQuery (Google CDN - more reliable) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        body { background-color: #f8fafc !important; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <!-- Removed navbar for a cleaner look -->

    @yield('content')

    <footer class="text-center small mt-5 mb-3" style="width: 100%; font-family: Inter, system-ui, sans-serif; font-size: 0.95rem; color: #888; letter-spacing: 1px; padding: 0.75rem 0;">
        Powered by NTS G.R.O.W
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 