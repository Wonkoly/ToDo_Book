<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../controllers/authController.php';
require_once __DIR__ . '/../controllers/homeController.php';

// Obtener la ruta solicitada
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Manejo básico de rutas
if ($uri === '' || $uri === 'login') {
    login();
} elseif ($uri === 'register') {
    register();
} elseif ($uri === 'home') {
    home();
} elseif ($uri === 'add') {
    addItem();
} elseif ($uri === 'updateSettings') {
    updateSettings();
} elseif ($uri === 'deleteItem') {
    deleteItem();
} elseif ($uri === 'changeStatus') {
    changeStatus();
} elseif ($uri === 'logout') {
    logout();
} else {
    http_response_code(404);
    echo "Página no encontrada.";
}
?>