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


$body = json_decode(file_get_contents("php://input"));

try{
    $stmt= $pdo->prepare("UPDATE settings SET dark_mode = :dark, notification = :notif WHERE user_id = :id");
    $stmt->bindValue(":dark", $body->dark_mode);
    $stmt->bindValue(":notif", $body->notification);
    $stmt->bindValue(":id",$id);
    $stmt->execute();


    $reponse = ["response"=>"OK"];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($reponse);
} catch (PDOException $e){
    http_response_code(500);
    echo "Erreur lors de l'update de BD: ".$e->getMessage();
}