<?php

function getItemsByUser($userId) {
    global $conn;

    $stmt = $conn->prepare("SELECT title, type, status FROM items WHERE user_id = ?");
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

function updateItemStatus($itemId, $newStatus) {
    global $conn;

    $stmt = $conn->prepare("UPDATE items SET status = ? WHERE id = ?");
    if (!$stmt) {
        error_log("Error al preparar la consulta: " . $conn->error);
        return false;
    }

    $stmt->bind_param('si', $newStatus, $itemId);
    if (!$stmt->execute()) {
        error_log("Error al ejecutar la consulta: " . $stmt->error);
        return false;
    }

    return true;
}

function removeItem($itemId) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM items WHERE id = ?");
    if (!$stmt) {
        error_log("Error al preparar la consulta: " . $conn->error);
        return false;
    }

    $stmt->bind_param('i', $itemId);
    if (!$stmt->execute()) {
        error_log("Error al ejecutar la consulta: " . $stmt->error);
        return false;
    }

    return true;
}
?>
