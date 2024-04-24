<?php
require_once __DIR__."/../config.php";


$data = json_decode(file_get_contents("php://input"));

try {
  
    $query = "INSERT INTO logs (user_id, chatroom_id, message, time) VALUES (?, ?, ?, NOW())";
    $statement = $pdo->prepare($query);
    $statement->execute([$data->userId, $data->chatRoomId, $data->message]);

  
    echo json_encode(['success' => true]);
} catch (PDOException $e) {

    http_response_code(500);
    echo json_encode(['error' => 'Error sending message: ' . $e->getMessage()]);
}
?>
