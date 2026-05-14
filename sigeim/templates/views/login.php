<?php
ob_start();
?>
<form id="loginForm">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');
    const loginForm = document.querySelector('#loginForm');
    const rememberMe = document.querySelector('#rememberMe');

    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            if (type === 'text') {
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        });
    }

    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            showToast('Éxito', 'Iniciando sesión...', 'success');
            if (rememberMe.checked) {
                document.cookie = "remember_me=true; path=/; max-age=" + (60*60*24*30);
            } else {
                document.cookie = "remember_me=true; path=/";
            }
            setTimeout(() => {
                window.location.href = '/admin';
            }, 1000);
        });
    }
});
</script>
<?php
$formContent = ob_get_clean();
include __DIR__ . '/../components/form_container.php';
?>
