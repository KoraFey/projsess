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
$passwordHash = password_hash($body->password, PASSWORD_DEFAULT);
// Vérifier si l'utilisateur existe déjà
$stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? AND id <> ?');
$stmt->execute([$body->username,$id]);
if ($stmt->fetch()) {
    http_response_code(400);
    exit;
} else {
    $stmt = $pdo->prepare('UPDATE users SET username = ? , password = ? WHERE id =?');
    $stmt->execute([$body->username,$passwordHash,$id]);
    $response="done";
}

