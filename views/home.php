<?php
$title = 'Inicio';
include __DIR__ . '/partials/head.php';

// Cargar datos del usuario y libros desde la base de datos
session_start();
$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'] ?? 'Usuario';
$profilePhoto = getUserProfilePhoto($userId); // Obtener la foto de perfil
$books = getItemsByUser($userId); // Obtener los libros del usuario
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/home">ToDoBook</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= htmlspecialchars($profilePhoto) ?>" alt="Foto de perfil" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                        <span><?= htmlspecialchars($userName) ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#settingsModal">Configuración</a></li>
                        <li><a class="dropdown-item" href="/logout">Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Tabla | Filtros -->
<div class="container mt-5 d-flex flex-column" style="min-height: calc(100vh - 56px - 56px);">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>ToDoBook</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-plus"></i> Añadir Nuevo</button>
    </div>

    <!-- Filtros -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <select id="typeFilter" class="form-select d-inline-block" style="width: auto;">
                <option value="todo">Todo</option>
                <option value="libro">Libros</option>
                <option value="serie">Series</option>
                <option value="pelicula">Películas</option>
            </select>
        </div>
        <div>
            <select id="statusFilter" class="form-select d-inline-block" style="width: auto;">
                <option value="todo">Todo</option>
                <option value="completado">Completado</option>
                <option value="pendiente">Pendiente</option>
            </select>
        </div>
    </div>

    <!-- Tabla de elementos -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Título</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="booksTable">
            <?php foreach ($books as $book): ?>
            <tr data-type="<?= htmlspecialchars($book['type']) ?>" data-status="<?= htmlspecialchars($book['status']) ?>">
                <td><?= htmlspecialchars($book['title']) ?></td>
                <td><?= htmlspecialchars($book['type']) ?></td>
                <td><?= htmlspecialchars($book['status']) ?></td>
                <td>
                    <!-- Botón para eliminar -->
                    <form method="post" action="/deleteItem" style="display:inline;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($book['id'] ?? '') ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>

                    <!-- Botón para cambiar estado -->
                    <form method="POST" action="/changeStatus" style="display:inline;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($book['id']) ?>">
                        <input type="hidden" name="status" value="<?= $book['status'] === 'pendiente' ? 'completado' : 'pendiente' ?>">
                        <button type="submit" class="btn btn-warning btn-sm">
                            <?= $book['status'] === 'pendiente' ? 'Marcar como Completado' : 'Marcar como Pendiente' ?>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
    <p>&copy; <?= date('Y') ?> ToDo_Book. Todos los derechos reservados.</p>
</footer>

<!-- Modal de Configuración -->
<div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="settingsModalLabel">Configuración</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/updateSettings" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="todoistApiKey" class="form-label">API Key de Todoist</label>
                        <input type="text" class="form-control" id="todoistApiKey" name="todoistApiKey" placeholder="Tu API Key de Todoist">
                    </div>
                    <div class="mb-3">
                        <label for="profilePhoto" class="form-label">Foto de Perfil</label>
                        <input type="file" class="form-control" id="profilePhoto" name="profilePhoto" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Añadir Nuevo -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Añadir Nuevo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/add" method="POST">
                    <div class="mb-3">
                        <label for="title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Tipo</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="libro">Libro</option>
                            <option value="serie">Serie</option>
                            <option value="pelicula">Película</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Estado</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pendiente">Pendiente</option>
                            <option value="completado">Completado</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script> 
    // Filtros para la tabla 
    const typeFilter = document.getElementById('typeFilter');
    const statusFilter = document.getElementById('statusFilter');
    const booksTable = document.getElementById('booksTable');

    function filterTable() {
        const type = typeFilter.value;
        const status = statusFilter.value;

        Array.from(booksTable.rows).forEach(row => {
            const rowType = row.getAttribute('data-type');
            const rowStatus = row.getAttribute('data-status');

            const typeMatch = type === 'todo' || type === rowType;
            const statusMatch = status === 'todo' || status === rowStatus;

            row.style.display = typeMatch && statusMatch ? 'table-row' : 'none';
        });
    }

    typeFilter.addEventListener('change', filterTable);
    statusFilter.addEventListener('change', filterTable);
</script>
