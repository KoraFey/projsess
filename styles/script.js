let conteneurFeed = document.getElementById("conteneurFeed");
let conteneurProfile = document.getElementById("conteneurProfile");
let conteneurMarket = document.getElementById("conteneurMarket");
let conteneurGroup = document.getElementById("conteneurGroup");
let conteneurFood = document.getElementById("conteneurFood");
//let conteneurChatRoom = document.getElementById("conteneurChatRoom");
let profileInfo = document.getElementById("profileInfo");
let lienProfile;
let openGifs = false;

let darkModeCheckbox = document.getElementById("dark-mode");
let conteneurPrincipal = [
  conteneurFeed,
  conteneurProfile,
  conteneurMarket,
  conteneurGroup,
  conteneurFood,
  profileInfo
];

function displayConteneur(conteneur) {
  for (let i = 0; i < conteneurPrincipal.length; i++) {
      conteneurPrincipal[i].style.display =
          conteneurPrincipal[i].id === conteneur ? "flex" : "none";

      let highlightedLien;
      if (conteneurPrincipal[i].id == conteneur) {
          highlightedLien = document.getElementById(`${conteneur}Link`);
          highlightedLien.classList.add("highlighted");
          highlightedLien.classList.remove("unhighlighted");

      } else {
          highlightedLien = document.getElementById(`${conteneurPrincipal[i].id}Link`);
          highlightedLien.classList.add("unhighlighted");
          highlightedLien.classList.remove("highlighted");
      }

      if(conteneur == 'profileInfo' && lienProfile != null){
          let nomProfile = document.getElementById('nomProfile');
          nomProfile.textContent = `${lienProfile}`;
      }
  }
}


function populateGIFs(gifs) {
  const gifContainer = document.getElementById('gifContainer');
  gifContainer.innerHTML = '';
  gifs.forEach(gif => {
      const gifElement = document.createElement('img');
      gifElement.src = "https://i.giphy.com/"+gif.id+".webp"; 
      gifElement.alt = gif.title;
      gifElement.className = 'gif';
      gifElement.addEventListener('click', () => {
          const chatMessages = document.getElementById('chatMessages');
          const messageElement = document.createElement("img");
          messageElement.src = "https://i.giphy.com/"+gif.id+".webp";
          messageElement.classList.add("message", "image-chat");
          chatMessages.appendChild(messageElement);
          chatMessages.scrollTop = chatMessages.scrollHeight;

          openGifs = false;
          toggleGifs();
      });
      gifContainer.appendChild(gifElement);
  });
}


function toggleGifs() {
  const modal = document.getElementById('gifModal');
  if (openGifs) {
    modal.style.display = 'block';
    populateGIFs(gifsList);
  } else {
    modal.style.display = 'none';
  }
}


const btn = document.getElementById("openGifBtn");
btn.addEventListener('click', function() {
  if(openGifs)
    openGifs = false;
  else
    openGifs = true;
  toggleGifs();
});


document.addEventListener("DOMContentLoaded", function () {
  for (let i = 0; i < conteneurPrincipal.length; i++) {
    conteneurPrincipal[i].style.display =
      conteneurPrincipal[i].id === "conteneurFeed" ? "flex" : "none";
  }

  if (setting["dark_mode"] == 1) {
    darkModeCheckbox.checked = true;
    toggleDarkMode();
  }

  const rechercheInput = document.getElementById("rechercheInput");
  const rechercheResultats = document.getElementById("rechercheResultats");
  const searchResultatsWindow = document.getElementById(
    "searchResultatsWindow"
  );
  
  function filterUsers(userValue) {
      return usersList.filter(user => user.username.toLowerCase().includes(userValue.toLowerCase()));
  }
  
  function displayResultats(users) {
      rechercheResultats.innerHTML = '';
  
      users.forEach(user => {
          const li = document.createElement('li');
          li.textContent = user.username;
          rechercheResultats.appendChild(li);
  
          li.addEventListener('click', () => {
              rechercheInput.value = user.username;
              rechercheResultats.innerHTML = ''; 
          });
      });
  
      searchResultatsWindow.style.display = 'block';
  }
  
  rechercheInput.addEventListener('input', () => {
      const user = rechercheInput.value.trim();
  
      console.log("INPUT");
  
      if (user === '') {
          rechercheResultats.innerHTML = '';
          searchResultatsWindow.style.display = 'none';
          return;
      }
  
      const users = filterUsers(user);
      displayResultats(users);
  });
  
  rechercheInput.addEventListener('keydown', (event) => {
    if (event.key === 'Enter') {
      displayConteneur('conteneurProfile');
    }
  });
  rechercheButton.addEventListener('click', (event) => {
    displayConteneur('conteneurProfile');
  });

  let amisList = document.querySelector('.amis');
  amisList.innerHTML = '';

  usersList.forEach(user => {
    let listItem = document.createElement('li');
    let anchor = document.createElement('a');

    anchor.setAttribute('href', '#');
    anchor.textContent = user.username;
    
    let image = document.createElement('img');
    image.setAttribute('src', './images/user.png');

    listItem.appendChild(image);
    listItem.appendChild(anchor);

    amisList.appendChild(listItem);
});

//lien pour les liens de convo vers --> profile
let liens = document.querySelectorAll('.amis a');

liens.forEach(function(lien) {
  lien.addEventListener('click', function(event) {
        event.preventDefault(); 

        lienProfile = this.textContent;
        
        displayConteneur('profileInfo');

        lienProfile = null;
    });
});
});

