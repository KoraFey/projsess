<?php
require_once __DIR__ . "/../config.php";

header('Content-Type: application/json; charset=utf-8');

$body = json_decode(file_get_contents("php://input"));

try {
    if (!isset($body->url_image) || empty($body->url_image)) {
        throw new Exception("L'URL de l'image est manquante");
    }
    if (!isset($body->description) || empty($body->description)) {
        throw new Exception("La description est manquante");
    }
    if (!isset($body->id_type) || empty($body->id_type)) {
        throw new Exception("Le type est manquant");
    }

    $stmt = $pdo->prepare("INSERT INTO `Publication` (`user_id`, `description`, `type`, `prix`, `date_publication`) VALUES (:user_id, :description, :id_type, :prix, NOW())");
    $stmt->bindValue(":user_id", $_SESSION['usager']);
    $stmt->bindValue(":description", $body->description);
    $stmt->bindValue(":id_type", $body->id_type);
    $stmt->bindValue(":prix", $body->prix); 
    $stmt->execute();

    $postId = $pdo->lastInsertId();

    if (isset($body->url_image) && is_array($body->url_image)) {
        foreach ($body->url_image as $image) {
            $stmt = $pdo->prepare("INSERT INTO `publication_images` (`id_publication`, `url`) VALUES (:id_publication, :url)");
            $stmt->bindValue(':id_publication', $postId);
            $stmt->bindValue(':url', $image);
            $stmt->execute();
        }
    }

    if (isset($body->tags) && is_array($body->tags)) {
        foreach ($body->tags as $tag) {
            $stmt = $pdo->prepare("INSERT INTO `publication_tags` (`id_publication`, `user_id`) VALUES (:id_post, :id_tag)");
            $stmt->bindValue(':id_post', $postId);
            $stmt->bindValue(':id_tag', $tag);
            $stmt->execute();
        }
    }

    // fetch tous les details en liens avec les posts
    $stmt = $pdo->prepare('SELECT p.*, GROUP_CONCAT(DISTINCT pt.user_id) AS tag_users, GROUP_CONCAT(pi.url) AS image_urls
    FROM Publication p
    LEFT JOIN publication_tags pt ON p.id = pt.id_publication
    LEFT JOIN publication_images pi ON p.id = pi.id_publication
    GROUP BY p.id;
    ');
    $stmt->execute();
    $publications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $insertion = ["id" => $postId, "url_image" => $body->url_image[0], "description" => $body->description, "id_type" => $body->id_type, "prix" => $body->prix, "listePosts" => $publications];

    echo json_encode($insertion);
} catch (Exception $e) {
    http_response_code(400); 
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}
?>
