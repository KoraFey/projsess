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

if (isset($id) && filter_var($id, FILTER_VALIDATE_INT)) {
    $stmt = $pdo->prepare("SELECT name, owner_id, url_icone, id, (SELECT COUNT(*) FROM Chat_Room_User u WHERE u.chat_room_id = Chat_Room.id) AS nb_personnes  FROM Chat_Room_User INNER JOIN Chat_Room ON id = chat_room_id WHERE user_id=:id");

    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $chatRooms = $stmt->fetchAll();
<<<<<<< Updated upstream
    
=======


>>>>>>> Stashed changes
    echo json_encode($chatRooms);
} else {
    $settings = ["error" => "Identifiant invalide"];
}