<?php
$webAccess = true;
require_once __DIR__.'/config.php'; // Assurez-vous que ce fichier contient la connexion à la base de données avec l'objet PDO $pdo.


$userId = $_SESSION['user_id'] ?? 1; // Remplacez par la logique d'authentification pour obtenir l'ID de l'utilisateur connecté.

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les informations depuis le formulaire
    $username = $_POST['edit-username'] ?? '';
    $password = $_POST['edit-password'] ?? '';
    $urlPfp = $_POST['edit-image-url'] ?? '';

    // Hasher le mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Préparer et exécuter la requête pour mettre à jour les informations
    $stmt = $pdo->prepare("UPDATE users SET username = ?, password = ?, url_pfp = ? WHERE id = ?");
    $stmt->execute([$username, $hashedPassword, $urlPfp, $userId]);

    // Redirection pour éviter la re-soumission du formulaire
    header("Location: profil.php");
    exit;
}

// Charger les informations actuelles de l'utilisateur
$stmt = $pdo->prepare("SELECT username, url_pfp FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$username = $user['username'] ?? 'Inconnu';
$urlPfp = $user['url_pfp'] ?? 'images/utilisateur.png';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de l'utilisateur</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
<header class="bg-primary text-white text-center py-3">
    <h1>Profil de l'utilisateur</h1>
</header>

<div class="profile-info">
    <div class="profile-image">
        <img src="<?php echo htmlspecialchars($urlPfp); ?>" alt="Photo de profil" id="profile-img">
    </div>
    <div class="profile-details">
        <p><strong>Username :</strong> <span id="username"><?php echo htmlspecialchars($username); ?></span></p>
        <button id="edit-profile-btn" class="btn btn-secondary">Modifier</button>
        <button id="back-home-btn" class="btn btn-secondary">Retour à l'accueil</button>
    </div>
</div>


<form id="edit-profile-form" action="profil.php" method="post" style="display: none;">
    <h2>Modifier le Profil</h2>
    <label for="edit-username">Username :</label>
    <input type="text" name="edit-username" id="edit-username" value="<?php echo htmlspecialchars($username); ?>"><br>
    <label for="edit-password">Mot de passe :</label>
    <input type="password" name="edit-password" id="edit-password"><br>
    <label for="edit-image-url">URL de l'image de profil :</label>
    <input type="text" name="edit-image-url" id="edit-image-url" value="<?php echo htmlspecialchars($urlPfp); ?>"><br>
    <button type="submit">Enregistrer</button>
    

</form>

<script>
document.getElementById('edit-profile-btn').addEventListener('click', function() {
    var editForm = document.getElementById('edit-profile-form');
    editForm.style.display = editForm.style.display === 'none' ? 'block' : 'none';
});
</script>
<script>
document.getElementById('back-home-btn').addEventListener('click', function() {
    window.location.href = 'index.php';
});
</script>

</body>
</html>