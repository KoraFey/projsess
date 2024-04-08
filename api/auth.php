<?php
require_once __DIR__."/../config.php";

use Firebase\JWT\JWT;

$body = json_decode(file_get_contents("php://input"));
$password=$body->password;
$response = [];

if(!isset($body->username) || $body->username == "" || !isset($body->password) || $body->password == "" ){
http_response_code(401);
$response["error"] = "Informations d'authentification incorrectes";
echo json_encode($response);
exit;
}

$user = false;
try{
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$body->username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        if($user){
            $payload = [
            "iss" => "http://equipeXXX.tch099.ovh", // Émetteur du token
            "aud" => "http://equipeXXX.tch099.ovh", // Audience du token
            "iat" => time(), // Temps où le JWT a été émis
            "exp" => time() + 3600, // Expiration du token 
            "user_id" => $user['id'],
            "user_name" => $body->username,
            ];
            $jwt = JWT::encode($payload, $API_SECRET, 'HS256'); // Génère le token
            $response['message'] = "Authentification réussie";
            $response['token'] = $jwt;
            $response["id"]= $user["id"];
            $response["username"] = $user["username"];
            http_response_code(200);
            echo json_encode($response);
        }
        else {
            http_response_code(401);
            $response['error'] = "Non autorisé";
            echo json_encode($response);
        }
    } 
    else {
        $password=false;
        $response = [];
        http_response_code(401);
        $response["error"] = "Nom d'utilisateur ou mot de passe incorrect.";
        echo json_encode($response);
    }


    
} catch (PDOException $e){
    http_response_code(500);
    $response['error'] = "BD non disponible: ".$e->getMessage();
    echo json_encode($response);
exit;
}