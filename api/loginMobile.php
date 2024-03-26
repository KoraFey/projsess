<?php
$gPublic=true;
require_once __DIR__."/../config.php";
// if(!isset($_SERVER["CONTENT_TYPE"]) || $_SERVER["CONTENT_TYPE"]!='application/json'){
//     http_response_code(400);
//     exit;
// }

//Obtenir le corps de la requête
$body = json_decode(file_get_contents("php://input"));
$password=$body->password;

try{
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$body->username]);
    $user = $stmt->fetch();
  
    if ($user && password_verify($password, $user['password'])) {
        $id = ["id"=>$user["id"]];
        echo json_encode($id);   
        exit;
    } else {
        $response = [];
        http_response_code(401);
        $response["error"] = "Nom d'utilisateur ou mot de passe incorrect.";
        echo json_encode($response);
    }
} catch (PDOException $e){
    http_response_code(500);
    echo "Erreur lors de l'insertion en BD: ".$e->getMessage();
}
