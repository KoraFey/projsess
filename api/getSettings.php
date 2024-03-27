<?php
$gPublic = true;
require_once __DIR__."/../config.php";

if(isset($id) && filter_var($id, FILTER_VALIDATE_INT)){
    $stmt = $pdo->prepare("SELECT * FROM `settings` WHERE `user_id`=:id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $settings = $stmt->fetch();
} else {
    $settings = ["error"=>"Identifiant invalide"];
}

if($settings){
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($settings);
    exit;
} else {
    header("HTTP/1.0 404 Not Found");
    exit;
}
