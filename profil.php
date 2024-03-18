<?php

require_once __DIR__.'/config.php'; ?>


<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="styles.css"> <!-- Fichier CSS pour le style -->
</head>

<body>

    <h1>Profil</h1>

    <div class="profile-info">
        <div class="profile-image">
            <img src="img/utilisateur.png" alt="Photo de profil">
        </div>
        <div class="profile-details">
            <p><strong>Nom :</strong> <span id="nom">John</span></p>
            <p><strong>Prénom :</strong> <span id="prenom">Doe</span></p>
            <p><strong>Âge :</strong> <span id="age">30 ans</span></p>
            <p><strong>Sexe :</strong> <span id="sexe">Masculin</span></p>
        </div>
    </div>

    <!-- Seul l'admin aura accès à ce formulaire pour modifier les informations -->
    <form id="edit-profile-form" class="edit-profile-form" style="display: none;">
        <h2>Modifier le Profil</h2>
        <label for="edit-nom">Nom :</label>
        <input type="text" id="edit-nom"><br>
        <label for="edit-prenom">Prénom :</label>
        <input type="text" id="edit-prenom"><br>
        <label for="edit-age">Âge :</label>
        <input type="text" id="edit-age"><br>
        <label for="edit-sexe">Sexe :</label>
        <input type="text" id="edit-sexe"><br>
        <button type="submit">Enregistrer</button>
        <button id="retourButton">Retour</button>
    </form>

    <!-- Script pour afficher le formulaire de modification si l'utilisateur est admin -->
    <script>
        var isAdmin = true; // Mettez à true si l'utilisateur est un admin
        if (isAdmin) {
            document.getElementById("edit-profile-form").style.display = "block";
        }

        // Ajout d'un écouteur d'événements au bouton "Retour"
        document.getElementById("retourButton").addEventListener("click", function () {
            // Redirection vers index.html
            window.location.href = "index.php";
        });
    </script>

</body>

</html>