<?php
require_once __DIR__."/../../config.php";

try{





    
    $stmt= $pdo->prepare("UPDATE settings SET dark_mode = :bool SET notification = :notif ");
    $stmt->bindValue(":dark_mode", $bool);
    $stmt->bindValue(":notif", $bool2);
    $stmt->execute();


    $reponse = ["response"=>"OK"];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($reponse);
} catch (PDOException $e){
    http_response_code(500);
    echo "Erreur lors de l'update de BD: ".$e->getMessage();
}