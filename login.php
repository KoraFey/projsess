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
      header("Location: /index.php");      
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
      <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./styles.css" />
    <title>All in One</title>
  </head>
  <body>
    <header>
      <header class="bg-primary text-white text-center py-3">
      <h1>All in One</h1>
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

          <button type="submit" class="btn btn-success mt-2 .align-top">
            Se connecter
          </button>    
        </form>
        <button onclick="window.location.href='./newUser.php'" class="btn btn-secondary mt-2 .align-top">Créer un compte</button>      
      </section>
    </div>

    <footer class="bg-primary text-white text-center py-3 fixed-bottom">
      <p>&copy; All in one</p>
    </footer>
  </body>
</html>