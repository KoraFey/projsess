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
// Assuming $loggedUserId and $chatRoomId are defined elsewhere in your code
if(isset($loggedUserId) && filter_var($loggedUserId, FILTER_VALIDATE_INT)
    && isset($chatRoomId) && filter_var($chatRoomId, FILTER_VALIDATE_INT)){
    // Establish a database connection (replace with your own method)
   

    // Prepare and execute the SQL query
    $stmt = $pdo->prepare("SELECT user_id FROM `Chat_Room_User` WHERE chat_room_id = :chatRoomId AND user_id != :loggedUserId");
    $stmt->bindParam(":loggedUserId", $loggedUserId);
    $stmt->bindParam(":chatRoomId", $chatRoomId);
    $stmt->execute();

    // Fetch the results
    $otherUserId = $stmt->fetchColumn();

    // Output the result as JSON
    echo json_encode(['other_user_id' => $otherUserId]);
} 

