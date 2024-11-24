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
?>
