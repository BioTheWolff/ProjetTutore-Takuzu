/*---POPUP---*/
// Ouvre le popup
var popupPartie = document.getElementById("myPopupPartie");
var popupOption = document.getElementById("myPopupOption");

// Récupere le bouton qui ouvre le popup options
var optionButton = document.getElementById("optionBtn");

// Récupere le bouton qui ouvre le popup lancer partie
var playGame = document.getElementById("playGame");

// Récupere l'element <span> qui ouvre le popup options
var spanXPartie = document.getElementsByClassName("close")[0];
var spanXOption = document.getElementsByClassName("close")[1];

//Ouvre la page jeu depuis la page d'accueil en fonction de la taille
function launchGame(taille) {
    let url = "?action=play&size=" + taille;
    window.open(url,"_self");
    if (sonBool){
        audio.currentTime = 0;
        audio.play();
    }
}

// Lorsque l'utilisateur clique sur le bouton option, ça ouvre la popup options
optionButton.onclick = function() {
    // affiche la popup
    popupOption.style.display = "block";
    // désarme les boutons lancer partie et options
    optionButton.disabled = true;
    playGame.disabled = true;
    // vérifie si le son est activé, si oui on lance le son stocké
    if (sonBool){
        audio.currentTime = 0;
        audio.play();
    }
}

// Lorsque l'utilisateur clique sur le bouton lancerPartie, ça ouvre la popup lancer partie
playGame.onclick = function () {
    popupPartie.style.display = "block";
    // désarme les boutons lancer partie et options
    optionButton.disabled = true;
    playGame.disabled = true;
    // vérifie si le son est activé, si oui on lance le son stocké
    if (sonBool){
        audio.currentTime = 0;
        audio.play();
    }
}

// Lorsque l'utilisateur clique sur l'element <span> (x),  ça ferme le popup
spanXPartie.onclick = function() {
    //cache le popup
    popupPartie.style.display = "none";
    // arme les boutons lancer partie et options
    optionButton.disabled = false;
    playGame.disabled = false;
    // vérifie si le son est activé, si oui on lance le son stocké
    if (sonBool){
        audio.currentTime = 0;
        audio.play();
    }
}
// Lorsque l'utilisateur clique sur l'element <span> (x),  ça ferme le popup
spanXOption.onclick = function() {
    //cache le popup
    popupOption.style.display = "none";
    // arme les boutons lancer partie et options
    optionButton.disabled = false;
    playGame.disabled = false;
    // vérifie si le son est activé, si oui on lance le son stocké
    if (sonBool){
        audio.currentTime = 0;
        audio.play();
    }
}