<?php
function getUserByEmail($email) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function createUser($name, $email, $hashedPassword) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error); // Mensaje de error detallado
    }

    $stmt->bind_param('sss', $name, $email, $hashedPassword);
    if (!$stmt->execute()) {
        die("Error al ejecutar la consulta: " . $stmt->error); // Mensaje de error detallado
    }

    return true;
}

function getUserApiKey($userId) {
    global $conn;

    $stmt = $conn->prepare("SELECT todoist_api_key FROM users WHERE id = ?");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['todoist_api_key'] ?? null;
}

function updateUserApiKey($userId, $apiKey) {
    global $conn;

    $stmt = $conn->prepare("UPDATE users SET todoist_api_key = ? WHERE id = ?");
    $stmt->bind_param('si', $apiKey, $userId);
    return $stmt->execute();
}

function updateUserProfilePhoto($userId, $photoPath) {
    global $conn;

    $stmt = $conn->prepare("UPDATE users SET profile_photo = ? WHERE id = ?");
    $stmt->bind_param('si', $photoPath, $userId);
    return $stmt->execute();
}

function getUserProfilePhoto($userId) {
    global $conn;

    $stmt = $conn->prepare("SELECT profile_photo FROM users WHERE id = ?");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    // Retornar la foto de perfil o una imagen por defecto
    return $result['profile_photo'] ?? '/uploads/default_profile.png';
}
?>
