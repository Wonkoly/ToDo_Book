<?php
function getItemsByUser($userId) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, title, type, status FROM items WHERE user_id = ?");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function createItem($userId, $title, $type, $status) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO items (user_id, title, type, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('isss', $userId, $title, $type, $status);
    return $stmt->execute();
}

function deleteItemById($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM items WHERE id = ?");
    $stmt->bind_param('i', $id);
    return $stmt->execute();
}

function updateItemStatus($id, $status) {
    global $conn;
    $stmt = $conn->prepare("UPDATE items SET status = ? WHERE id = ?");
    $stmt->bind_param('si', $status, $id);
    return $stmt->execute();
}

function syncItemsToTodoist($userId) {
    global $conn;

    // Obtener la API Key del usuario
    $stmt = $conn->prepare("SELECT todoist_api_key FROM users WHERE id = ?");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $apiKey = $user['todoist_api_key'];

    if (!$apiKey) {
        return "API Key de Todoist no configurada.";
    }

    // Obtener items pendientes
    $stmt = $conn->prepare("SELECT title, type FROM items WHERE user_id = ? AND status = 'pendiente'");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    if (empty($items)) {
        return "No hay items pendientes para sincronizar.";
    }

    // Obtener o crear el proyecto en Todoist
    $projectId = getOrCreateTodoistProject($apiKey);

    // Sincronizar cada item como tarea
    foreach ($items as $item) {
        callTodoistApi('POST', 'tasks', $apiKey, [
            'content' => $item['title'],
            'description' => "Tipo: " . $item['type'],
            'project_id' => $projectId
        ]);
    }

    return "Sincronización completada.";
}

?>
