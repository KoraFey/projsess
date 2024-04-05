let conteneurFeed = document.getElementById("conteneurFeed");
let conteneurProfile = document.getElementById("conteneurProfile");
let conteneurMarket = document.getElementById("conteneurMarket");
let conteneurGroup = document.getElementById("conteneurGroup");
let conteneurFood = document.getElementById("conteneurFood");
let profileInfo = document.getElementById("profileInfo");
let lienProfile;
let openGifs = false;
const postApiUrl = "/api/post/";
const postApiLikes = "/api/postLike/";

let listeArticle = [];
let postType = 'actualite';
let darkModeCheckbox = document.getElementById("dark-mode");
let conteneurPrincipal = [
  conteneurFeed,
  conteneurProfile,
  conteneurMarket,
  conteneurGroup,
  conteneurFood,
  profileInfo
];

document.addEventListener("DOMContentLoaded", function () {  
  function afficherPublications(publications) {
    const conteneurFeed = document.getElementById('conteneurFeed');
    conteneurFeed.innerHTML = ''; 

    const conteneurMarket = document.getElementById('conteneurMarket');
    conteneurMarket.innerHTML = ''; 

    publications.reverse();
    publications.forEach(publication => {
        if (publication.type === 'actualite') {
            const publicationContainer = document.createElement('div');
            publicationContainer.classList.add('publication-container');

            const infoContainer = document.createElement('div');
            infoContainer.classList.add('info-container');
    
            const h3 = document.createElement('h3');
            const p = document.createElement('p');

            const user = allUsersList.find(user => user.id === publication.user_id);
            h3.textContent = user.username; 
            const userPost = user.username; 
            p.textContent = publication.description + ' ~ ' + publication.date_publication;
    
            const tagsContainer = document.createElement('span');
            tagsContainer.classList.add('tags-users');
            
            if (publication.tag_users != null) {
                const tagsUsers = publication.tag_users.split(',').map(tag => {
                    const tagUser = allUsersList.find(user => user.id === parseInt(tag));
                    const tagSpan = document.createElement('span');
                    tagSpan.classList.add('tag-user');
                    tagSpan.textContent = tagUser.username;
                    return tagSpan;
                });
                
                const estAvec = document.createElement('span');
                estAvec.textContent = ' est avec: ';
                tagsContainer.appendChild(estAvec);
                
                tagsUsers.forEach((tag, index) => {
                    tagsContainer.appendChild(tag);
                    if (index < tagsUsers.length - 1) {
                        const vigurle = document.createElement('span');
                        vigurle.textContent = ', ';
                        tagsContainer.appendChild(vigurle);
                    }
                });
            }
            
            infoContainer.appendChild(h3);
            infoContainer.appendChild(tagsContainer);          
            infoContainer.appendChild(p);
    
            const carouselContainer = document.createElement('div');
            const carouselInner = document.createElement('div');

            carouselContainer.classList.add('carousel', 'slide');
            carouselContainer.setAttribute('data-bs-ride', 'carousel');
            carouselContainer.id = `publicationCarousel${publication.id}`;
            carouselInner.classList.add('carousel-inner');

            const imgLike = document.createElement('img');
            imgLike.src = '../images/heart.png';
            imgLike.alt = 'like';
            imgLike.classList.add('image-like'); 

            const imageUrls = publication.image_urls.split(',');
            imageUrls.forEach((url, index) => {
                const carouselItem = document.createElement('div');
                carouselItem.classList.add('carousel-item');
                if (index === 0) 
                    carouselItem.classList.add('active');
                
                const img = document.createElement('img');
                img.classList.add('d-block', 'w-100', 'postImage'); 
                img.src = url;
                img.alt = 'post';

                img.addEventListener('dblclick', function() {
                      imgLike.src = '../images/hearted.png'; 
                      incrementLikes(publication.id);
                });

                carouselItem.appendChild(img);
                carouselInner.appendChild(carouselItem);
            });
            carouselContainer.appendChild(carouselInner);
    
            const carouselAvant = document.createElement('button');
            const carouselApres = document.createElement('button');

            carouselAvant.classList.add('carousel-control-prev');
            carouselAvant.type = 'button';
            carouselAvant.setAttribute('data-bs-target', `#publicationCarousel${publication.id}`);
            carouselAvant.setAttribute('data-bs-slide', 'prev');
            carouselAvant.innerHTML = '<span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span>';
    
            carouselApres.classList.add('carousel-control-next');
            carouselApres.type = 'button';
            carouselApres.setAttribute('data-bs-target', `#publicationCarousel${publication.id}`);
            carouselApres.setAttribute('data-bs-slide', 'next');
            carouselApres.innerHTML = '<span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span>';
    
            carouselContainer.appendChild(carouselAvant);
            carouselContainer.appendChild(carouselApres);
    
            publicationContainer.appendChild(infoContainer);
            publicationContainer.appendChild(carouselContainer);
            


            imgLike.addEventListener('click', function() {
              if (imgLike.src.includes('hearted.png')) {
                  imgLike.src = '../images/heart.png'; 
                  decrementLikes(publication.id);
              } else {
                  imgLike.src = '../images/hearted.png'; 
                  incrementLikes(publication.id);
              }
            });

            const nbLikes = document.createElement('p');
            nbLikes.id = 'nbLikes' + publication.id;

            let likesCount = 0;
            allLikesList.forEach((like) => {
              if (like.id_publication == publication.id) {
                likesCount++;
                if(like.user_id == userActuel){
                  imgLike.src = '../images/hearted.png'; 
                }
              }
            });
            
            if(likesCount != null && likesCount != 1 && likesCount != 0)
              nbLikes.textContent = likesCount + " likes";
            else if(likesCount == 1)
              nbLikes.textContent = "1 like";
            else 
              nbLikes.textContent = "0 like";

            const divInteractions = document.createElement("div");
            divInteractions.id = "divInteractions";

            const imgCmmt = document.createElement('img');
            imgCmmt.src = '../images/chat.png';
            imgCmmt.alt = 'comment';
            imgCmmt.classList.add('image-like'); 

            divInteractions.appendChild(imgLike);
            divInteractions.appendChild(imgCmmt);
            publicationContainer.appendChild(divInteractions);
            publicationContainer.appendChild(nbLikes);

            const divComments = document.createElement("div");
            divComments.id = "divComments" + publication.id;
            divComments.style.display = 'none';

            imgCmmt.addEventListener('click', function() {
                if(document.getElementById(divComments.id).style.display == 'block')
                  document.getElementById(divComments.id).style.display = 'none';
                else
                  document.getElementById(divComments.id).style.display = 'block';
            });

            divComments.style.maxHeight = '150px';
            divComments.style.overflow = 'auto';
            publicationContainer.appendChild(divComments);

            const inputDiv = document.createElement('div');
            inputDiv.classList.add("commentDiv");

            const inputComment = document.createElement('input');
            inputComment.id = "id_inputComment"+publication.id;
            inputComment.type = 'text';
            inputComment.placeholder = 'Ajouter un commentaire pour ' + userPost + '...';

            const commentButton = document.createElement('button');
            commentButton.type = "button";
            commentButton.textContent = "Send";
            commentButton.addEventListener('click', function() {
              if(inputComment.value != ""  && inputComment.value != null)
                commenterPost(publication.id);

              if(document.getElementById(divComments.id).style.display == 'block')
                document.getElementById(divComments.id).style.display = 'none';
              else
                document.getElementById(divComments.id).style.display = 'block';
            });

            inputDiv.appendChild(inputComment);
            inputDiv.appendChild(commentButton);
            publicationContainer.appendChild(inputDiv);
            
            conteneurFeed.appendChild(publicationContainer);
        } else if(publication.type === 'annonce'){
            const annonceContainer = document.createElement('div');
            annonceContainer.classList.add('annonce-container');

            const infoContainer = document.createElement('div');
            infoContainer.classList.add('info-container');
    
            const h3 = document.createElement('h3');
            const p = document.createElement('p');

            const user = allUsersList.find(user => user.id === publication.user_id);
            h3.textContent = user.username; 
            const userPost = user.username; 
            p.textContent = publication.description + ' ~ ' + publication.date_publication;

            infoContainer.appendChild(h3);
            infoContainer.appendChild(p);
    
            const carouselContainer = document.createElement('div');
            const carouselInner = document.createElement('div');

            carouselContainer.classList.add('carousel', 'slide');
            carouselContainer.setAttribute('data-bs-ride', 'carousel');
            carouselContainer.id = `publicationCarousel${publication.id}`;
            carouselInner.classList.add('carousel-inner');

            const imgLike = document.createElement('img');
            imgLike.src = '../images/heart.png';
            imgLike.alt = 'like';
            imgLike.classList.add('image-like'); 

            const imageUrls = publication.image_urls.split(',');
            imageUrls.forEach((url, index) => {
                const carouselItem = document.createElement('div');
                carouselItem.classList.add('carousel-item');
                if (index === 0) 
                    carouselItem.classList.add('active');
                
                const img = document.createElement('img');
                img.classList.add('d-block', 'w-100', 'postImage'); 
                img.src = url;
                img.alt = 'post';

                img.addEventListener('dblclick', function() {
                      imgLike.src = '../images/hearted.png'; 
                      incrementLikes(publication.id);
                });

                carouselItem.appendChild(img);
                carouselInner.appendChild(carouselItem);
            });
            carouselContainer.appendChild(carouselInner);
    
            const carouselAvant = document.createElement('button');
            const carouselApres = document.createElement('button');

            carouselAvant.classList.add('carousel-control-prev');
            carouselAvant.type = 'button';
            carouselAvant.setAttribute('data-bs-target', `#publicationCarousel${publication.id}`);
            carouselAvant.setAttribute('data-bs-slide', 'prev');
            carouselAvant.innerHTML = '<span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span>';
    
            carouselApres.classList.add('carousel-control-next');
            carouselApres.type = 'button';
            carouselApres.setAttribute('data-bs-target', `#publicationCarousel${publication.id}`);
            carouselApres.setAttribute('data-bs-slide', 'next');
            carouselApres.innerHTML = '<span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span>';
    
            carouselContainer.appendChild(carouselAvant);
            carouselContainer.appendChild(carouselApres);
    
            annonceContainer.appendChild(infoContainer);
            annonceContainer.appendChild(carouselContainer);
            
            conteneurMarket.appendChild(annonceContainer);
        }

    });
}

btnAjouterPost.addEventListener('click', function (event) {
  event.preventDefault(); 
  genererFormulaireAjout(null, postType);
  document.getElementById('divAjouter').style.display = 'block';

  document.getElementById('annulerForm').addEventListener('click', function () {
    let formAjout = document.getElementById('divAjouter');
    formAjout.remove();
  });

  document.getElementById('formAjout').addEventListener('submit', function (event) {
      event.preventDefault();

      const images = document.querySelectorAll('#urlList img');
      let srcList = [];
      images.forEach(image => {
          srcList.push(image.src);
      });
      

      let type = document.getElementById('newType').value == 'Actualité' ? 'actualite':'annonce' ;
      let desc = document.getElementById('newDesc').value;


      let selectElement = document.getElementById('newTags');

      let taggedUserIds = [];
      let selectedValues = [];

      if(type == 'actualite') {
      for (let i = 0; i < selectElement.options.length; i++) {
         if (selectElement.options[i].selected) {
             selectedValues.push(selectElement.options[i].value);
          }
      }   
      
      usersList.forEach(user => {
          if (selectedValues.includes(user.username)) {
              taggedUserIds.push(user.id);
           }
      });
      } else {
        let prix = document.getElementById('newPrice').value;
        console.log(prix)
      }

      const newPost = {
        url_image: srcList,
        description: desc,
        id_type: type,
        tags: taggedUserIds,
        prix: null
      };

      fetch(postApiUrl, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json'
          },
          body: JSON.stringify(newPost)
      })
          .then(response => {
              if (!response.ok) {
                  throw new Error('La requête a échoué, code: ' + response.status);
              }
              return response.json();
          })
          .then(data => {
            listePosts = data.listePosts;
            console.log(listePosts);
            afficherPublications(listePosts);
          })
          .catch(error => {
              alert("Erreur a l'ajout du jeu: " + error);
              console.error('Erreur lors de la requête:', error);
          });

      let formAjout = document.getElementById('divAjouter');
      formAjout.remove();
  });
});


