<?php
require_once __DIR__."/../config.php";

try{
    $gUserId = authentifier();
} catch(Exception $e){
    $response = [];
    http_response_code(401);
    $response['error'] = "Non autorisé";
    echo json_encode($response);
}

if(isset($id) && filter_var($id, FILTER_VALIDATE_INT)){
    $stmt = $pdo->prepare("SELECT message,username,time  FROM `logs` INNER JOIN users ON user_id = id WHERE `chatroom_id`=:id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $chatRooms = $stmt->fetchAll();
    echo json_encode($chatRooms);
} else {
    $settings = ["error"=>"Identifiant invalide"];
}