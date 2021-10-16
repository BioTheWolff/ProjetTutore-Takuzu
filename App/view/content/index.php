<div id="page_accueil">
    <div class="accueil_logo">
        <img src="assets/img/Takuzu.png">
    </div>
    <div class="accueil_section">
        <div class="container">
            <button id="playGame" type="submit" class="outline">Lancer une partie</button>
            <button id="myBtn" type="submit" class="outline">Options</button>

            <!-- POP UP -->
            <div id="myModal" class="modal">

            <!-- Contenu du POP UP -->
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Options</h2>
                </div>
                <div class="modal-body">
                    <h3>Son des touches</h3>
                    <button id="son" type="submit" class="sonButt">
                        <img id="sonImage" src="assets/img/son-sur.png">
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