function incrementLikes(publicationid) {
  fetch(postApiLikes, {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json'
      },
      body: JSON.stringify({ publication_id: publicationid, delete_ou_insert_comment: "insert" })
  })
  .then(response => {
      if (!response.ok) {
          throw new Error('response was not ok');
      }
      return response.json();
  })
  .then(data => {
      let nbLikes = document.getElementById('nbLikes' + data.publication_id)

      console.log(data.likes)
      if(data.likes != null && data.likes != 1 && data.likes != 0)
        nbLikes.textContent = data.likes + " likes"
      else if(data.likes == 1)
        nbLikes.textContent = "1 like";
      else 
        nbLikes.textContent = "0 like";
  })
  .catch(error => {
      console.error('POST like erreure :', error);
  });
}


function decrementLikes(publicationid) {
  fetch(postApiLikes, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({ publication_id: publicationid , delete_ou_insert_comment: "delete" })
})
.then(response => {
    if (!response.ok) {
        throw new Error('response was not ok');
    }
    return response.json();
})
.then(data => {
    let nbLikes = document.getElementById('nbLikes' + data.publication_id)

    if(data.likes != null && data.likes != 1 && data.likes != 0)
      nbLikes.textContent = data.likes + " likes"
    else if(data.likes == 1)
      nbLikes.textContent = "1 like";
    else 
      nbLikes.textContent = "0 like";
})
.catch(error => {
    console.error('POST like erreure :', error);
});
}

