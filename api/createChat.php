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

//Obtenir le corps de la requête
$body = json_decode(file_get_contents("php://input"));

