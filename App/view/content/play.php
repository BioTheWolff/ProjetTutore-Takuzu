<!-- Regles -->
<div id="regles">
    <div id="changerLangue">
        <button id="fr" type="submit" class="buttonsLangues">
            <img id="frImage" src="assets/img/fr_flag.png" alt="mettre en français">
        </button>
        <button id="uk" type="submit" class="buttonsLangues">
            <img id="ukImage" src="assets/img/uk_flag.png" alt="mettre en anglais">
        </button>
    </div>
    <h2>📜 Règles</h2>
    <ul id="reglesEcrites">
        <li>Vous ne pouvez pas avoir trois fois le même numéro à la suite</li>
        <li>Vous devez avoir le même nombre de 0 et 1 dans une ligne/colonne</li>
        <li>Vous ne pouvez pas avoir le même motif dans différentes lignes/colonnes</li>
    </ul>
</div>

<!-- La grille en HTML est générée par le js -->
<div id="grid"></div>

<!-- Option Jeu -->
<div id="actions">
    <h2>⚙️ Options</h2>
    <div id="actionGrille">
        <button id="backward" type="submit" class="buttons">
            <img id="backwardImage" src="assets/img/backward.png" alt="revenir en arrière">
        </button>
        <button id="solution" type="submit" class="buttons">
            <img id="solutionImage" src="assets/img/magic-wand.png" alt="afficher la solution">
        </button>
        <button id="forward" type="submit" class="buttons">
            <img id="forwardImage" src="assets/img/forward.png" alt="aller en avant">
        </button>
    </div>

    <!-- Option Audio -->
    <div id="actionPartie">
        <button id="boucle" type="submit" class="buttons">
            <img id="boucleImage" src="assets/img/boucle.png" alt="relancer la partie du début">
        </button>
        <button id="pause" type="submit" class="buttons">
            <img id="pauseImage" src="assets/img/pause.png" alt="mettre en pause">
        </button>
    </div>


    <!-- Option Audio -->
    <div class="optionAudio">
        <h2>🎧 Audio</h2>
        <button id="sonButton" type="submit" class="buttons">
            <img id="sonImage" src="assets/img/son-sur.png">
        </button>
        <button id="musicButton" type="submit" class="buttons">
            <img id="musicImage" src="assets/img/musicOff.png" alt="mettre/couper la musique">
        </button>
        <audio controls="" id="son" style="display: none;">
            <source  src="assets/music/warning_pulse.mp3" type="audio/mpeg" volume="50" loop="false" autostart="false">
            Votre navigateur ne supporte pas la balise audio.
        </audio>
        <audio controls="" id="musique" style="display: none;">
            <source  src="assets/music/music.mp3" type="audio/mpeg" volume="50" loop="true" autostart="false">
            Votre navigateur ne supporte pas la balise audio.
        </audio>
    </div>
</div>



<script type="text/javascript" src="assets/js/play.js"></script>
