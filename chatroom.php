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
      console.log(usersList);
    </script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="./images/USL League One Icon.png">
            <h2>Chatroom</h2>

            <input type="text" id="rechercheInput" placeholder="Search for users...">     
            <input type="button" id="rechercheButton" value="Search"> 
            <a href="index.php" class="back-button-acceuil">Retour acceuil</a>
        </div>


        


       
    </header>


    <div id="searchResultatsWindow" style="display: none;">
        <ul id="rechercheResultats"></ul>
    </div>

 
            
            
</div>
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
         <div class="profile-info">
        <div class="profile-image">
            <img src="images/utilisateur.png" alt="Photo de profil" id="profile-img">
            
        </div>
        <div class="profile-details">
            <p><strong>Nom :</strong> <span id="nom">John</span></p>
            <p><strong>Prénom :</strong> <span id="prenom">Doe</span></p>
          
             
        </div>
    </div>
       <main>
    <div class="chat-container">
        <div class="chat-messages" id="chatMessages">
            <!-- Les messages de la conversation seront affichés ici -->
        </div>
        <form id="messageForm" onsubmit="sendMessage(); return false;">
            <input type="text" id="messageInput" placeholder="Écrire un message...">
            <button onclick="sendMessage();" id="sendMessageButton">Envoyer</button>
        </form>
        
    </div>
</main>
    
    </main>

    <footer>
        <p>© All in One</p>
    </footer>
    <script src="./styles/script.js"></script> <!-- Fichier JavaScript pour les fonctionnalités -->
    <script>
        // Récupérer la référence à la zone de chat (élément div) où les messages seront affichés
const chatMessages = document.getElementById('chatMessages');

// Fonction pour envoyer un message
function sendMessage() {
    // Récupérer le contenu du message depuis l'input
    const messageInput = document.getElementById('messageInput');
    const messageContent = messageInput.value.trim();

    // Vérifier si le message n'est pas vide
    if (messageContent !== '') {
        // Créer un nouvel élément paragraphe pour afficher le message
        const messageElement = document.createElement('p');
        messageElement.textContent = messageContent;

        // Ajouter la classe CSS pour styliser le message (facultatif)
        messageElement.classList.add('message');

        // Ajouter le message à la zone de chat
        chatMessages.appendChild(messageElement);

        // Effacer le contenu de l'input après l'envoi du message
        messageInput.value = '';

        // Faire défiler la zone de chat jusqu'au bas pour afficher le nouveau message
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}
</script>
</body>
</html>

