function toggleSettings() {
    var settingsMenu = document.getElementById("settingsMenu");
    if (settingsMenu.style.display === "block") {
        settingsMenu.style.display = "none";
    } else {
        settingsMenu.style.display = "block";
    }
}

function toggleDarkMode() {
    var darkModeCheckbox = document.getElementById("dark-mode");
    var body = document.body;
    if (darkModeCheckbox.checked) {
        body.classList.add("dark-mode");
    } else {
        body.classList.remove("dark-mode");
    }
}

document.getElementById("profile-link").addEventListener("click", function(event) {
    event.preventDefault();
    // Ajoutez ici le code pour gérer le clic sur le lien du profil
    console.log("Lien Profil cliqué");
});

document.getElementById("change-password-link").addEventListener("click", function(event) {
    event.preventDefault();
    // Ajoutez ici le code pour gérer le clic sur le lien de changement de mot de passe
    console.log("Lien Changer Mot de Passe cliqué");
});
