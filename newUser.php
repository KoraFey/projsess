<?php
$gPublic = true;
$webAccess = true;
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
            $tempId =  $pdo->lastInsertId(); 
            $stmt = $pdo->prepare('INSERT INTO settings (user_id) VALUES (?)');
            $stmt->execute([$tempId]);

            
            $stmt = $pdo->prepare('SELECT id FROM users WHERE id != ?');
            $stmt->execute([$tempId]);
            $userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

            foreach ($userIds as $userId) {
                $stmt = $pdo->prepare('SELECT chat_room_id FROM Chat_Room_User WHERE user_id = ? AND chat_room_id IN (SELECT chat_room_id FROM Chat_Room_User WHERE user_id = ?)');
                $stmt->execute([$tempId, $userId]);
                $existChatRoomId = $stmt->fetchColumn();

                if (!$existChatRoomId) {
                    $stmt = $pdo->prepare('INSERT INTO Chat_Room (owner_id, name) VALUES (?, ?)');
                    $stmt->execute([null, 'Chat Room']);
                    $chatRoomId = $pdo->lastInsertId();

                    $stmt = $pdo->prepare('INSERT INTO Chat_Room_User (chat_room_id, user_id) VALUES (?, ?)');
                    $stmt->execute([$chatRoomId, $tempId]);

                    $stmt = $pdo->prepare('INSERT INTO Chat_Room_User (chat_room_id, user_id) VALUES (?, ?)');
                    $stmt->execute([$chatRoomId, $userId]);
                }
            }

            header("Location: /login.php");            
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
     <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./styles.css?val=1" />
    <title>Inscription allinone</title>
</head>
<body>
    <header >
        <header class="bg-primary text-white text-center py-3">
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

                <button type="submit" class="btn btn-primary">Create Account</button><br>
                
                <button type="connexion" id="retour-connexion" class="btn btn-success mt-2 .align-top">retour vers connexion</button>
            </form>
        </section>
    </div>

    <footer >
        <footer class="bg-primary text-white text-center py-3 fixed-bottom">
        <p>&copy; All in One</p>
    </footer>


    <script>
var retourBtn = document.getElementById('retour-connexion');
    retourBtn.addEventListener('click', function(e) {
        e.preventDefault();
        window.location.href = './login.php';
    });
  </script>
  
</body>
</html>


