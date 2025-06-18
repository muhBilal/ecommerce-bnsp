<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Aplikasi' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">Aplikasi</a>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
