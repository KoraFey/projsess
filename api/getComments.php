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
    $stmt = $pdo->prepare("SELECT user_id,commentaire , username FROM `publication_commentaire` INNER JOIN users ON user_id =users.id  WHERE `id_publication`=:id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    if($comments = $stmt->fetchAll()){
        echo json_encode($comments);
    }
    else{
        http_response_code(402);
    }
    
} else {
    $comments = ["error"=>"Identifiant invalide"];
}