<div id="page_accueil">
    <div class="accueil_logo">
        <img src="assets/img/Yuzu.png">
    </div>
    <div class="accueil_section">
        <div class="buttons-container">
            <button id="playGame" type="submit" class="outline">Lancer une partie</button>
            <button id="optionBtn" type="submit" class="outline">Options</button>

            <!-- POP UP -->
            <div id="popup-container">
                <div id="myPopupPartie" class="popup">
                    <!-- Contenu du POP UP-->
                    <div class="popup-content">
                        <div class="popup-header">
                            <span class="close">&times;</span>
                            <h2>Lancer une partie</h2>
                        </div>
                        <div class="popup-body">
                            <h3>Choisissez de la difficulté de la partie</h3>
                            <button class="outline" onclick="launchGame('easy')">Facile</button>
                            <button class="outline" onclick="launchGame('medium')">Moyen</button>
                            <button class="outline" onclick="launchGame('hard')">Difficile</button>
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
                            <h3>Audio</h3>
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
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript" src="assets/js/index.js"></script>

