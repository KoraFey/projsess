<?php
$gPublic = true;
require_once __DIR__.'/config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];


    // Vérifier si l'utilisateur existe déjà
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $message = 'Ce nom d\'utilisateur est déjà pris.';
    } else {
        // Hasher le mot de passe
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Insérer le nouvel utilisateur
        $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
        if ($stmt->execute([$username, $passwordHash])) {
           //*location router a implementer
            exit;
        } else {
            $message = 'Erreur lors de la création du compte.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Inscription allinone</title>
</head>
<body>
    <header >
        <h1>All in One</h1>
    </header>

    <div >
        <section id="newUser">
            <h2>Créer un compte</h2>
            <?php if($message): ?>
                <div class="alert alert-danger"><?php echo $message; ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur:</label>
                    <input type="text" id="username" name="username" class="form-control" required />
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe:</label>
                    <input type="password" id="password" name="password" class="form-control" required />
                </div>

                <button type="submit" class="btn btn-primary">Create Account</button>
            </form>
        </section>
    </div>

    <footer >
        <p>&copy; All in One</p>
    </footer>
</body>
</html>