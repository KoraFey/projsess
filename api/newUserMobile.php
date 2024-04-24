<?php
require_once __DIR__."/../config.php";

// if(!isset($_SERVER["CONTENT_TYPE"]) || $_SERVER["CONTENT_TYPE"]!='application/json'){
//     http_response_code(400);
//     exit;
// }

// try{
//     $gUserId = authentifier();
// } catch(Exception $e){
//     $response = [];
//     http_response_code(401);
//     $response['error'] = "Non autorisé";
//     echo json_encode($response);
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
        $passwordHash = password_hash($body->password, PASSWORD_DEFAULT);

        try{
            $stmt = $pdo->prepare("INSERT INTO `users` (`username`, `password`) VALUES (:user, :password)");
            $stmt->bindValue(":user", $body->username);
            $stmt->bindValue(":password", $passwordHash);
            if($stmt->execute()){
                $tempId =  $pdo->lastInsertId(); 
                $stmt = $pdo->prepare('INSERT INTO settings (user_id) VALUES (?)');
                $stmt->execute([$tempId]);
            }

            /* */
            $stmt = $pdo->prepare('SELECT id FROM users WHERE id != ?');
            $stmt->execute([$tempId]);
            $userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

            foreach ($userIds as $userId) {
                $stmt = $pdo->prepare('SELECT chat_room_id FROM Chat_Room_User WHERE user_id = ? AND chat_room_id IN (SELECT chat_room_id FROM Chat_Room_User WHERE user_id = ?)');
                $stmt->execute([$tempId, $userId]);
                $existChatRoomId = $stmt->fetchColumn();

                if (!$existChatRoomId) {
                    $stmt = $pdo->prepare('INSERT INTO Chat_Room (owner_id, name) VALUES (?, ?)');
                    $stmt->execute([null, 'Chat Room']);
                    $chatRoomId = $pdo->lastInsertId();

                    $stmt = $pdo->prepare('INSERT INTO Chat_Room_User (chat_room_id, user_id) VALUES (?, ?)');
                    $stmt->execute([$chatRoomId, $tempId]);

                    $stmt = $pdo->prepare('INSERT INTO Chat_Room_User (chat_room_id, user_id) VALUES (?, ?)');
                    $stmt->execute([$chatRoomId, $userId]);
                }
            }
            /* */

            $insertion = ["id"=>$tempId, "username"=>$body->username, "password"=>$body->password];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($insertion);

        } catch (PDOException $e){
            http_response_code(500);
            echo "Erreur lors de l'insertion en BD: ".$e->getMessage();
        }
    }   
