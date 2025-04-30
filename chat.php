<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) header("Location: login.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="d-flex justify-content-between mb-3">
        <h4>Welcome, <?= $_SESSION['username'] ?></h4>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <div class="card">
        <div class="card-header">Chat Room</div>
        <div class="card-body" id="chat-box" style="height: 300px; overflow-y: scroll;"></div>
        <div class="card-footer">
            <form id="chat-form" class="d-flex">
                <input type="text" id="message" class="form-control me-2" placeholder="Type message..." required>
                <button class="btn btn-primary" type="submit">Send</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Load previous messages
    fetch("get_message.php")
    .then(res => res.json())
    .then(data => {
        const chatBox = document.getElementById("chat-box");
        data.forEach(msg => {
            const div = document.createElement("div");
            div.innerHTML = `<strong>${msg.user}:</strong> ${msg.message}`;
            chatBox.appendChild(div);
        });
    });

    // WebSocket setup
    const user = "<?= $_SESSION['username'] ?>";
    const conn = new WebSocket('ws://localhost:8080');

    conn.onmessage = function(e) {
        const data = JSON.parse(e.data);
        const chatBox = document.getElementById("chat-box");
        const messageElement = document.createElement("div");
        messageElement.innerHTML = `<strong>${data.user}:</strong> ${data.message}`;
        chatBox.appendChild(messageElement);
        chatBox.scrollTop = chatBox.scrollHeight;
    };

    document.getElementById("chat-form").onsubmit = function(e) {
        e.preventDefault();
        const msg = document.getElementById("message").value;
        conn.send(JSON.stringify({ user: user, message: msg }));

        // Store message in DB
        fetch("send_message.php", {
            method: "POST",
            body: new URLSearchParams({ message: msg })
        });

        document.getElementById("message").value = "";
    };
});

</script>
</body>
</html>
