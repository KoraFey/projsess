<?php
require_once __DIR__.'/config.php';
$stmt = $pdo->prepare('SELECT * FROM settings WHERE user_id = ? ');
$stmt->execute([$_SESSION["usager"]]);
$settings = $stmt->fetch();
$settingJson = json_encode($settings);


$loggedUserId = $_SESSION["usager"];

$stmt = $pdo->prepare('SELECT username FROM users WHERE id != ?');
$stmt->execute([$loggedUserId]);
$users = $stmt->fetchAll();
$usersJson = json_encode($users);


/*
$stmt = $pdo->prepare('SELECT id FROM Chat_Room WHERE owner_id = ?');
$stmt->execute([$loggedUserId]);
$chatRoomData = $stmt->fetch();

if ($chatRoomData) {
    $chatRoomId = $chatRoomData['id'];
} else {
    $stmt = $pdo->prepare('INSERT INTO Chat_Room (owner_id, name) VALUES (?, ?)');
    $stmt->execute([$loggedUserId, 'Chat Room Name']);
    $chatRoomId = $pdo->lastInsertId();
}

foreach ($users as $user) {
    $username = $user['username'];

    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $userData = $stmt->fetch();

    if ($userData) {
        $userId = $userData['id'];

        $stmt = $pdo->prepare('INSERT INTO Chat_Room_User (chat_room_id, user_id) VALUES (?, ?)');
        $stmt->execute([$chatRoomId, $userId]);
    } else {
        echo "Utilisateur non trouvé dans la base de données: $username";
    }
}
*/


$stmt = $pdo->prepare('SELECT * FROM GIFs');
$stmt->execute();
$gifs = $stmt->fetchAll();
$gifsJson = json_encode($gifs);


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
      let usersList = <?= $usersJson ?>;
      let gifsList = <?= $gifsJson ?>;
      console.log(gifsList);
    </script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="./images/USL League One Icon.png">
            <h2>All in One</h2>

            <input type="text" id="rechercheInput" placeholder="Search for users...">     
            <input type="button" id="rechercheButton" value="Search"> 
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

              

                <!-- Notification -->
                <div class="setting">
                <img src="images/notification.png" alt="notification" class="notification">
                <label for="dark-mode">Notification :</label>
                <input type="checkbox" id="notification" onchange="toggleNotification()">

                </div>

              

                <!-- Amis -->
                <div class="setting">
                    <img src="images/amis.png" alt="ami" class="ami">
                    <a href="#">Amis</a>
                </div>

               

                <!-- Paiement -->
                <div class="setting">
                    <img src="images/paiement-securise.png" alt="paiement" class="paiement">
                    <a href="#">Paiement</a>
                </div>


                <!-- Déconnexion -->
                <div class="setting">
                    <a href="?logout=1" class="deconnexion"> Déconnexion</a>
                </div>
            </div>
        </div>
        </div>


       
    </header>


    <div id="searchResultatsWindow" style="display: none;">
        <ul id="rechercheResultats"></ul>
    </div>

    <nav class="lien">
        <ul class="categorie">
            <li><a href="#" class="highlighted" id="conteneurFeedLink" onclick="displayConteneur('conteneurFeed')">Feed</a></li>
            <li><a href="#" class="unhighlighted" id="conteneurFriendsLink" onclick="displayConteneur('conteneurFriends')">Friends</a></li>
            <li><a href="#" class="unhighlighted" id="conteneurMarketLink" onclick="displayConteneur('conteneurMarket')">Marketplace</a></li>
            <li><a href="#" class="unhighlighted" id="conteneurGroupLink" onclick="displayConteneur('conteneurGroup')">Group</a></li>
            <li><a href="#" class="unhighlighted" id="conteneurFoodLink" onclick="displayConteneur('conteneurFood')">Food</a></li>
            <li><a href="#" class="unhighlighted" id="profileInfoLink" onclick="displayConteneur('profileInfo')">Chatroom</a></li>
        </ul>
    </nav>

    <nav class="convo">
        <h3>Conversation</h3>
        <ul class="amis">
            
           
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
    

        <div class="profile-info" id="profileInfo">
            <div class="profile-image">
                <img src="images/utilisateur.png" alt="Photo de profil" id="profile-img">
            
                <div class="profile-details">
                    <p><strong>Nom :</strong> <span id="nomProfile">John</span></p>
                    <p><strong>Prénom :</strong> <span id="prenomProfile">Doe</span></p>
                </div>
            </div>
            <div class="chat-container">



            
                <button onClick="toggleCreation();">creer chat</button>
                <div class = "cree chat" id = "hide create">
                    <form>
                        <div id="div chat">
                            <input type="text" id="1">
                        </div>
                        
                        <button onclick="ajoutChamps();">new user</button>
                        <button >cree</button>
                    </form>
                </div>

                <!-- surely ca peiut etre mieu fait-->
                <script>
                    const creation = document.getElementById("hide create");
                        creation.style.display = "none";
                </script>



                <div class="chat-messages" id="chatMessages">
                <!-- Les messages de la conversation seront affichés ici -->
                </div>
                <form class="boiteInput" id="messageForm" onsubmit="sendMessage(); return false;">
                    <input type="text" id="messageInput" placeholder="Écrire un message...">
                    <button onclick="sendMessage();" id="sendMessageButton">Envoyer</button>
                    <button id="openGifBtn">Select GIF</button>

                    <div id="gifModal" style="display: none;">
                        <div id="gifContainer"></div>
                    </div>
                </form>
            </div>
        </div>


    </main>

    <footer>
        <p>© All in One</p>
    </footer>
    <script src="./styles/script.js"></script> <!-- Fichier JavaScript pour les fonctionnalités -->
</body>
</html>