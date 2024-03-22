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

    <nav class="lien">
        <ul class="categorie">
            <li><a href="#" onclick="displayConteneur('conteneurFeed')">Feed</a></li>
            <li><a href="#" onclick="displayConteneur('conteneurFriends')">Friends</a></li>
            <li><a href="#" onclick="displayConteneur('conteneurMarket')">Marketplace</a></li>
            <li><a href="#" onclick="displayConteneur('conteneurGroup')">Group</a></li>
            <li><a href="#" onclick="displayConteneur('conteneurFood')">Food</a></li>
            <li><a href="chatroom.php">Chatroom</a></li>
            
            
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
       
    
    </main>

    <footer>
        <p>© All in One</p>
    </footer>
    <script src="./styles/script.js"></script> <!-- Fichier JavaScript pour les fonctionnalités -->
</body>
</html>