function commenterPost(publicationid) {
  const inputComment = document.getElementById("id_inputComment"+publicationid).value;
  fetch(postApiLikes, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({ publication_id: publicationid , delete_ou_insert_comment: "comment" , comment: inputComment})
})
.then(response => {
    if (!response.ok) {
        throw new Error('response was not ok');
    }
    return response.json();
})
.then(data => {
  populateComments(data.comments);
})
.catch(error => {
    console.error('POST like erreure :', error);
});
}

function populateComments(comments){
  comments.forEach(post => {
    let id_post = post.id_publication;
    let divComment = document.getElementById("divComments"+id_post);
    divComment.innerHTML = "";
  });

  comments.forEach(post => {
    let id_post = post.id_publication;
    let id_user;
    let commentaire = post.commentaire;

    let divComment = document.getElementById("divComments"+id_post);
    let comment = document.createElement("p");

    allUsersList.forEach(user => {
      if(post.user_id === user.id){
        id_user = user.username;
      }
    });

    comment.textContent = id_user + ": " + commentaire;
    divComment.appendChild(comment);
  });
}

afficherPublications(listePosts);
populateComments(allCommentsList);

});

function genererFormulaireAjout(modifier) {
  let divAjouter = document.createElement('div');
  divAjouter.id = 'divAjouter';

  let formAjout = document.createElement('form');
  formAjout.id = 'formAjout';

  const fields = [
    { label: 'URL images:', type: 'text', id: 'newUrls', multiple: true },
    { label: 'Description:', type: 'textarea', id: 'newDesc' },
    { label: 'Type:', type: 'select', options: ['Actualité', 'Annonce'], id: 'newType' },
    { label: 'Tag:', type: 'select-multiple', options: usersList.map(user => user.username), id: 'newTags' }
  ];

  if (postType == 'annonce') {
    fields[3] = { label: 'Prix:', type: 'number', id: 'newPrice' };
  }

  fields.forEach(field => {
    const label = document.createElement('label');
    label.textContent = field.label;
    formAjout.appendChild(label);

    let input;
    switch (field.type) {
      case 'text':
        if (field.id === 'newUrls') {
          input = document.createElement('div');
          const urlInput = document.createElement('input');
          let postMax = 0;
      
          urlInput.type = 'text';
          urlInput.id = 'newUrl';
          input.appendChild(urlInput);
          const addButton = document.createElement('button');
          addButton.textContent = 'Add URL';
          addButton.type = 'button';
          addButton.addEventListener('click', function() {
              const url = urlInput.value;
              if (url.trim() !== '') {
                  const urlList = document.getElementById('urlList');
                  const image = new Image();
                  image.src = url;
                  image.style.maxHeight = '100px'; 
                  image.style.marginRight = '10px'; 
                  image.style.cursor = 'pointer';
      
                  image.addEventListener('click', function() {
                      this.parentNode.removeChild(this);
                      postMax--;
                      urlInput.disabled = false;
                      addButton.disabled = false;
                      urlInput.value = '';
                  });
      
                  urlList.appendChild(image);
                  urlInput.value = '';
                  urlList.scrollTop = urlList.scrollHeight;
                  postMax++;
                  if (postMax === 10) {
                      urlInput.disabled = true;
                      addButton.disabled = true;
                      urlInput.value = '10 images au max !';
                  }
              }
          });
          input.appendChild(addButton);
          const urlList = document.createElement('div'); 
          urlList.id = 'urlList';
          urlList.style.maxHeight = '120px';
          urlList.style.overflow = 'auto';
          formAjout.appendChild(urlList);
      }
      
        break;
      case 'textarea':
        input = document.createElement('textarea');
        break;
      case 'select':
        input = document.createElement('select');
        field.options.forEach(option => {
          const optionElement = document.createElement('option');
          optionElement.value = option;
          optionElement.textContent = option;
          input.appendChild(optionElement);
        });

        if(postType == 'annonce')
          input.value = field.options[1];
        else
          input.value = field.options[0];

        if (field.id === 'newType') {
          input.addEventListener('change', function () {
            let selectedValue = this.value;
            if (selectedValue === 'Actualité') {
              postType = 'actualite';
              replaceForm();

            } else if (selectedValue === 'Annonce') {
              postType = 'annonce';
              replaceForm();
            }
          });
        }
        break;
      case 'select-multiple':
        input = document.createElement('select');
        input.multiple = true;
        input.size = 3;
        field.options.forEach(option => {
          const optionUser = document.createElement('option');
          optionUser.value = option;
          optionUser.textContent = option;
          input.appendChild(optionUser);
        });
        break;
      case 'number':
        input = document.createElement('input');
        input.type = 'number';
        break;
    }
    input.id = field.id;
    input.name = field.id;
    formAjout.appendChild(input);
    formAjout.appendChild(document.createElement('br'));
  });


  /*
   if (modifier) {
      switch (ids[i]) {
        case 'newUrl':
          input.value = modifier.urlImage;
          break;
        case 'newType':
          input.value = modifier.type;
          break;
        case 'newDesc':
          input.value = modifier.desc;
          break;
      }
    }

  */

  let divButton = document.createElement('div');
  divButton.id = 'divButtons';

  let buttonForm = document.createElement('button');
  buttonForm.type = 'submit';
  if (!modifier) {
    buttonForm.id = 'ajouter';
    buttonForm.textContent = 'Ajouter';
  } else {
    buttonForm.id = 'modifier';
    buttonForm.textContent = 'Modifier';
  }

  let buttonCancel = document.createElement('button');
  buttonCancel.type = 'button';
  buttonCancel.id = 'annulerForm';
  buttonCancel.textContent = 'Annuler';

  divButton.appendChild(buttonForm);
  divButton.appendChild(buttonCancel);
  formAjout.appendChild(divButton);

  divAjouter.appendChild(formAjout);

  document.querySelector('main').appendChild(divAjouter);
}

