<?php
$title = 'Registro'; // Título de la página
include __DIR__ . '/partials/head.php'; // Incluye el <head>
?>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="width: 400px;">
        <h1 class="text-center mb-4">Registro</h1>
        <form action="/register" method="POST" novalidate>
            <!-- Nombre de usuario -->
            <div class="mb-3">
                <label for="username" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Tu nombre" required>
                <div class="invalid-feedback">
                    Por favor, ingresa un nombre de usuario.
                </div>
            </div>
            <!-- Correo Electrónico -->
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Tu correo electrónico" required>
                <div class="invalid-feedback">
                    Por favor, ingresa un correo válido.
                </div>
            </div>
            <!-- Contraseña -->
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Crea una contraseña" required>
                <div class="invalid-feedback">
                    Por favor, ingresa una contraseña.
                </div>
            </div>
            <!-- Confirmar contraseña -->
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirma tu contraseña" required>
                <div class="invalid-feedback">
                    Por favor, confirma tu contraseña.
                </div>
            </div>
            <!-- Botón de envío -->
            <button type="submit" class="btn btn-success w-100">Registrarse</button>
        </form>
        <p class="text-center mt-3">
            ¿Ya tienes cuenta? <a href="/login">Inicia sesión</a>
        </p>
    </div>
</div>
<script>
    // Bootstrap validación de formularios
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>
<?php include __DIR__ . '/partials/footer.php'; ?>