<div class="row justify-content-center flex-grow-1 align-items-center">
    <div class="col-12 d-flex justify-content-center" style="margin-top: -10vh;">
        <div class="card shadow-sm border-0 overflow-hidden" style="width: 50dvw; min-width: 320px;">
            <div class="bg-primary p-4 text-white text-start">
                <h2 class="h3 fw-bold mb-1">SIGEBIM</h2>
                <p class="mb-0 small opacity-75">Iniciar Sesión en el sistema</p>
            </div>
            <div class="card-body p-5 d-flex justify-content-center">
                <form id="loginForm" style="width: 100%; max-width: 350px;">
                    <div class="mb-3">
                        <label for="username" class="form-label small fw-semibold">Usuario</label>
                        <div class="input-group">
                            <span class="input-group-text bg-body-tertiary border-end-0">
                                <i data-lucide="user" class="icon-sm text-muted"></i>
                            </span>
                            <input type="text" class="form-control bg-body-tertiary border-start-0 ps-0" id="username" placeholder="Tu usuario" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label small fw-semibold">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text bg-body-tertiary border-end-0">
                                <i data-lucide="lock" class="icon-sm text-muted"></i>
                            </span>
                            <input type="password" class="form-control bg-body-tertiary border-start-0 border-end-0 ps-0" id="password" placeholder="••••••••" required>
                            <button class="btn btn-outline-secondary border-start-0 bg-body-tertiary border-light-subtle" type="button" id="togglePassword">
                                <i data-lucide="eye" class="icon-sm text-muted" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label small text-muted" for="rememberMe">
                                Recuérdame
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 shadow-sm mb-3">
                        <i data-lucide="log-in" class="me-2 icon-sm"></i>Iniciar Sesión
                    </button>
                    <div class="text-center">
                        <a href="/" class="text-decoration-none small text-muted">
                            <i data-lucide="arrow-left" class="me-1 icon-sm"></i>Volver al inicio
                        </a>
                    </div>
                    </form>
                    </div>
                    </div>
                    </div>
                    </div>

                    <style>
                    /* Ajustes específicos para inputs en modo oscuro */
                    [data-bs-theme="dark"] .input-group-text,
                    [data-bs-theme="dark"] .form-control,
                    [data-bs-theme="dark"] .btn-outline-secondary {
                    background-color: #080808 !important;
                    border-color: #1a1a1a !important;
                    color: #e1e1e1 !important;
                    }

                    [data-bs-theme="dark"] .form-control:focus {
                    background-color: #0a0a0a !important;
                    border-color: var(--bs-primary) !important;
                    box-shadow: none;
                    }
                    </style>

                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                    const togglePassword = document.querySelector('#togglePassword');
                    const password = document.querySelector('#password');
                    const eyeIcon = document.querySelector('#eyeIcon');
                    const loginForm = document.querySelector('#loginForm');
                    const rememberMe = document.querySelector('#rememberMe');

                    togglePassword.addEventListener('click', function() {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);

                    // Change icon
                    if (type === 'text') {
                    eyeIcon.setAttribute('data-lucide', 'eye-off');
                    } else {
                    eyeIcon.setAttribute('data-lucide', 'eye');
                    }
                    lucide.createIcons();
                    });

                    loginForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Simple Login Simulation
                    showToast('Éxito', 'Iniciando sesión...', 'success');

                    // Set cookie if remember me is checked (simulated persistence)
                    if (rememberMe.checked) {
                    document.cookie = "remember_me=true; path=/; max-age=" + (60*60*24*30); // 30 days
                    } else {
                    document.cookie = "remember_me=true; path=/"; // Session only
                    }

                    setTimeout(() => {
                    window.location.href = '/admin';
                    }, 1000);
                    });
                    });
                    </script>