function replaceForm() {
  let formAjout = document.getElementById('divAjouter');
  formAjout.remove();

  btnAjouterPost.click();
}

let btnAjouterPost = document.createElement('button');
btnAjouterPost.textContent = 'Publier';
btnAjouterPost.setAttribute('class', 'btnAjouter');
btnAjouterPost.setAttribute('id', 'ajouterPost');

let sectionBtnFonctions = document.querySelector('.btnFonctions');
sectionBtnFonctions.appendChild(btnAjouterPost);


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

//----------------------------------------------------------------------------------------------------------------------------------------------------


  // Récupérer le champ de saisie du message
let champMessage = document.getElementById("messageInput");

// Ajouter un écouteur d'événements pour la touche "Entrée"
champMessage.addEventListener("keypress", function(e) {
    // Vérifier si la touche "Entrée" a été pressée
    if (e.key === "Enter") {
        // Récupérer le contenu du champ de saisie du message
        let contenuMessage = champMessage.value;

        // Envoyer le message (vous devrez implémenter cette fonction)
        envoyerMessage(contenuMessage);

        // Effacer le champ de saisie après l'envoi du message
        champMessage.value = "";

        // Empêcher le comportement par défaut du bouton "Entrée" qui est de sauter à la ligne
        e.preventDefault();
    }
});

