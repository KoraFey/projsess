<?php
require_once __DIR__.'/config.php';
$stmt = $pdo->prepare('SELECT * FROM settings WHERE user_id = ? ');
$stmt->execute([$_SESSION["usager"]]);
$settings = $stmt->fetch();
$settingJson = json_encode($settings);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All in One</title>
    <link rel="stylesheet" href="./styles/styles.css">
    <link rel="stylesheet" href="./styles/normalize.css">


    <script>
      let setting = <?= $settingJson ?>;
    </script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="./images/USL League One Icon.png">
            <h2>All in One</h2>
        </div>

        <div class="settings-container">
        <div class="settings-toggle" onclick="toggleSettings()">
            <img src="images/parametres.png" alt="Paramètres" class="parametres">
        </div>

        <div class="settings-menu" id="settingsMenu">
            <!-- Dark Mode Toggle -->
            <div class="setting">
                <img src="images/lune.png" alt="lune" class="lune">
                <label for="dark-mode">Mode sombre :</label>
                <input type="checkbox" id="dark-mode" onchange="toggleDarkMode()">
            </div>

            <!-- Profil Icon -->
            <div class="setting">
                <img src="images/utilisateur.png" alt="utilisateur" class="utilisateur">
                <a href="./profil.php">Profil</a>

                <!-- Changer Mot de Passe -->
                <div class="setting">
                    <img src="images/reinitialiser-le-mot-de-passe.png" alt="mdp" class="mdp">
                    <a href="#" id="change-password-link">Changer Mot de Passe</a>
                </div>

                <!-- Notification -->
                <div class="setting">
                <img src="images/notification.png" alt="notification" class="notification">
                <label for="dark-mode">Notification :</label>
                <input type="checkbox" id="notification" onchange="toggleNotification()">

                </div>

                <!-- Publication -->
                <div class="setting">
                    <img src="images/publication.png" alt="publication" class="publication">
                    <a href="#">Publication</a>
                </div>

                <!-- Amis -->
                <div class="setting">
                    <img src="images/amis.png" alt="ami" class="ami">
                    <a href="#">Amis</a>
                </div>

                <!-- Historique d'activité -->
                <div class="setting">
                    <img src="images/historique.png" alt="historique-activite" class="historique">
                    <a href="#">Historique d'activité</a>
                </div>

                <!-- Paiement -->
                <div class="setting">
                    <img src="images/paiement-securise.png" alt="paiement" class="paiement">
                    <a href="#">Paiement</a>
                </div>


                <!-- Déconnexion -->
                <div class="setting">
                    <a href="?logout=1">Déconnexion</a>
                </div>
            </div>
        </div>
        </div>


       
    </header>

    <nav class="lien">
        <ul class="categorie">
            <li><a href="#" onclick="displayConteneur('conteneurFeed')">Feed</a></li>
            <li><a href="#" onclick="displayConteneur('conteneurFriends')">Friends</a></li>
            <li><a href="#" onclick="displayConteneur('conteneurMarket')">Marketplace</a></li>
            <li><a href="#" onclick="displayConteneur('conteneurGroup')">Group</a></li>
            <li><a href="#" onclick="displayConteneur('conteneurFood')">Food</a></li>
        </ul>
    </nav>

    <nav class="convo">
        <h3>Conversation</h3>
        <ul class="amis">
            <li><img src="./images/user.png"><a href="ali">Ali</a></li>
            <li><img src="./images/user.png"><a href="bob">Bob</a></li>
            <li><img src="./images/user.png"><a href="charles">Charles</a></li>
            <li><img src="./images/user.png"><a href="dave">Dave</a></li>
        </ul>
    </nav>

    <main>
        <div id="conteneurFeed">
            <article>
            <h3>Charlie Vu</h3>
                <p>Bonjour, ceci est mon premier post</p>
                <img src="./images/download.jpeg" alt="post">
            </article>
            <article>
                <h3>Charlie Vu</h3>
                <p>mon deuxieme post</p>  
                <img src="./images/download.jpeg" alt="post">
            </article>
            <article>
                <h3>Charlie Vu</h3>
                <p>mon troisieme post</p>  
                <img src="./images/download.jpeg" alt="post">
            </article>
        </div>

        <div id="conteneurFriends">
        </div>

        <div id="conteneurMarket">
            <article>
                <h3>Charlie Vu</h3>
                <p>AMG GT63s</p>
                <img src="./images/imageMarket/amg.png" alt="amg">
            </article>
            <article>
                <h3>Charlie Vu</h3>
                <p>Machine à laver</p>
                <img src="./images/imageMarket/machine.png" alt="machine">
            </article>
            <!--
            <article>
                <h3>Charlie Vu</h3>
                <p>divant</p>
                <img src="./images/imageMarket/divant.jpeg" alt="machine">
            </article>
            <article>
                <h3>Charlie Vu</h3>
                <p>ps5</p>
                <img src="./images/imageMarket/ps5.jpeg" alt="machine">
            </article>
            -->
        </div>

        <div id="conteneurGroup">
        </div>

        <div id="conteneurFood">
        </div>
    </main>

    <footer>
        <p>© All in One</p>
    </footer>
    <script src="./styles/script.js"></script> <!-- Fichier JavaScript pour les fonctionnalités -->
</body>
</html>