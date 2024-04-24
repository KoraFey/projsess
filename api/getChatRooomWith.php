<?php
require_once __DIR__."/../config.php";

try{
    $gUserId = authentifier();
} catch (Exception $e) {
    $response = [];
    http_response_code(401);
    $response['error'] = "Non autorisé";
    echo json_encode($response);
}

if (isset($id) && filter_var($id, FILTER_VALIDATE_INT) && isset($name)) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :name");
    $stmt->bindValue(":name", $name);
    $stmt->execute();
    $id2 = $stmt->fetch();


    $stmt = $pdo->prepare("SELECT name, owner_id, url_icone, id, (SELECT COUNT(*) FROM Chat_Room_User u WHERE u.chat_room_id = Chat_Room.id) AS nb_personnes  FROM Chat_Room_User INNER JOIN Chat_Room ON id = chat_room_id WHERE user_id=:id AND chat_room_id IN (SELECT  chat_room_id FROM Chat_Room_User INNER JOIN Chat_Room ON id = chat_room_id WHERE user_id=:id2) ");
    $stmt->bindValue(":id", $id2["id"]);
    $stmt->bindValue(":id2", $id);
    
    $stmt->execute();

    $chatRooms = $stmt->fetchAll();

    $i=0;
    foreach($chatRooms as $chat){
        if($chat["nb_personnes"]==2){
            $stmt = $pdo->prepare("SELECT username FROM Chat_Room_User INNER JOIN users ON users.id = Chat_Room_User.user_id WHERE chat_room_id = :id AND user_id <> :id2");
            $stmt->bindValue(":id", $chat['id']);
            $stmt->bindValue(":id2", $gUserId);
            $stmt->execute();
            $name = $stmt->fetch();

            $chatRooms[$i]['name']=$name['username'];

         

        }
        $i++;
       
    
    }

    echo json_encode($chatRooms);
} else {
    $response = ["error" => "Identifiant invalide"];
}