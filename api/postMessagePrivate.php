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




//obtenir le body de la requete 
$body = json_decode(file_get_contents("php://input"));


$message = $body->message;
$user_id = $body->user_id;
try{
    
    $stmt = $pdo->prepare("SELECT  id, (SELECT COUNT(*) FROM Chat_Room_User u WHERE u.chat_room_id = Chat_Room.id) AS nb_personnes  FROM Chat_Room_User INNER JOIN Chat_Room ON id = chat_room_id WHERE user_id=:id AND chat_room_id IN (SELECT  chat_room_id FROM Chat_Room_User INNER JOIN Chat_Room ON id = chat_room_id WHERE user_id=:id2) ");
    $stmt->bindValue(":id", $user_id);
    $stmt->bindValue(":id2", $gUserId);
    
    $stmt->execute();
    $idchat = $stmt->fetch();

    $stmt = $pdo->prepare("INSERT INTO logs (user_id, chatroom_id,message,time) VALUES(:user,:chat,:message, :time)");
    $stmt->bindValue(":user", $gUserId);
    $stmt->bindValue(":chat", $idchat['id']);
    $stmt->bindValue(":message", $message);
    $stmt->bindValue(":time", '2024-04-08 15:02:18');


    $stmt->execute();
}
catch(PDOException $e){
    http_response_code(500);
    echo "Erreur lors de l'insertion en BD: ".$e->getMessage();
}
