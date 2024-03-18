<?php
require_once __DIR__ . '/config.php';
?>

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
    </main>
    <footer>
        <p>© All in One</p>
    </footer>
</body>
</html>