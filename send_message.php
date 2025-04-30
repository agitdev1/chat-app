<?php
require 'config.php';
if (isset($_SESSION['user_id'], $_POST['message'])) {
    $msg = htmlspecialchars($_POST['message']);
    $stmt = $conn->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
    $stmt->bind_param("is", $_SESSION['user_id'], $msg);
    if ($stmt->execute()) {
        echo "Message saved!";
    } else {
        echo "Error saving message.";
    }
}
