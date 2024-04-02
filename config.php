<?php
// Démarrage de la session
session_start();

require_once __DIR__."/vendor/php_jwt/JWTExceptionWithPayloadInterface.php";
require_once __DIR__."/vendor/php_jwt/BeforeValidException.php";
require_once __DIR__."/vendor/php_jwt/CachedKeySet.php";
require_once __DIR__."/vendor/php_jwt/ExpiredException.php";
require_once __DIR__."/vendor/php_jwt/JWK.php";
require_once __DIR__."/vendor/php_jwt/JWT.php";
require_once __DIR__."/vendor/php_jwt/Key.php";
require_once __DIR__."/vendor/php_jwt/SignatureInvalidException.php";
global $API_SECRET;
$API_SECRET = "son_goku_ssj3"; // Utilisez une clé secrète forte
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function authentifier(){
    global $API_SECRET;
     
     //On vérifie d'abord si on a une session qui comporte la variable user_id,
     //auquel cas on sait que l'authentification a eu lieu par session et on retourne
     //la valeur
    if(isset($_SESSION["user_id"])){
        return $_SESSION["user_id"];
    }
     //Sinon, on continue avec le Token
    //On récupère toutes les entêtes de la requête
    $headers = getallheaders();
    //On s'intéresse spécifiquement à l'entête Authorization
    //Cette dernière comporte le mot clé Bearer suivi du Token.
    //On enlève le mode "Bearer " pour ne conserver que la chaine de caractères du Token
    $jwt = str_replace('Bearer ', '', $headers['Authorization'] ?? '');
    //On décode le Token
    try {
        $decoded = JWT::decode($jwt, new Key($API_SECRET, 'HS256'));
    // Si le token est valide, on retourne l'id de l'usager qui a été stocké dans le Token
        return $decoded->user_id;
     } catch (\Firebase\JWT\ExpiredException $e) {
    // Gérer l'expiration du token
        throw new Exception('Token expiré!');
     } catch (\Exception $e) {
    // Gérer les autres erreurs
    throw new Exception('Erreur de token: '.$e->getMessage());
     }
}

header("Access-Control-Allow-Origin: *");

//Configuration et connexion à la base de données
$host = parse_url($_SERVER["HTTP_HOST"], PHP_URL_HOST);
if($host=="localhost"|| $host=="10.0.2.2"){
    //Code d'accès à la base de données locale
    $host = 'db';
    $db = 'mydatabase';
    $user = 'user';
    $pass = 'password';
} else {
//Codes d'accès à la base de données de production
    $host = 'localhost';
    $db   = 'equipe302';
    $user = 'equipe302';
    $pass = 'mqhcFCeYsRQ/Hav4';
}
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}


$gUserId = 0;
try{
    $gUserId = authentifier();
} catch (Exception $e){
    $gUserId = 0;
}


// Vérification si l'utilisateur est connecté, sinon redirection vers la page de connexion
if ((isset($webAccess) && $webAccess==true) && (!isset($gPublic) || !$gPublic) &&  !$gUserId) {
        header("Location: login.php");
        exit;
} 

if(isset($_GET["logout"])){
    unset($_SESSION['usager']);
    header("Location: login.php");
    exit;
}

