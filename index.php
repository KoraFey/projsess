<?php
$webAccess = true;
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


$stmt = $pdo->prepare('SELECT id FROM users WHERE id != ?');
$stmt->execute([$loggedUserId]);
$userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

foreach ($userIds as $userId) {
    $stmt = $pdo->prepare('SELECT chat_room_id FROM Chat_Room_User WHERE user_id = ? AND chat_room_id IN (SELECT chat_room_id FROM Chat_Room_User WHERE user_id = ?)');
    $stmt->execute([$loggedUserId, $userId]);
    $existChatRoomId = $stmt->fetchColumn();

    if (!$existChatRoomId) {
        $stmt = $pdo->prepare('INSERT INTO Chat_Room (owner_id, name) VALUES (?, ?)');
        $stmt->execute([null, 'Chat Room']);
        $chatRoomId = $pdo->lastInsertId();

        $stmt = $pdo->prepare('INSERT INTO Chat_Room_User (chat_room_id, user_id) VALUES (?, ?)');
        $stmt->execute([$chatRoomId, $loggedUserId]);

        $stmt = $pdo->prepare('INSERT INTO Chat_Room_User (chat_room_id, user_id) VALUES (?, ?)');
        $stmt->execute([$chatRoomId, $userId]);
    }
}


$api_key = 'vHYoMfj0cGW2woUjLMrmsPzrZGbAnkux';

$url = 'https://api.giphy.com/v1/gifs/trending?api_key=' . $api_key;
$response = file_get_contents($url);

