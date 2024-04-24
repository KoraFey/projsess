<?php
require_once __DIR__."/../config.php";
try{
    $gUserId = authentifier();
} catch (Exception $e) {
    $response = [];
    http_response_code(401);
    $response['error'] = "Non autorisé";
    echo json_encode($response);
}

if(isset($loggedUserId) && filter_var($loggedUserId, FILTER_VALIDATE_INT)
    && isset($chatRoomId) && filter_var($chatRoomId, FILTER_VALIDATE_INT)){
  
   

  
    $stmt = $pdo->prepare("SELECT user_id FROM `Chat_Room_User` WHERE chat_room_id = :chatRoomId AND user_id != :loggedUserId");
    $stmt->bindParam(":loggedUserId", $loggedUserId);
    $stmt->bindParam(":chatRoomId", $chatRoomId);
    $stmt->execute();

   
    $otherUserId = $stmt->fetchColumn();

    echo json_encode(['other_user_id' => $otherUserId]);
} 

