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



//obtenir le body de la requete 
$body = json_decode(file_get_contents("php://input"));

$stmt = $pdo->prepare("INSERT INTO logs VALUES()");