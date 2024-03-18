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
    var main = document.querySelector('main')
    var navConvo = document.querySelector('nav.convo');
    var navLien = document.querySelector('nav.lien');
    var settings = document.getElementById('settingsMenu');
    var header = document.querySelector('header');
    var footer = document.querySelector('footer');

    var elements = [body,main];
    var elementsNav = [navConvo,navLien];

    if (darkModeCheckbox.checked) {
        for(var i = 0; i < elements.length; i++)
            elements[i].classList.add("dark-mode");
        for(var i = 0; i < elementsNav.length; i++)
            elementsNav[i].classList.add("dark-elements");
        
        settings.style.backgroundColor = 'rgb(59, 59, 59)';
        header.style.backgroundColor = 'rgb(51, 0, 95)';
        footer.style.backgroundColor = 'rgb(58, 0, 79)';
    } else {
        for(var i = 0; i < elements.length; i++)
            elements[i].classList.remove("dark-mode");
        for(var i = 0; i < elementsNav.length; i++)
            elementsNav[i].classList.remove("dark-elements");

            settings.style.backgroundColor = 'white';
            header.style.backgroundColor = 'rgb(109, 165, 255)';
            footer.style.backgroundColor = 'rgb(86, 145, 234)';
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
