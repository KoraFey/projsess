<?php
require_once __DIR__."/../config.php";



try{
    $gUserId = authentifier();
} catch(Exception $e){
    $response = [];
    http_response_code(401);
    $response['error'] = "Non autorisé";
    echo json_encode($response);
}

if(isset($id) && filter_var($id, FILTER_VALIDATE_INT)){
    $stmt = $pdo->prepare("SELECT * FROM `Publication` WHERE `type`=:type");
    $stmt->bindValue(":type", "actualite");
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
