// Résupère dans la variable son, l'élément dont l'id est "son"
var sonButton = document.getElementById("sonButton");

// créer un nouveau booleen
var sonBool = Boolean(sonButton);

// Résupère dans la variable son, l'élément dont l'id est "son"
var musicButton = document.getElementById("musicButton");

// créer un nouveau booleen
var musicBool = Boolean(musicButton);

// stock les audio dans des constantes
const audio = document.getElementById('son');
const musique = document.getElementById('musique');

// lance l'audio
audio.load();

// fonction qui change l'image du bouton de son
sonButton.onclick = function (){
    sonBool = !sonBool;
    if (!sonBool){
        // le son est éteint
        document.getElementById("sonImage").src= "assets/img/son-eteint.png";
    }
    else {
        // le son est allumé
        document.getElementById("sonImage").src= "assets/img/son-sur.png";
        if (sonBool){
            audio.currentTime = 0;
            audio.play();
        }
    }
}

// fonction qui change l'image du bouton de son
musicButton.onclick = function (){
    musicBool = !musicBool;
    if (!musicBool){
        // le son est éteint
        document.getElementById("musicImage").src= "assets/img/music.png";
        if (sonBool){
            audio.currentTime = 0;
            audio.play();
        }
        musique.play();
    }
    else {
        // le son est allumé
        document.getElementById("musicImage").src= "assets/img/musicOff.png";
        musique.pause();
        if (sonBool){
            audio.currentTime = 0;
            audio.play();
        }
    }
}