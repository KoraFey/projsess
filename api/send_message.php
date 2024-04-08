<?php
require_once __DIR__."/../config.php";

// Get message data from request body
$data = json_decode(file_get_contents("php://input"));

try {
    // Insert message into logs table
    $query = "INSERT INTO logs (user_id, chatroom_id, message, time) VALUES (?, ?, ?, NOW())";
    $statement = $pdo->prepare($query);
    $statement->execute([$data->userId, $data->chatRoomId, $data->message]);

    // Return success response
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    // Return error response
    http_response_code(500);
    echo json_encode(['error' => 'Error sending message: ' . $e->getMessage()]);
}
?>
