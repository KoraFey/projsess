<?php
require_once __DIR__ . "/../config.php";

$body = json_decode(file_get_contents("php://input"));

$response = array();

try {
    if (!isset($body->id_post) || empty($body->id_post)) {
        throw new Exception("Publication ID est vide !");
    }

    // Supprimer les likes du post
    $stmtLikes = $pdo->prepare("DELETE FROM publication_likes WHERE id_publication = :id_post");
    $stmtLikes->bindValue(":id_post", $body->id_post);
    $stmtLikes->execute();

    // Supprimer les commentaires du post
    $stmtComments = $pdo->prepare("DELETE FROM publication_commentaire WHERE id_publication = :id_post");
    $stmtComments->bindValue(":id_post", $body->id_post);
    $stmtComments->execute();

    // Supprimer les tags du post
    $stmtTags = $pdo->prepare("DELETE FROM publication_tags WHERE id_publication = :id_post");
    $stmtTags->bindValue(":id_post", $body->id_post);
    $stmtTags->execute();

    // Supprimer les images du post
    $stmtImages = $pdo->prepare("DELETE FROM publication_images WHERE id_publication = :id_post");
    $stmtImages->bindValue(":id_post", $body->id_post);
    $stmtImages->execute();

    // Supprimer le post
    $stmtPublication = $pdo->prepare("DELETE FROM Publication WHERE id = :id_post");
    $stmtPublication->bindValue(":id_post", $body->id_post);
    $stmtPublication->execute();

    $stmt = $pdo->prepare('
    SELECT p.*, 
           GROUP_CONCAT(DISTINCT pt.user_id) AS tag_users, 
           GROUP_CONCAT(pi.url) AS image_urls FROM Publication p LEFT JOIN publication_tags pt ON p.id = pt.id_publication 
           LEFT JOIN publication_images pi ON p.id = pi.id_publication 
           WHERE NOT EXISTS ( SELECT 1 
        FROM Block_List bl 
        WHERE bl.user_id = :currentUserId 
        AND bl.blocked_id = p.user_id) OR NOT EXISTS (SELECT 1 FROM Block_List) GROUP BY p.id');

    $stmt->bindValue(':currentUserId', $gUserId);
    $stmt->execute();
    $publications = $stmt->fetchAll(PDO::FETCH_ASSOC);



    $response = ["id_post" => $body->id_post, "listePosts" => $publications];

} catch (Exception $e) {
    http_response_code(500);
    $response = ["error" => "Erreur lors de l'insertion en BD: " . $e->getMessage()];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
