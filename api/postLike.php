<?php
require_once __DIR__ . "/../config.php";

$body = json_decode(file_get_contents("php://input"));

$response = array();

try {
    if (!isset($body->publication_id) || empty($body->publication_id)) {
        throw new Exception("Publication ID est vide !");
    }

    if (!isset($body->delete_ou_insert) || empty($body->delete_ou_insert)) {
        throw new Exception("Insert ou delete ?");
    }

    $likeCount = 0;
    
    if ($body->delete_ou_insert == "insert"){
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM `publication_likes` WHERE `id_publication` = :id_publication AND `user_id` = :user_id");
        $stmt->bindValue(":id_publication", $body->publication_id);
        $stmt->bindValue(":user_id", $_SESSION['usager']);
        $stmt->execute();
        $likeCount = $stmt->fetchColumn();
    }
    
    if ($likeCount == 0) {
        if ($body->delete_ou_insert == "insert"){
                $stmt = $pdo->prepare("INSERT INTO `publication_likes` (`id_publication`, `user_id`) VALUES (:id_publication, :user_id)");
                $stmt->bindValue(":id_publication", $body->publication_id);
                $stmt->bindValue(":user_id", $_SESSION['usager']);
                $stmt->execute();
            
        } else {
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
    
    
    $response = ["likes" => $likes, "publication_id" => $body->publication_id];
} catch (Exception $e) {
    http_response_code(500);
    $response = ["error" => "Erreur lors de l'insertion en BD: " . $e->getMessage()];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
