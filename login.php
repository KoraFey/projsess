<?php
$gPublic = true;
require_once __DIR__.'/config.php';

$error ='';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
  $stmt->execute([$username]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
      $_SESSION['usager'] = $user['id'];
      //*location router a implementer
      exit;
  } else {
      $error = "Nom d'utilisateur ou mot de passe incorrect.";
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <title>All in one</title>
  </head>
  <body>
    <header>
      <h1>All in one</h1>
    </header>

    <div>
      <section id="authentification">
        <h2>Login</h2>
        <?php if($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form id="loginForm" class="form-group" action='./login.php' method='post'>
          <label for="username">Nom d'utilisateur:</label>
          <input
            type="text"
            id="username"
            name="username"
            class="form-control"
            required
          />

          <label for="password">Mot de passe:</label>
          <input
            type="password"
            id="password"
            name="password"
            class="form-control"
            required
          />

          <button type="submit" >
            Se connecter
          </button>
          <button onclick="window.location.href='newUser.php'">Créer un compte</button>          
        </form>
      </section>
    </div>

    <footer class="bg-primary text-white text-center py-3 fixed-bottom">
      <p>&copy; All in one</p>
    </footer>
  </body>
</html>