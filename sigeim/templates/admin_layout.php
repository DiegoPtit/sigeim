<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SIGEIM Admin' ?></title>
    
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
            
            --sidebar-width: 260px;
        }

        [data-bs-theme="dark"] {
            --bs-body-bg: #000000;
            --bs-body-color: #e1e1e1;
            --bs-tertiary-bg: #050505;
            --bs-secondary-bg: #121212;
            --bs-border-color: #1a1a1a;
            
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
        }
        
        #sidebar {
            width: var(--sidebar-width);
            background-color: #ffffff;
            border-right: 1px solid var(--bs-border-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1000;
        }
        
        [data-bs-theme="dark"] #sidebar {
            background-color: #050505;
            border-right: 1px solid rgba(255, 255, 255, 0.03);
        }

        #sidebar .border-bottom {
            height: 80px;
            display: flex;
            align-items: center;
            padding: 0 1.5rem !important;
        }

        #main-content header {
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            background-color: #ffffff;
            margin: -2rem -2rem 2rem -2rem;
            padding: 0 2rem;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        [data-bs-theme="dark"] #main-content header {
            background-color: #050505;
            border-bottom: 1px solid #111111;
            box-shadow: none;
        }

        #main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 2rem;
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

        .nav-link {
            color: var(--bs-body-color);
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            border-radius: 0.375rem;
            margin: 0.15rem 0.75rem;
            transition: all 0.2s;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .nav-link .icon-sm,
        .nav-link svg {
            margin-right: 1.25rem !important;
        }

        .nav-link:hover {
            background-color: rgba(var(--bs-primary-rgb), 0.1);
            color: var(--bs-primary);
        }

        .nav-link.active {
            background-color: var(--bs-primary);
            color: white;
            box-shadow: 0 4px 12px rgba(var(--bs-primary-rgb), 0.3);
        }

        [data-bs-theme="dark"] .nav-link.active {
            background-color: #2a2a2a;
            color: #ffffff;
            box-shadow: none;
        }

        #theme-toggle {
            color: var(--bs-body-color);
            transition: color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
        }

        #theme-toggle:hover {
            color: var(--bs-primary) !important;
        }

        #theme-toggle .icon-sm,
        #theme-toggle svg {
            margin-right: 0 !important;
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

    <aside id="sidebar">
        <div class="border-bottom">
            <a class="navbar-brand d-flex align-items-center text-decoration-none text-body fw-bold" href="/admin">
                <img src="<?= asset('img/logo.svg') ?>" alt="Logo" height="32" class="me-2">
                SIGEIM
            </a>
        </div>
        <div class="py-3 flex-grow-1">
            <nav class="nav flex-column">
                <a class="nav-link active" href="/admin">
                    <i data-lucide="home" class="icon-sm"></i>Inicio
                </a>
                <a class="nav-link" href="#">
                    <i data-lucide="printer" class="icon-sm"></i>Cola de Impresión
                </a>
                <a class="nav-link" href="#">
                    <i data-lucide="folder-open" class="icon-sm"></i>Repositorio
                </a>
                <a class="nav-link" href="#">
                    <i data-lucide="building-2" class="icon-sm"></i>Departamentos
                </a>
                <a class="nav-link" href="#">
                    <i data-lucide="users" class="icon-sm"></i>Usuarios
                </a>
            </nav>
        </div>
        <div class="p-3 border-top d-flex align-items-center justify-content-between">
            <button class="btn btn-link m-0 p-0 shadow-none" id="theme-toggle" title="Cambiar tema">
                <i data-lucide="sun" id="theme-icon-light" class="icon-sm"></i>
                <i data-lucide="moon" id="theme-icon-dark" class="icon-sm d-none"></i>
            </button>
            <button onclick="logout()" class="btn btn-danger btn-sm shadow-sm px-3">
                <i data-lucide="log-out" class="icon-sm me-2"></i>Salir
            </button>
        </div>
    </aside>

    <main id="main-content">
        <header class="mb-4 d-flex justify-content-between align-items-center">
            <h2 class="h4 fw-bold mb-0"><?= $title ?? 'Panel de Administración' ?></h2>
            <div class="text-muted small">Admin User</div>
        </header>
        
        <?= $content ?? 'No content loaded.' ?>
    </main>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function logout() {
            document.cookie = "remember_me=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
            window.location.href = '/login';
        }
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