// Fonction pour envoyer le message (à implémenter)
function envoyerMessage(contenuMessage) {
    // Ici, vous pouvez ajouter la logique pour envoyer le message à votre serveur
    // Par exemple, vous pouvez utiliser des requêtes AJAX pour envoyer le message à votre serveur
    // et mettre à jour l'interface utilisateur avec le message envoyé
    console.log("Message envoyé : " + contenuMessage);
}
document.addEventListener("DOMContentLoaded", function() {
  // Récupérer le champ de saisie du message et le bouton d'envoi
  let champMessage = document.getElementById("messageInput");
  let boutonEnvoyer = document.getElementById("envoyerMessageBtn");

  // Ajouter un écouteur d'événements pour les clics sur le bouton d'envoi
  boutonEnvoyer.addEventListener("click", function() {
      envoyerMessage(champMessage.value);
      champMessage.value = ""; // Effacer le champ de saisie après l'envoi du message
  });

  // Ajouter un écouteur d'événements pour les touches pressées dans le champ de saisie du message
  champMessage.addEventListener("keydown", function(e) {
      // Vérifier si la touche "Entrée" a été pressée
      if (e.key === "Enter") {
          // Empêcher le comportement par défaut qui est d'envoyer le message
          e.preventDefault();
          envoyerMessage(champMessage.value);
          champMessage.value = ""; // Effacer le champ de saisie après l'envoi du message
      }
  });

  // Fonction pour envoyer le message (à implémenter)
  function envoyerMessage(contenuMessage) {
      // Ici, vous pouvez ajouter la logique pour envoyer le message à votre serveur
      // Par exemple, vous pouvez utiliser des requêtes AJAX pour envoyer le message à votre serveur
      // et mettre à jour l'interface utilisateur avec le message envoyé
      console.log("Message envoyé : " + contenuMessage);
  }
});