if ($response) {
    $data = json_decode($response, true);
    $gifs = $data['data'];
    $gifsJson = json_encode($gifs);
} else {
    $gifsJson = json_encode(['error' => 'Failed to fetch GIFs']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All in One</title>
    <link rel="stylesheet" href="./styles/styles.css">
    <link rel="stylesheet" href="./styles/normalize.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


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

        <div class="btnFonctions">
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
                    <a href="./page_paiement.php">Paiement</a>
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
            <li><a href="#" class="unhighlighted" id="conteneurProfileLink" onclick="displayConteneur('conteneurProfile')">Profile</a></li>
            <li><a href="#" class="unhighlighted" id="conteneurMarketLink" onclick="displayConteneur('conteneurMarket')">Marketplace</a></li>
            <li><a href="#" class="unhighlighted" id="conteneurGroupLink" onclick="displayConteneur('conteneurGroup')">Group</a></li>
            <li><a href="#" class="unhighlighted" id="conteneurFoodLink" onclick="displayConteneur('conteneurFood')">Food</a></li>
            <li><a href="#" class="unhighlighted" id="profileInfoLink" onclick="displayConteneur('profileInfo')">Profile</a></li>
            <li><a href="#" class="unhighlighted" id="chatRoomLink" onclick="displayConteneur('conteneurChatRoom')">Chatroom</a></li>
        </ul>
    </nav>

    <nav class="convo">
        <h3>Conversation</h3>
        <ul class="amis">
            
           
        </ul>
    </nav>

    <main>
        <div id="conteneurChatRoom">
            <!--<h3>ChatRoom</h3>-->
            <div class="chat-container">
                <div class="chat-messages">
                    <div class="message__outer">
                        <!--<div class="message__avatar"></div>-->
                        <div class="message__inner">
                        <!--<div class="message__bubble"></div>-->
                        <!--<div class="message__actions"></div>-->
                        <!--<div class="message__spacer"></div>-->
                        </div>
                    <!--<div class="message__status"></div>-->
                    </div>
                </div>
                <div class="boiteInput">
                    <input type="text" id="messageInput" placeholder="Entrez votre message..." />
                    <button id="envoyerMessageBtn">Envoyer</button>
                </div>
            </div>
        </div>        
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

        <div id="conteneurProfile">
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

       <div id="conteneurFood" class="container">
       <div class="container">
    <div class="row">
        <div class="col-12 .col-lg-12">
            <!-- Restaurant 1 -->
            <div class="restaurant">
                <h3>PIZZA BELLA NAPOLI</h3>
                <!-- Carrousel pour le restaurant 1 -->
                <div id="carousel1" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="images/pizza.jpeg" class=".col-md-12" alt="Restaurant 1 Image 1" >
                            

                            <div class="commander-text">
                               <button class="btn btn-success" onclick="toggleMenu()">Commander</button>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="images/pizza 2.jpeg" class=".col-md-12" alt="Restaurant 1 Image 2">

                            <div class="commander-text">
                                <button class="btn btn-success" onclick="toggleMenu()">Commander</button>
                            </div>
                        </div>
                         <div class="carousel-item">
                            <img src="images/pizza 3.jpeg" class=".col-md-12" alt="Restaurant 1 Image 2">

                            <div class="commander-text">
                                <button class="btn btn-success" onclick="toggleMenu()">Commander</button>
                            </div>
                            
                        </div>
                        <!-- Ajoutez d'autres images pour le restaurant 1 si nécessaire -->
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel1" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel1" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <p>
                    Contactez-nous pour une livraison à domicile ou pour une commande pour emporter. Notre équipe se fera un plaisir de vous servir !
                    Adresse : 1234, Rue de la Piazza, Montréal, QC H2X 1K5.</p>
                     <div id="menu" style="display: none;">
                    <!-- Insérez le contenu du menu ici -->
                    <h4>Menu</h4>
<ul id="menu-items">
    <li>
        <strong>Pizzas:</strong>
        <ul>
            <li data-name="Pizza Margherita" data-price="10">Pizza Margherita - $22.45</li>
                        <li data-name="Pizza Pepperoni" data-price="12">Pizza Pepperoni - $27.99</li>
                        <li data-name="Pizza Vegetariana" data-price="11">Pizza Vegetariana - $25.79</li>
                        <li data-name="Pizza Margherita" data-price="10">Pizza Frommage - $20.99</li>
                        <li data-name="Pizza Margherita" data-price="10">Pizza Mixte - $30.22</li>
            <!-- Ajoutez d'autres tailles de pizza si nécessaire -->
        </ul>
    </li>
    <li>
        <strong>Boissons:</strong>
        <ul>
            <li data-name="Coca Cola" data-price="2">Coca Cola - $2.00</li>
            <li data-name="Pepsi" data-price="2">Pepsi - $2.00</li>
            <li data-name="Sprite" data-price="2">Sprite - $2.00</li>
            <li data-name="Fanta" data-price="2">Fanta - $2.00</li>
            <!-- Ajoutez d'autres boissons si nécessaire -->
        </ul>
    </li>
    <li>
        <strong>Frites:</strong>
        <ul>
    <li data-name="Frites Medium" data-price="5">Frites (Medium) - $5.00</li>
    <li data-name="Frites Large" data-price="8">Frites (Large) - $8.00</li>
    </ul>
    </li>
    <li>
        
        <strong>Ailes de poulet:</strong>
        <ul>

    <li data-name="Boîte d'ailes de poulet Petite" data-price="12">Boîte d'ailes de poulet (Petite) - $12.00</li>
    <li data-name="Boîte d'ailes de poulet Familiale" data-price="20">Boîte d'ailes de poulet (Familiale) - $20.00</li>
    <!-- Ajoutez d'autres articles du menu si nécessaire -->
</ul>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#panierModal">
  Voir le panier
</button>

<!-- Définition de la boîte modale -->
<div class="modal fade" id="panierModal" tabindex="-1" aria-labelledby="panierModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="panierModalLabel">Panier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4>Panier</h4>
        <ul id="panier-items"></ul>
        <p id="total">Total: $0</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button onclick="viderPanier()" type="button" class="btn btn-danger">Vider le panier</button>
        <button onclick="payer()" type="button" class="btn btn-primary">Payer</button>
      </div>
    </div>
  </div>
</div>
  </div>
            
                
            </div>
        </div>
        <div class="col-12 .col-lg-12">
            <!-- Restaurant 2 -->
            
        </div>
        
    </div>
</div>


 

<!-- Conteneur pour le menu du restaurant -->
<div id="menuContainer_restaurant1" class="container menuContainer"></div>


<div id="menuContainer" class="container">
    <!-- Le contenu du menu du restaurant sera inséré ici -->
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
   <!---payment--->     
<div id="modal-paiement" class="modal">
    <div class="modal-content">
        <span class="close" onclick="fermerModal()">&times;</span>
        <h2>Informations de paiement</h2>
        <p>Insérez ici les informations de paiement, telles que les méthodes de paiement acceptées, les instructions de paiement, etc.</p>
        <!-- Ajoutez les informations de paiement nécessaires ici -->
        <form id="formulaire-paiement">
            <label for="numero-carte">Numéro de carte:</label>
            <input type="text" id="numero-carte" name="numero-carte" placeholder="1234 5678 9012 3456" required>
            <label for="titulaire-carte">Titulaire de la carte:</label>
            <input type="text" id="titulaire-carte" name="titulaire-carte" placeholder="John Doe" required>
            <label for="date-expiration">Date d'expiration:</label>
            <input type="text" id="date-expiration" name="date-expiration" placeholder="MM/AA" required>
            <!-- Ajoutez d'autres champs de paiement ici si nécessaire -->
            <button type="submit">Payer</button>
        </form>
    </div>
</div>

    </main>

    <footer>
        <p>© All in One</p>
    </footer>
    <script src="./styles/script.js?reload=1"></script> <!-- Fichier JavaScript pour les fonctionnalités -->



  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sélectionnez toutes les divs avec la classe "commander-text"
    const commanderTexts = document.querySelectorAll('.commander-text');

    // Ajoutez un écouteur d'événements pour chaque div
    commanderTexts.forEach(commanderText => {
        // Au survol de la div, affichez le texte "Commander"
        commanderText.addEventListener('mouseenter', () => {
            commanderText.style.opacity = '1';
        });
        // Lorsque la souris quitte la div, masquez le texte "Commander"
        commanderText.addEventListener('mouseleave', () => {
            commanderText.style.opacity = '0';
        });
    });
</script>
<script>
    function toggleMenu() {
        var menu = document.getElementById("menu1");
        if (menu.style.display === "none") {
            menu.style.display = "block";
        } else {
            menu.style.display = "none";
        }
    }
</script>
<script>
    var panierItems = []; // Liste des articles sélectionnés
    var total = 0; // Total du panier

    function toggleMenu() {
        var menu = document.getElementById("menu");
        if (menu.style.display === "none") {
            menu.style.display = "block";
        } else {
            menu.style.display = "none";
        }
    }

    function ajouterAuPanier(element) {
        var nom = element.dataset.name;
        var prix = parseFloat(element.dataset.price);
        panierItems.push({ nom: nom, prix: prix });
        total += prix;
        afficherPanier();
    }

    function afficherPanier() {
        var panierItemsList = document.getElementById("panier-items");
        panierItemsList.innerHTML = "";
        panierItems.forEach(function(item) {
            var li = document.createElement("li");
            li.textContent = item.nom + " - $" + item.prix;
            panierItemsList.appendChild(li);
        });
        document.getElementById("total").textContent = "Total: $" + total.toFixed(2);
    }

    function viderPanier() {
        panierItems = [];
        total = 0;
        afficherPanier();
    }
    

    window.onload = function() {
        var menuItems = document.querySelectorAll("#menu-items li");
        menuItems.forEach(function(item) {
            item.addEventListener("click", function() {
                ajouterAuPanier(item);
            });
        });
    };
</script>
</body>
</html>