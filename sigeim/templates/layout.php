<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SIGEIM' ?></title>
    
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        :root {
            --bs-body-bg: #f8f8f8;
            --toast-warning: #fff3cd;
            --toast-error: #f8d7da;
            --toast-info: #cff4fc;
            --toast-success: #d1e7dd;
            
            --toast-warning-border: #ffe69c;
            --toast-error-border: #f1aeb5;
            --toast-info-border: #9eeaf9;
            --toast-success-border: #a3cfbb;
        }

        [data-bs-theme="dark"] {
            --bs-body-bg: #000000;
            --bs-body-color: #e1e1e1;
            --bs-tertiary-bg: #050505;
            --bs-secondary-bg: #121212;
            --bs-border-color: #1a1a1a;
            
            --bs-emphasis-color: #ffffff;
            --bs-secondary-color: #a0a0a0;
            
            --toast-warning: #332701;
            --toast-error: #2c0b0e;
            --toast-info: #032830;
            --toast-success: #051b11;
            
            --toast-warning-border: #664d03;
            --toast-error-border: #842029;
            --toast-info-border: #087990;
            --toast-success-border: #0f5132;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bs-body-bg);
            transition: background-color 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .navbar {
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        [data-bs-theme="dark"] .navbar {
            background-color: #050505 !important;
            border-bottom-color: #111111 !important;
            box-shadow: none;
        }
        .card {
            border: 1px solid var(--bs-border-color);
            background-color: #ffffff;
            box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.05);
        }
        [data-bs-theme="dark"] .card {
            background-color: var(--bs-secondary-bg);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .icon-sm {
            width: 18px;
            height: 18px;
            vertical-align: text-bottom;
        }
        
        /* Toast Styles */
        #toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1060;
        }
        .custom-toast {
            min-width: 250px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            border-radius: 0.5rem;
            border: 1px solid transparent;
            display: flex;
            align-items: center;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            animation: slideIn 0.3s ease-out forwards;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .toast-success { background-color: var(--toast-success); border-color: var(--toast-success-border); color: #0f5132; }
        .toast-error { background-color: var(--toast-error); border-color: var(--toast-error-border); color: #842029; }
        .toast-warning { background-color: var(--toast-warning); border-color: var(--toast-warning-border); color: #664d03; }
        .toast-info { background-color: var(--toast-info); border-color: var(--toast-info-border); color: #055160; }
        
        [data-bs-theme="dark"] .toast-success { color: #d1e7dd; }
        [data-bs-theme="dark"] .toast-error { color: #f8d7da; }
        [data-bs-theme="dark"] .toast-warning { color: #fff3cd; }
        [data-bs-theme="dark"] .toast-info { color: #cff4fc; }
    </style>
</head>
<body>

    <div id="toast-container"></div>

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
                <div class="ms-auto d-flex align-items-center">
                    <button class="btn btn-link nav-link me-3" id="theme-toggle" title="Cambiar tema">
                        <i data-lucide="sun" id="theme-icon-light" class="icon-sm"></i>
                        <i data-lucide="moon" id="theme-icon-dark" class="icon-sm d-none"></i>
                    </button>
                    <a href="/login" class="btn btn-primary shadow-sm">
                        <i data-lucide="log-in" class="me-2 icon-sm"></i>Acceso
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-5 flex-grow-1 d-flex flex-column">
        <?= $content ?? 'No content loaded.' ?>
    </main>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Theme Switcher Logic
        const themeToggle = document.getElementById('theme-toggle');
        const sunIcon = document.getElementById('theme-icon-light');
        const moonIcon = document.getElementById('theme-icon-dark');
        const html = document.documentElement;

        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-bs-theme', savedTheme);
        updateThemeIcons(savedTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcons(newTheme);
        });

        function updateThemeIcons(theme) {
            if (theme === 'dark') {
                sunIcon.classList.add('d-none');
                moonIcon.classList.remove('d-none');
            } else {
                sunIcon.classList.remove('d-none');
                moonIcon.classList.add('d-none');
            }
        }

        // Modular Toast System
        function showToast(title, message, type = 'info') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `custom-toast toast-${type}`;
            
            let icon = 'info';
            if (type === 'success') icon = 'check-circle';
            if (type === 'error') icon = 'alert-circle';
            if (type === 'warning') icon = 'alert-triangle';

            toast.innerHTML = `
                <i data-lucide="${icon}" class="me-3"></i>
                <div>
                    <div class="fw-bold small">${title}</div>
                    <div class="small">${message}</div>
                </div>
            `;
            
            container.appendChild(toast);
            lucide.createIcons();

            setTimeout(() => {
                toast.style.animation = 'slideIn 0.3s ease-out reverse';
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }
    </script>
</body>
</html>
