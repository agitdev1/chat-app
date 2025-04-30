@ -0,0 +1,170 @@

# Chat App

A real-time chat application built with PHP, MySQL, WebSockets, and Bootstrap. The app allows users to register, log in, and communicate in a chat room in real time.

## Features

- **Real-time messaging** using WebSockets.
- **User authentication** (register, login).
- **Bootstrap styling** for a responsive and modern UI.
- **MySQL database** to store users and messages.
- **AJAX-based message fetching** to prevent page refreshes.

## Prerequisites

Before you begin, ensure you have the following installed:

- [XAMPP](https://www.apachefriends.org/) or any local PHP server that supports MySQL.
- [Composer](https://getcomposer.org/) to manage PHP dependencies (Ratchet for WebSockets).

## Installation

Follow the steps below to set up the application on your local machine.

### 1. Clone the repository

```bash
git clone https://github.com/your-username/chat-app.git
cd chat-app
```

### 2. Install Composer dependencies

Run the following command to install required PHP libraries (e.g., Ratchet for WebSockets):

```bash
composer install
```

### 3. Configure the database

- Create a MySQL database for the chat app:

```sql
CREATE DATABASE chat_db;
```

- Run the following SQL to set up the necessary tables:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT NOT NULL,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### 4. Set up the database connection

Edit the `config.php` file to match your MySQL server configuration (username, password, database name).

```php
<?php
$servername = "localhost";  // Your database server (usually localhost)
$username = "root";         // Your MySQL username
$password = "";             // Your MySQL password
$dbname = "chat_db";        // The database name you created
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```

### 5. Run the WebSocket server

Start the WebSocket server by running the following command:

```bash
php server.php
```

This will start the WebSocket server on `ws://localhost:8080`. You will need this server running to handle real-time communication.

### 6. Access the app

Now you can access the chat app by visiting:

```
http://localhost/chat-app
```

You can register, log in, and start chatting.

## Usage

### 1. Register a new user

On the homepage, you can register by entering a username. This will create a new user in the database.

### 2. Log in

After registering, log in with your username. Upon logging in, you’ll be redirected to the chat page.

### 3. Send and receive messages

Type your messages in the input field, and they will be sent in real-time to the other connected users.

### 4. View messages

Messages are fetched from the MySQL database and displayed in real-time on the chat page.

## File Structure

```
chat-app/
├── config.php              # Database connection
├── index.php               # Landing page (registration/login)
├── chat.php                # Main chat interface
├── server.php              # WebSocket server
├── vendor/                 # Composer dependencies
├── public/                 # Static assets (CSS, JS, etc.)
│   ├── styles.css          # Custom CSS styles
│   └── script.js           # JavaScript (AJAX, WebSocket)
└── README.md               # This file
```

## Troubleshooting

### 1. **WebSocket not connecting**
- Make sure the WebSocket server is running (`php server.php`).
- Ensure that the WebSocket connection URL is correct in the `chat.php` file (`ws://localhost:8080` by default).

### 2. **Messages not showing**
- Verify that the WebSocket server is running and connected to the client.
- Check if the messages are being inserted into the database by running:

```sql
SELECT * FROM messages;
```

If the messages are not appearing, check the insert logic in your PHP files.

### 3. **AJAX not fetching messages**
- Ensure the PHP file responsible for fetching messages (`messages.php`) is correctly returning JSON data.
- Open the browser's developer tools (F12) and check the network tab for any errors in the AJAX requests.

## Future Enhancements

- Add **user authentication** with sessions.
- Support for **private messaging** and **chat rooms**.
- **Message persistence**: Save chat history in the database and allow users to see past messages.
- Improve UI with **emojis**, **file uploads**, and **typing indicators**.

---

**Created by:** Agitdev1 
**Version:** 1.0.0
