<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Our Service</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-dark">

    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center text-center px-3">
        <h1 class="display-4 fw-bold mb-3">👋 Welcome to Integration Service</h1>
        <p class="lead mb-4 w-75">
            This service provides product data and connects to the user service to enable integrated service-to-service communication.
        </p>

        <a href="{{ route('menus.index') }}" class="btn btn-primary btn-lg px-4 py-2 shadow">
            🚀 Go to Menus
        </a>
    </div>

    <!-- Optional: Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
