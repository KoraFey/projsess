<?php
// Démarrage de la session
session_start();

if(isset($_GET["deconnexion"])){
    unset($_SESSION['usager']);
    header("Location: index.php");
    exit;
}

$host = "db";
$database = "mydatabase";
$username = "user";
$password = "password";
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$database;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    die("Erreur de connexion à la base de données: ".$e->getMessage());
}

