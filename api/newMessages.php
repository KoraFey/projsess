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


try{
    $stmt = $pdo->prepare("INSERT INTO logs (user_id, chatroom_id,message,time) VALUES(:user,:chat,:message, :time)");
    $stmt->bindParam(":user", $body->user_id);
    $stmt->bindParam(":chat", $body->chatroom_id);
    $stmt->bindParam(":message", $body->message);
    $stmt->bindParam(":time", '2024-04-08 15:02:18');


    $stmt->execute();
}
catch(PDOException $e){
    http_response_code(500);
    echo "Erreur lors de l'insertion en BD: ".$e->getMessage();
}
