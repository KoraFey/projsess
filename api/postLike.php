<?php
require_once __DIR__ . "/../config.php";

$body = json_decode(file_get_contents("php://input"));

$response = array();

try {
    if (!isset($body->publication_id) || empty($body->publication_id)) {
        throw new Exception("Publication ID est vide !");
    }

    $stmt = $pdo->prepare("UPDATE Publication SET likes = COALESCE(likes, 0) + 1 WHERE id = :publication_id");
    $stmt->bindValue(":publication_id", $body->publication_id);
    $stmt->execute();

    $stmt = $pdo->prepare("SELECT likes FROM `Publication` WHERE id = :publication_id");
    $stmt->bindValue(":publication_id", $body->publication_id);
    $stmt->execute();
    $likes = $stmt->fetch();

    $response = ["likes" => $likes, "publication_id" => $body->publication_id];
} catch (Exception $e) {
    http_response_code(500);
    $response = ["error" => "Erreur lors de l'insertion en BD: " . $e->getMessage()];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
