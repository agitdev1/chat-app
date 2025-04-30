<?php
require 'config.php';

$res = $conn->query("SELECT m.message, u.username FROM messages m JOIN users u ON m.user_id = u.id ORDER BY m.created_at ASC");

if (!$res) {
    die("Error executing query: " . $conn->error);
}

$messages = [];
while ($row = $res->fetch_assoc()) {
    $messages[] = ['user' => $row['username'], 'message' => $row['message']];
}

echo json_encode($messages);
?>
