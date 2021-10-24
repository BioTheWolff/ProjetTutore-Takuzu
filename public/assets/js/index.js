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

function launchGame(number) {
    var url = "http://localhost/projettutore-takuzu/public/?action=play&size=" + number;
    window.open(url,"_self");
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



/*
----FERME LE POPUP SI ON CLIQUE SUR LES BOUTONS QUI SONT DANS LE POPUP----
//TODO

// Lorsque l'utilisateur clique en dehors de la popup, ça ferme le popup
document.addEventListener('mouseup', function(e) {
    // Récupere le container où il y a la classe 'popup'
    var containerPartie = document.getElementsByClassName('popup')[0];
    var containerOption = document.getElementsByClassName('popup')[1];
    // vérifie la target est la popup, si cela ne l'est plus, on retire la popup option
    if (!containerPartie.contains(e.target) || !containerOption.contains(e.target)) {
        containerPartie.style.display = 'none';
        containerOption.style.display = 'none';
        optionButton.style.visibility = "visible";
        playGame.style.visibility = "visible";
    }
});
*/
