<?php
require_once __DIR__ . '/helpers/loadEnv.php';

// Cargar variables de entorno desde el archivo .env
loadEnv(__DIR__ . '/.env');

// Conexión a la base de datos
$conn = new mysqli(
    getenv('DB_HOST'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_NAME'),
    getenv('DB_PORT') 
);

// Verifica la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}
?>