<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGEIM</title>
    
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bs-tertiary-bg);
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .icon-sm {
            width: 18px;
            height: 18px;
            vertical-align: text-bottom;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg border-bottom bg-body">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="<?= asset('img/logo.svg') ?>" alt="Logo" height="32" class="me-2">
                SIGEIM
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto">
                    <a href="/login" class="btn btn-primary shadow-sm">
                        <i data-lucide="log-in" class="me-2 icon-sm"></i>Acceso
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <?= $content ?? 'No content loaded.' ?>
    </main>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();
    </script>
</body>
</html>
