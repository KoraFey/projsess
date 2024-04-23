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

//Obtenir le corps de la requête
$bodys = json_decode(file_get_contents("php://input"));
$p=true;

try{
    foreach($bodys->users as $body){
        
        $stmt = $pdo->prepare("SELECT id FROM `users` WHERE `username`=:name");
        $stmt->bindValue("name",$body);
        $stmt->execute();
        if($stmt->fetch()==null){
            $response = [];
            http_response_code(402);
            $response['error'] = "username incorect";
            echo json_encode($response);
            $p=false;
        }   
    }
if($p){
    $stmt = $pdo->prepare("INSERT INTO `Chat_Room` (`name`) VALUES (:name)");
    $stmt->bindValue(":name", $bodys->titre);
    $stmt->execute();
    $id= $pdo->lastInsertId();


    foreach($bodys->users as $body){
        
        $stmt = $pdo->prepare("SELECT id FROM `users` WHERE `username`=:name");
        $stmt->bindValue("name",$body);
        $stmt->execute();

        $user = $stmt->fetch();

        $stmt = $pdo->prepare('INSERT INTO Chat_Room_User (chat_room_id, user_id) VALUES (?, ?)');
        $stmt->execute([$id, $user['id']]);
      
    }
    $stmt->execute([$id, $bodys->owner]);

    echo json_encode("good");
}
   
}
catch(PDOException $e){
    http_response_code(500);
    echo "Erreur lors de l'insertion en BD: ".$e->getMessage();
}