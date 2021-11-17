<div id="play">
    <!-- Regles -->
    <div id="regles">
        <div id="changerLangue">
            <h2 id="nameRules">📜 Règles</h2>
            <button id="fr" type="submit" class="buttonsLangues" onclick="frRules()">
                <img id="frImage" src="assets/img/fr_flag.png" alt="mettre en français">
            </button>
            <button id="uk" type="submit" class="buttonsLangues" onclick="ukRules()">
                <img id="ukImage" src="assets/img/uk_flag.png" alt="mettre en anglais">
            </button>
        </div>
        <ul id="reglesEcrites">
            <li id="suite">Vous ne pouvez pas avoir trois fois le même numéro à la suite</li>
            <li id="multiplicite">Vous devez avoir le même nombre de 0 et 1 dans une ligne/colonne</li>
            <li id="pattern">Vous ne pouvez pas avoir le même motif dans différentes lignes/colonnes</li>
        </ul>
    </div>

    <!-- La grille en HTML est générée par le js -->
    <div id="grid"></div>


    <!-- Option Jeu -->
    <div id="actions">
        <h2>⚙️ Options</h2>
        <div id="actionGrille">
            <button type="button" id="backward" onclick="backward()" class="buttons">
                <img id="backwardImage" src="assets/img/backward.png" alt="revenir en arrière">
            </button>
            <button type="button" id="soluce" onclick="solve()" class="buttons">
                <img id="solutionImage" src="assets/img/magic-wand.png" alt="afficher la solution">
            </button>
            <button type="button" id="forward" onclick="forward()" class="buttons">
                <img id="forwardImage" src="assets/img/forward.png" alt="aller en avant">
            </button>
        </div>

        <!-- Option Audio -->
        <div id="actionPartie">
            <button id="boucle" type="button" class="buttons" onclick="window.location.reload()">
                <img id="boucleImage" src="assets/img/boucle.png" alt="relancer la partie du début">
            </button>
            <button id="pause" type="button" class="buttons" onclick="pauseGame()">
                <img id="pauseImage" src="assets/img/pause.png" alt="mettre en pause">
            </button>
        </div>


        <!-- Option Audio -->
        <div class="optionAudio">
            <h2>🎧 Audio</h2>
            <button id="sonButton" type="button" class="buttons">
                <img id="sonImage" src="assets/img/son-sur.png">
            </button>
            <button id="musicButton" type="button" class="buttons">
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

    <!-- POP UP PAUSE MENU -->
    <div id="myPopupOption" class="popup">
        <!-- Contenu du POP UP-->
        <div class="popup-content">
            <div class="popup-header">
                <h2>Pause</h2>
            </div>
            <div class="popup-body">
                <button id="home" type="button" class="buttons" onclick="goHome()">
                    <img id="homeImage" src="assets/img/home.png" alt="Revenir à la page d'acceuil">
                </button>
                <button id="boucle2" type="button" class="buttons" onclick="window.location.reload()">
                    <img id="boucleImage" src="assets/img/boucle.png" alt="recommencer la partie du début">
                </button>
                <button id="depause" type="button" class="buttons" onclick="depauseGame()">
                    <img id="depauseImage" src="assets/img/play.png" alt="continuer la partie">
                </button>
            </div>
        </div>
    </div>
</div>

<!-- TIMER -->
<div id="timerDiv" class="timer">
    <h2>Timer</h2>
    <label id="heures">00</label>
    <label id="colon">:</label>
    <label id="minutes">00</label>
    <label id="colon">:</label>
    <label id="secondes">00</label>
</div>



<script type="text/javascript" src="assets/js/play.js"></script>
