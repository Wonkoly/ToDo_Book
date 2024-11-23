<?php
$title = 'Iniciar Sesión'; // Define el título de la página
include __DIR__ . '/partials/head.php'; // Incluye el <head>
?>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 400px;">
        <h1 class="text-center mb-4">Iniciar Sesión</h1>
        <form action="/login" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Correo" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
        </form>
        <p class="text-center mt-3">
            ¿No tienes cuenta? <a href="/register">Regístrate</a>
        </p>
    </div>
</div>
<?php include __DIR__ . '/partials/footer.php'; // Opcionalmente, incluye el footer ?>

