<?php
require __DIR__ . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    // Called when a new client connects to the WebSocket
    public function onOpen(ConnectionInterface $conn) {
        echo "New connection! ({$conn->resourceId})\n";
        // Optionally store the connection for broadcasting later
    }

    // Called when a client sends a message
    public function onMessage(ConnectionInterface $from, $msg) {
        echo "Message from {$from->resourceId}: $msg\n";

        // Broadcast the message to all clients (except the sender)
        foreach ($from->httpRequest->getUri() as $client) {
            $client->send($msg);
        }
    }

    // Called when a client disconnects
    public function onClose(ConnectionInterface $conn) {
        echo "Connection {$conn->resourceId} has disconnected\n";
        // Optionally remove the connection from storage
    }

    // Called if there's an error
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
}

use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\HTTP\HttpServer;

// Instantiate and run the server
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8080 // Port number, you can change this if needed
);

echo "WebSocket server started on ws://localhost:8080\n";
$server->run();