const chatMessages = document.getElementById('chatMessages');

// Fonction pour envoyer un message
function sendMessage() {
    // Récupérer le contenu du message depuis l'input
    const messageInput = document.getElementById("messageInput");
    const messageContent = messageInput.value.trim();

    // Vérifier si le message n'est pas vide
    if (messageContent !== "") {
        // Créer un nouvel élément paragraphe pour afficher le message
        const messageElement = document.createElement("p");
        messageElement.textContent = messageContent;

        // Ajouter la classe CSS pour styliser le message (facultatif)
        messageElement.classList.add("message");

        // Ajouter le message à la zone de chat
        chatMessages.appendChild(messageElement);

        // Effacer le contenu de l'input après l'envoi du message
        messageInput.value = "";

        // Faire défiler la zone de chat jusqu'au bas pour afficher le nouveau message
        chatMessages.scrollTop = chatMessages.scrollHeight;
    
    //fetch les messages pour logs et envoi
    fetch('/chatroom.php',{
      method: 'POST',
      headers: {
        'Content-Type': 'application/json', //(a changer?)
      },
      body: JSON.stringify({ content: messageContent }),
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Failed to send message');
      }
      //si erreur a envoyer
    })
    .catch(error => {
      console.error('Error sending message:', error.message);
      // si erreur d'envoi
    });
    
  }
}


function toggleSettings() {
  let settingsMenu = document.getElementById("settingsMenu");
  if (settingsMenu.style.display === "block") {
    settingsMenu.style.display = "none";
  } else {
    settingsMenu.style.display = "block";
  }
}

function toggleCreation() {
  const creation = document.getElementById("hide create");
  if (creation.style.display === "block") {
    creation.style.display = "none";
  } else {
    creation.style.display = "block";
  }
  const champs = document.querySelectorAll(".new");
  champs.forEach((e) => {
    e.remove();
  });
}

function toggleDarkMode() {
  let body = document.body;
  let main = document.querySelector("main");
  let navConvo = document.querySelector("nav.convo");
  let navLien = document.querySelector("nav.lien");
  let settings = document.getElementById("settingsMenu");
  let header = document.querySelector("header");
  let footer = document.querySelector("footer");
  let chatMessages = document.getElementById("chatMessages");


  let elements = [body, main];
  let elementsNav = [navConvo, navLien];

  if (darkModeCheckbox.checked) {
    setting["dark_mode"] = 1;
    for (let i = 0; i < elements.length; i++)
      elements[i].classList.add("dark-mode");
    for (let i = 0; i < elementsNav.length; i++)
      elementsNav[i].classList.add("dark-elements");

    settings.style.backgroundColor = "rgb(59, 59, 59)";
    header.style.backgroundColor = "rgb(51, 0, 95)";
    footer.style.backgroundColor = "rgb(58, 0, 79)";
    chatMessages.style.backgroundColor = "rgb(49, 43, 52)";
  } else {
    setting["dark_mode"] = 0;
    for (let i = 0; i < elements.length; i++)
      elements[i].classList.remove("dark-mode");
    for (let i = 0; i < elementsNav.length; i++)
      elementsNav[i].classList.remove("dark-elements");

    settings.style.backgroundColor = "white";
    header.style.backgroundColor = "rgb(109, 165, 255)";
    footer.style.backgroundColor = "rgb(86, 145, 234)";
    chatMessages.style.backgroundColor = "white";

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

function fetchGIFs() {
  fetch("/api/gifs/") 
  .then(response => response.json())
  .then(data => {
      const gifs = data.data;
      const gifContainer = document.getElementById('gifContainer');
      gifContainer.innerHTML = '';
      gifs.forEach(gif => {
          const gifImage = document.createElement('img');
          gifImage.src = gif.images.fixed_height.url;
          gifImage.alt = gif.title;
          gifImage.style.cursor = 'pointer';
          gifImage.addEventListener('click', () => {
              sendGIFToChat(gif.images.fixed_height.url);
              modal.style.display = "none";
          });
          gifContainer.appendChild(gifImage);
      });
  })
  .catch(error => console.error('Error fetching GIFs:', error));
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

function ajoutChamps() {
  const newChamp = document.createElement("input");
  newChamp.setAttribute("type", "text");
  newChamp.setAttribute("class", "new");
  const div = document.getElementById("div chat");
  div.append(newChamp);
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

