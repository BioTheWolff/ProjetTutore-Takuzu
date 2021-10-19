// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

var playGame = document.getElementById("playGame");

var son = document.getElementById("son");
var sonBool = Boolean(son);

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

const audio = document.querySelector('audio');

audio.load();

// When the user clicks the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
    btn.style.visibility = "hidden";
    playGame.style.visibility = "hidden";
    if (sonBool){
        audio.currentTime = 0;
        audio.play();
    }
}

playGame.onclick = function (){
    if (sonBool){
        audio.currentTime = 0;
        audio.play();
    }
}

son.onclick = function (){
    sonBool = !sonBool;
    if (!sonBool){
        document.getElementById("sonImage").src= "assets/img/son-eteint.png";
    }
    else {
        document.getElementById("sonImage").src= "assets/img/son-sur.png";
    }
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
    btn.style.visibility = "visible";
    playGame.style.visibility = "visible";
    if (sonBool){
        audio.currentTime = 0;
        audio.play();
    }
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
        btn.style.visibility = "visible";
        playGame.style.visibility = "visible";
    }
}