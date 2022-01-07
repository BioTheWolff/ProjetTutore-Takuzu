/*---POPUP---*/
// Ouvre le popup
let popupContainer = document.getElementById("popup-container");
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
function launchGame(difficulty) {
    let url = "?action=play&difficulty=" + difficulty;
    window.open(url,"_self");
    checkSound();
}



optionButton.onclick = () => showPopup(popupOption);
playGame.onclick = () => showPopup(popupPartie);

spanXPartie.onclick = () => hidePopup(popupPartie);
spanXOption.onclick = () => hidePopup(popupOption);