
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All in One</title>
    <link rel="stylesheet" href="./styles/styles.css">
    <link rel="stylesheet" href="./styles/normalize.css">

</head>
<body>
    <header>
        <img src="./images/USL League One Icon.png">
        <h2>All in One</h2>
    </header>

    <nav class="lien">
        <ul class="categorie">
            <li><a href="">Feed</a></li>
            <li><a href="">Friends</a></li>
            <li><a href="">Marketplace</a></li>
            <li><a href="">Group</a></li>
            <li><a href="">Food</a></li>
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
        <div class="conteneur">
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

        <div class="settings-container">
        <div class="settings-toggle" onclick="toggleSettings()">
            <img src="images/parametres.png" alt="Paramètres" class="parametres">
            <span>Paramètres</span>
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
                <a href="profil.html">Profil</a>

                <!-- Changer Mot de Passe -->
                <div class="setting">
                    <img src="images/reinitialiser-le-mot-de-passe.png" alt="mdp" class="mdp">
                    <a href="#" id="change-password-link">Changer Mot de Passe</a>
                </div>

                <!-- Notification -->
                <div class="setting">
                    <img src="images/notification.png" alt="notification" class="notification">
                    <a href="#">Notification</a>
                </div>

                <!-- Publication -->
                <div class="setting">
                    <img src="images/publication.png" alt="publication" class="publication">
                    <a href="#">Publication</a>
                </div>

                <!-- Amis -->
                <div class="setting">
                    <img src="images/amis.png" alt="amis" class="amis">
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
                    <a href="#">Déconnexion</a>
                </div>
            </div>
        </div>

        <script src="./styles/script.js"></script> <!-- Fichier JavaScript pour les fonctionnalités -->
    </main>
    <footer>
        <p>© All in One</p>
    </footer>
</body>
</html>