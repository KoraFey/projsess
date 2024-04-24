<?php
require_once __DIR__ . "/../config.php";

header('Content-Type: application/json; charset=utf-8');

$body = json_decode(file_get_contents("php://input"));


function getUserCredits($pdo) {
    $stmt = $pdo->prepare("SELECT credits FROM PMT WHERE user_id = :id");
    $stmt->bindParam(":id", $_SESSION['usager']);
    $stmt->execute();
    return $stmt->fetchColumn() ?? 0;
}

try {

    if (!isset($body->total) || empty($body->total)) {
        throw new Exception("le total est manquant");
    }

    $credits = getUserCredits($pdo);

    if ($body->total <= $credits) {
        $newCredits = $credits - $body->total;

        $stmt = $pdo->prepare("UPDATE PMT SET `credits` = :credits WHERE `user_id` = :id");
        $stmt->bindParam(":credits", $newCredits);
        $stmt->bindParam(":id", $_SESSION['usager']);
        $stmt->execute();
        $response = ["success" => true, "newCredits" =>  $newCredits];

    } else {
        $response = ["success" => false];

    }
    
    
        echo json_encode($response);
    } catch (Exception $e) {
        http_response_code(400); 
        echo json_encode(["error" => $e->getMessage()]);
        exit;
    }
    
?>

