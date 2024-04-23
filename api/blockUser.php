<?php
require_once __DIR__ . "/../config.php";

header('Content-Type: application/json; charset=utf-8');

$body = json_decode(file_get_contents("php://input"));

try {
    if (!isset($body->blocked_id) || empty($body->blocked_id)) {
        throw new Exception("User id est manquante");
    }

    if (!isset($body->block_unblock) || empty($body->block_unblock)) {
        throw new Exception("Block commande est manquante");
    }
   
    if($body->block_unblock == "block") {
        $stmt = $pdo->prepare("INSERT INTO `Block_List` (user_id, blocked_id) VALUES (:user_id, :blocked_id)");
        $stmt->bindValue(":user_id", $_SESSION['usager']);
        $stmt->bindValue(":blocked_id", $body->blocked_id);
        $stmt->execute();
    } else if($body->block_unblock == "unblock") {
        $stmt = $pdo->prepare("DELETE FROM `Block_List` WHERE user_id=:user_id AND blocked_id=:blocked_id");
        $stmt->bindValue(":user_id", $_SESSION['usager']);
        $stmt->bindValue(":blocked_id", $body->blocked_id);
        $stmt->execute();
    }
    
    
    $stmt = $pdo->prepare('SELECT p.*, GROUP_CONCAT(DISTINCT pt.user_id) AS tag_users, GROUP_CONCAT(pi.url) AS image_urls
    FROM Publication p
    LEFT JOIN publication_tags pt ON p.id = pt.id_publication
    LEFT JOIN publication_images pi ON p.id = pi.id_publication
    WHERE NOT EXISTS (
    SELECT 1 FROM Block_List bl 
    WHERE bl.user_id = :currentUserId 
    AND bl.blocked_id = p.user_id
    )
    GROUP BY p.id');
    $stmt->bindValue(':currentUserId', $gUserId);
    $stmt->execute();
    $publications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    $stmt = $pdo->prepare('SELECT pc.*
    FROM publication_commentaire pc
    LEFT JOIN Block_List bl ON pc.user_id = bl.blocked_id
    WHERE NOT EXISTS (
        SELECT 1 FROM Block_List bl2
        WHERE bl2.user_id = :currentUserId 
        AND bl2.blocked_id = pc.user_id
    )
    GROUP BY pc.id');
    $stmt->bindValue(':currentUserId', $gUserId);
    $stmt->execute();
    $commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT blocked_id FROM Block_List WHERE user_id = :user_id");
    $stmt->bindValue(":user_id", $_SESSION['usager']);
    $stmt->execute();
    $blockedUsers = $stmt->fetchAll(PDO::FETCH_COLUMN);


    $insertion = ["user_id" => $_SESSION['usager'], "blocked_id" => $body->blocked_id, "listePosts" => $publications, "allCommentsList" => $commentaires, "blockList" => $blockedUsers];

    echo json_encode($insertion);
} catch (Exception $e) {
    http_response_code(400); 
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}
?>
