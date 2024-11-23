<?php
function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        die("El archivo .env no existe en la ruta especificada: $filePath");
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignora comentarios y líneas vacías
        if (strpos(trim($line), '#') === 0 || strpos($line, '=') === false) {
            continue;
        }
        // Divide las variables en clave y valor
        list($key, $value) = explode('=', $line, 2);
        putenv(trim($key) . '=' . trim($value));
    }
}
?>
