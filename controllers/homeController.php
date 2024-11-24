<?php
require_once __DIR__ . '/../models/itemModel.php';

function home() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }

    $userId = $_SESSION['user_id'];
    $items = getItemsByUser($userId); // Obtener elementos del usuario desde la base de datos

    require_once __DIR__ . '/../views/home.php';
}

function addItem() {
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_SESSION['user_id'];
        $title = $_POST['title'];
        $type = $_POST['type'];
        $status = $_POST['status'];

        createItem($userId, $title, $type, $status); // Guardar el elemento en la base de datos
        header('Location: /home');
        exit;
    }
}

function updateSettings() {
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_SESSION['user_id'];

        // Guardar la API Key de Todoist
        $apiKey = $_POST['todoistApiKey'] ?? '';
        if (!empty($apiKey)) {
            updateUserApiKey($userId, $apiKey);
        }

        // Subir la foto de perfil
        if (!empty($_FILES['profilePhoto']['name'])) {
            $uploadDir = __DIR__ . '/../public/uploads/';
            $fileName = $userId . '_profile_' . basename($_FILES['profilePhoto']['name']);
            $targetFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['profilePhoto']['tmp_name'], $targetFile)) {
                updateUserProfilePhoto($userId, '/uploads/' . $fileName); // Guardar la ruta en la base de datos
            }
        }

        header('Location: /home');
        exit;
    }
}

function deleteItem() {
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $itemId = $_POST['id'];
        deleteItemById($itemId); // Eliminar el elemento de la base de datos
        header('Location: /home');
        exit;
    }
}

function changeStatus() {
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $itemId = $_POST['id'];
        $newStatus = $_POST['status'];
        updateItemStatus($itemId, $newStatus); // Actualizar el estado del elemento
        header('Location: /home');
        exit;
    }
}
?>