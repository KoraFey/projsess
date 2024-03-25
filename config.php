<?php
// Démarrage de la session
session_start();

header("Access-Control-Allow-Origin: *");

//Configuration et connexion à la base de données
$host = parse_url($_SERVER["HTTP_HOST"], PHP_URL_HOST);
if($host=="localhost"){
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


//Vérification de l'authentification

//Authentification par méthode BASIC pour l'API
if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];
    
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['usager'] = $user['id'];
    } else {
        http_response_code(403);
        echo "Authentification erronée.";
        exit;
    }
}


// Vérification si l'utilisateur est connecté, sinon redirection vers la page de connexion
if ((!isset($gPublic) || !$gPublic) &&  !isset($_SESSION["usager"])) {
    if(isset($_SERVER["CONTENT_TYPE"]) && $_SERVER["CONTENT_TYPE"]=='application/json'){
        http_response_code(403);
        echo "Authentification requise";
        exit;
    } else {
        header("Location: login.php");
        exit;
    }
} elseif(isset($_SESSION["usager"])) {
    // Obtention de l'ID de l'utilisateur connecté
    $gUserId = $_SESSION["usager"];
} else { //Usager pas authentifié mais la page est publique
    $gUserId = 0;
}

if(isset($_GET["logout"])){
    unset($_SESSION['usager']);
    header("Location: login.php");
    exit;
}

