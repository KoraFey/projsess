<?php
require_once __DIR__ . "/../config.php";
try {
    $gUserId = authentifier();
} catch (Exception $e) {
    $response = [];
    http_response_code(401);
    $response['error'] = "Non autorisé";
    echo json_encode($response);
}

if (isset($id) && filter_var($id, FILTER_VALIDATE_INT)) {
    $stmt = $pdo->prepare("SELECT name, owner_id, url_icone,id  FROM Chat_Room_User INNER JOIN Chat_Room ON id= chat_room_id WHERE user_id=:id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $chatRooms = $stmt->fetchAll();
    echo json_encode($chatRooms);
} else {
    $settings = ["error" => "Identifiant invalide"];
}