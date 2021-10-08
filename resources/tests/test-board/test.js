const grid = document.getElementById("grid");

function generateGrid(size) {
    grid.style.setProperty('--grid-size', size);
    for (i = 0; i < (size*size); i++) {
        let cell = document.createElement("div");
        cell.innerText = ("");
        grid.appendChild(cell).className = "cell";
    };
}

generateGrid(5);