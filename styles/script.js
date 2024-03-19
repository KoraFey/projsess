var conteneurFeed = document.getElementById("conteneurFeed");
var conteneurFriends = document.getElementById("conteneurFriends");
var conteneurMarket = document.getElementById("conteneurMarket");
var conteneurGroup = document.getElementById("conteneurGroup");
var conteneurFood = document.getElementById("conteneurFood");
var conteneurPrincipal = [
  conteneurFeed,
  conteneurFriends,
  conteneurMarket,
  conteneurGroup,
  conteneurFood,
];

function displayConteneur(conteneur) {
  for (var i = 0; i < conteneurPrincipal.length; i++) {
    conteneurPrincipal[i].style.display =
      conteneurPrincipal[i].id === conteneur ? "flex" : "none";
  }
}

document.addEventListener("DOMContentLoaded", function () {
  for (var i = 0; i < conteneurPrincipal.length; i++) {
    conteneurPrincipal[i].style.display =
      conteneurPrincipal[i].id === "conteneurFeed" ? "flex" : "none";
  }
});

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
  var main = document.querySelector("main");
  var navConvo = document.querySelector("nav.convo");
  var navLien = document.querySelector("nav.lien");
  var settings = document.getElementById("settingsMenu");
  var header = document.querySelector("header");
  var footer = document.querySelector("footer");

  var elements = [body, main];
  var elementsNav = [navConvo, navLien];

  if (darkModeCheckbox.checked) {
    setting["dark_mode"] = 1;
    for (var i = 0; i < elements.length; i++)
      elements[i].classList.add("dark-mode");
    for (var i = 0; i < elementsNav.length; i++)
      elementsNav[i].classList.add("dark-elements");

    settings.style.backgroundColor = "rgb(59, 59, 59)";
    header.style.backgroundColor = "rgb(51, 0, 95)";
    footer.style.backgroundColor = "rgb(58, 0, 79)";
  } else {
    setting["dark_mode"] = 0;
    for (var i = 0; i < elements.length; i++)
      elements[i].classList.remove("dark-mode");
    for (var i = 0; i < elementsNav.length; i++)
      elementsNav[i].classList.remove("dark-elements");

    settings.style.backgroundColor = "white";
    header.style.backgroundColor = "rgb(109, 165, 255)";
    footer.style.backgroundColor = "rgb(86, 145, 234)";
  }

  //fetch pour update les settings
  fetch("/api/setSettings/" + setting["user_id"], {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(setting),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(
          "La requête a échoué avec le statut " + response.status
        );
      }
      return response.json();
    })
    .then((data) => {})
    .catch((error) => {
      alert("Erreur lors de la modification des settings: " + error);
      console.error("Erreur lors de la requête:", error);
    });
}

function toggleNotification() {
  let notifCheckBox = document.getElementById("notification");
  if (notifCheckBox.checked) {
    setting["notification"] = 1;
  } else {
    setting["notification"] = 0;
  }
  //fetch pour update les settings
  fetch("/api/setSettings/" + setting["user_id"], {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(setting),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(
          "La requête a échoué avec le statut " + response.status
        );
      }
      return response.json();
    })
    .then((data) => {})
    .catch((error) => {
      alert("Erreur lors de la modification des settings: " + error);
      console.error("Erreur lors de la requête:", error);
    });
}

document
  .getElementById("profile-link")
  .addEventListener("click", function (event) {
    event.preventDefault();
    // Ajoutez ici le code pour gérer le clic sur le lien du profil
    console.log("Lien Profil cliqué");
  });

document
  .getElementById("change-password-link")
  .addEventListener("click", function (event) {
    event.preventDefault();
    // Ajoutez ici le code pour gérer le clic sur le lien de changement de mot de passe
    console.log("Lien Changer Mot de Passe cliqué");
  });
