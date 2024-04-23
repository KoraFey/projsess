<?php
require_once __DIR__ . "/../config.php";

$body = json_decode(file_get_contents("php://input"));

$response = array();

try {
    if (!isset($body->publication_id) || empty($body->publication_id)) {
        throw new Exception("Publication ID est vide !");
    }

    if (!isset($body->delete_ou_insert_comment) || empty($body->delete_ou_insert_comment)) {
        throw new Exception("Insert, delete, comment ?");
    }

    if ($body->delete_ou_insert_comment == "comment"){
        $stmt = $pdo->prepare("INSERT INTO `publication_commentaire` (`id_publication`, `user_id`, `commentaire`) VALUES (:id_publication, :user_id, :comment)");
        $stmt->bindValue(":id_publication", $body->publication_id);
        $stmt->bindValue(":user_id", $_SESSION['usager']);
        $stmt->bindValue(":comment", $body->comment);
        $stmt->execute();

        $stmt = $pdo->prepare("SELECT * FROM `publication_commentaire`");
        $stmt->execute();
        $comments = $stmt->fetchAll();

        $response = ["comments" => $comments, "publication_id" => $body->publication_id];

    } else {
    $likeCount = 0;
    
    if ($body->delete_ou_insert_comment == "insert"){
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM `publication_likes` WHERE `id_publication` = :id_publication AND `user_id` = :user_id");
        $stmt->bindValue(":id_publication", $body->publication_id);
        $stmt->bindValue(":user_id", $_SESSION['usager']);
        $stmt->execute();
        $likeCount = $stmt->fetchColumn();
    }
    
    if ($likeCount == 0) {
        if ($body->delete_ou_insert_comment == "insert"){
                $stmt = $pdo->prepare("INSERT INTO `publication_likes` (`id_publication`, `user_id`) VALUES (:id_publication, :user_id)");
                $stmt->bindValue(":id_publication", $body->publication_id);
                $stmt->bindValue(":user_id", $_SESSION['usager']);
                $stmt->execute();
            
        } else if ($body->delete_ou_insert_comment == "delete"){
                $stmt = $pdo->prepare("DELETE FROM `publication_likes` WHERE `id_publication` = :id_publication AND `user_id` = :user_id");
                $stmt->bindValue(":id_publication", $body->publication_id);
                $stmt->bindValue(":user_id", $_SESSION['usager']);
                $stmt->execute();
        }
    } else {
        echo "vous avez deja liker ce post";
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM `publication_likes` WHERE `id_publication` = :id_publication");
    $stmt->bindValue(":id_publication", $body->publication_id);
    $stmt->execute();
    $likes = $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT * FROM `publication_likes`");
    $stmt->execute();
    $likesAll = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $response = [
        "likes" => $likes,
        "publication_id" => $body->publication_id,
        "allLikesList" => $likesAll
    ];
    
    }

} catch (Exception $e) {
    http_response_code(500);
    $response = ["error" => "Erreur lors de l'insertion en BD: " . $e->getMessage()];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
