<?php
$webAccess = true;
require_once __DIR__.'/config.php'; ?>


<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles/styles.css"> 
</head>

<body>
 <header class="bg-primary text-white text-center py-3">
    <h1>Profil</h1>
</header>

    <div class="profile-info">
        <div class="profile-image">
            <img src="images/utilisateur.png" alt="Photo de profil" id="profile-img">
            
        </div>
        <div class="profile-details">
            <p><strong>Nom :</strong> <span id="nom">John</span></p>
            <p><strong>Prénom :</strong> <span id="prenom">Doe</span></p>
            <p><strong>Âge :</strong> <span id="age">30 ans</span></p>
            <p><strong>Sexe :</strong> <span id="sexe">Masculin</span></p>
             <button id="edit-profile-btn">Modifier</button>
        </div>
    </div>

    <!-- Seul l'admin aura accès à ce formulaire pour modifier les informations -->
    <form id="edit-profile-form" class="edit-profile-form" style="display: none;">
        <h2>Modifier le Profil</h2>
        <label for="edit-nom">Nom :</label>
        <input type="text" name="edit-nom" id="edit-nom"><br>
        <label for="edit-prenom">Prénom :</label>
        <input type="text" id="edit-prenom"><br>
        <label for="edit-age">Âge :</label>
        <input type="text" id="edit-age"><br>
        <label for="edit-sexe">Sexe :</label>
        <input type="text" id="edit-sexe"><br>

        <label for="edit-mdp">Mot de passe : </label>
        <input type="password" id="edit-password">  <br>

        <label for="edit-image-url">URL de l'image de profil :</label>
    <input type="text" id="edit-image-url"><br> <!-- Champ pour l'URL de l'image -->

        <button type="submit">Enregistrer</button>
        <button id="retourButton">Retour</button>
    </form>
    

    <!-- Script pour afficher le formulaire de modification si l'utilisateur est admin -->
    <script>
        // Ajoutez un écouteur d'événement sur le bouton "Modifier"
document.getElementById('edit-profile-btn').addEventListener('click', function() {
    // Affiche ou masque le formulaire de modification en fonction de son état actuel
    var editForm = document.getElementById('edit-profile-form');
    if (editForm.style.display === 'none' || editForm.style.display === '') {
        editForm.style.display = 'block';
    } else {
        editForm.style.display = 'none';
    }
});
    



        var isAdmin = true; // Mettez à true si l'utilisateur est un admin
        if (isAdmin) {
            document.getElementById("edit-profile-form").style.display = "block";
        }

      
    
    var retourBtn = document.getElementById('retourButton');
    retourBtn.addEventListener('click', function(e) {
        e.preventDefault();
        window.location.href = './index.php';
    });




    document.getElementById('edit-profile-form').addEventListener('submit', function(e) {
        e.preventDefault(); // Empêche le rechargement de la page

        // Récupération des valeurs des champs de texte
        var nouveauNom = document.getElementById('edit-nom').value;
        var nouveauPrenom = document.getElementById('edit-prenom').value;
        var nouvelAge = document.getElementById('edit-age').value;
        var nouveauSexe = document.getElementById('edit-sexe').value;
        var nouvelleImageURL = document.getElementById('edit-image-url').value;

        // Mise à jour des éléments sur la page
        document.getElementById('nom').innerText = nouveauNom;
        document.getElementById('prenom').innerText = nouveauPrenom;
        document.getElementById('age').innerText = nouvelAge + ' ans';
        document.getElementById('sexe').innerText = nouveauSexe;
        document.getElementById('profile-img').src = nouvelleImageURL;

        // Afficher un message de confirmation (facultatif)
        alert('Profil mis à jour avec succès !');
    });



    </script>

</body>

</html>