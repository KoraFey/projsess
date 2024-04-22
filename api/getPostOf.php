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

if (isset($gUserId) && filter_var($gUserId, FILTER_VALIDATE_INT) && isset($name)) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :name");
    $stmt->bindValue(":name", $name);
    $stmt->execute();
    $id2 = $stmt->fetch();
    


    $stmt = $pdo->prepare("SELECT Publication.id as id, user_id, username,url_pfp, description, type, date_publication, prix  FROM `Publication` INNER JOIN users ON user_id= users.id WHERE `type`= 'actualite' AND user_id =:id2");

    $stmt->bindValue(":id2", $id2["id"]);
    
    $stmt->execute();

    $posts = $stmt->fetchAll();

} else {
    $response = ["error" => "Identifiant invalide"];
}

$i = 0;
foreach($posts as $post){
        
    $stmt = $pdo->prepare("SELECT url FROM `publication_images` WHERE `id_publication`=:id");
    $stmt->bindValue("id",$post['id']);
    $stmt->execute();
    if($places = $stmt->fetchAll()){
        $f=0;
        foreach($places as $place){
            $posts[$i]['url'][$f] =$place['url'];
            $f++;
        }
    }
    else
        $posts[$i]['url'] = null;


    $stmt = $pdo->prepare("SELECT id_publication FROM `publication_likes` WHERE `id_publication`=:id AND user_id =:ID");
    $stmt->bindValue("id",$post['id']);
    $stmt->bindValue("ID",$gUserId);
    $stmt->execute();
    
    if($place = $stmt->fetch())
        $posts[$i]['isLiked'] = 1;
    else
        $posts[$i]['isLiked'] = 0;
  $i++;


}


if($posts){
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($posts);
    exit;
} else {
    header("HTTP/1.0 404 Not Found");
    exit;
}
