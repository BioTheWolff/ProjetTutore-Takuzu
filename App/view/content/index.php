<div id="page_accueil">
    <div class="accueil_logo">
        <img src="assets/img/Takuzu.png">
    </div>
    <div class="accueil_section">
        <div class="container">
            <button id="playGame" type="submit" class="outline">Lancer une partie</button>
            <button id="optionBtn" type="submit" class="outline">Options</button>

            <!-- POP UP -->
            <div id="myPopupPartie" class="popup">
                <!-- Contenu du POP UP-->
                <div class="popup-content">
                    <div class="popup-header">
                        <span class="close">&times;</span>
                        <h2>Choix de la taille de la grille</h2>
                    </div>
                    <div class="popup-body">
                        <button id="8" type="submit" class="outline"> 8x8 </button>
                        <button id="10" type="submit" class="outline"> 10x10 </button>
                        <button id="12" type="submit" class="outline"> 12x12 </button>
                    </div>
                </div>
            </div>

            <!-- POP UP -->
            <div id="myPopupOption" class="popup">
                <!-- Contenu du POP UP-->
                <div class="popup-content">
                    <div class="popup-header">
                        <span class="close">&times;</span>
                        <h2>Options</h2>
                    </div>
                    <div class="popup-body">
                        <h3>Son des boutons</h3>
                        <button id="sonButton" type="submit" class="sonButt">
                            <img id="sonImage" src="assets/img/son-sur.png">
                        </button>
                        <button id="musicButton" type="submit" class="sonButt">
                            <span class="material-icons-outlined"><img id="sonImage" src="assets/img/audiotrack.png"></span>
                        </button>
                        <audio>
                            <source controls src="assets/music/warning_pulse.mp3" type="audio/mpeg" volume="50" loop="false" autostart="false">
                            Votre navigateur ne supporte pas la balise audio.
                        </audio>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="assets/js/index.js"></script>

