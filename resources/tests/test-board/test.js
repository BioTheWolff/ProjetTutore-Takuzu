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
        case "0": cell.innerText = "1";
        break;

        case "1": cell.innerText = "";
        break;

        default: cell.innerText = "0";
    }
}

generateGrid(8);