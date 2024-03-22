<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatroom</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>New Chat</h2>
            <ul class="discussion-list">
                <!-- Liste des discussions -->
                <li><a href="#">Discussion 1</a></li>
                <li><a href="#">Discussion 2</a></li>
                <li><a href="#">Discussion 3</a></li>
                <!-- Ajouter d'autres discussions si nécessaire -->
            </ul>
        </div>
        <div class="chat">
            <div class="chat-header">
                <h2>ChatGPT</h2>
            </div>
            <div class="chat-messages">
                <!-- Messages de la conversation -->
                <!-- Les messages seront affichés ici -->
            </div>
            <div class="chat-input">
                <textarea placeholder="Votre message"></textarea>
                <button>Envoyer</button>
            </div>
        </div>
    </div>

    <script src="script.js"></script> <!-- Fichier JavaScript pour la gestion des interactions -->
</body>
</html>

