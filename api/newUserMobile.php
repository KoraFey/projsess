<?php
$gPublic=true;
require_once __DIR__."/../config.php";

// if(!isset($_SERVER["CONTENT_TYPE"]) || $_SERVER["CONTENT_TYPE"]!='application/json'){
//     http_response_code(400);
//     exit;
// }

//Obtenir le corps de la requête
$body = json_decode(file_get_contents("php://input"));

    // Vérifier si l'utilisateur existe déjà
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$body->username]);
    if ($stmt->fetch()) {
        http_response_code(400);
        exit;
    } else {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        try{
            $stmt = $pdo->prepare("INSERT INTO `users` (`username`, `password`) VALUES (:user, :password)");
            $stmt->bindValue(":user", $body->username);
            $stmt->bindValue(":password", $passwordHash);
            if($stmt->execute()){
                $tempId =  $pdo->lastInsertId(); 
                $stmt = $pdo->prepare('INSERT INTO settings (user_id) VALUES (?)');
                $stmt->execute([$tempId]);
            }

            $insertion = ["id"=>$pdo->lastInsertId(), "username"=>$body->username, "password"=>$body->password];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($insertion);

        } catch (PDOException $e){
            http_response_code(500);
            echo "Erreur lors de l'insertion en BD: ".$e->getMessage();
        }
    }   
