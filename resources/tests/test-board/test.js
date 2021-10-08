const grid = document.getElementById("grid");

function generateGrid(size) {
    grid.style.setProperty('--grid-size', size);
    for (i = 0; i < (size*size); i++) {
        let cell = document.createElement("div");
        cell.innerText = "";
        cell.setAttribute("onclick","changeValue(this)");
        grid.appendChild(cell).className = "cell";
    };
}

function changeValue(cell) {
    switch(cell.innerText) {
        case "0": cell.innerText = "1"; cell.style = "background-color:#ff6b6b";
        break;

        case "1": cell.innerText = ""; cell.style = "background-color:#ffffff";
        break;

        default: cell.innerText = "0"; cell.style = "background-color:#ffe66d";
    }
}

// TODO: function getArray pour obtenir une array de la grille
// Pas d'array 2D en js => arrays imbriquées

generateGrid(8);