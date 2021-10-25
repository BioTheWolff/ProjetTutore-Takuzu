const grid = document.getElementById("grid");

function getSize() {
    let url = window.location.href;
    let pattern = /((?<=size=)[0-9]+)/g;
    let res = url.match(pattern);
    if (res === "") {
        return 8; // valeur par défaut
    } else {
        return parseInt(res);
    }
}

function downloadAndParseGrid() {
    fetch("?action=api-generate&size=" + getSize())
        .then(response => response.text())
        .then(data => setupGrid(data.split(":")[0], data.split(":")[1]))
        .catch((error) => alert("Impossible de charger la grille: " + error))
}


function setupGrid(size, content) {
    generateEmptyGrid(size);

    /** @type {string[]} **/
    let arr = Array.from(content);

    for (let cell of grid.children) {
        switch (arr[cell.id]) {
            case "_":
                break;
            case "0":
                cell.classList.replace("empty", "zero");
                cell.classList.add("static");
                cell.textContent = "0";
                break;

            case "1":
                cell.classList.replace("empty", "one");
                cell.classList.add("static");
                cell.textContent = "1";
                break;
        }
    }
}

function generateEmptyGrid(size) {
    grid.style.setProperty('--grid-size', size.toString());
    for (let i = 0; i < size ** 2; i++) {
        let cell = document.createElement("div");
        cell.innerText = "";
        cell.setAttribute("onclick", "changeValue(this)");
        cell.id = i.toString();
        cell.classList.add("cell", "empty")
        grid.appendChild(cell);
    }
}

// TODO: function qui entre les valeurs de getGrid() dans la grid vide

function changeValue(cell) {
    if (cell.classList.contains("static")) return;

    switch (cell.innerText) {
        case "0":
            cell.classList.replace("zero", "one")
            cell.innerText = "1";
            cell.style = "background-color:#ff6b6b";
            break;

        case "1":
            cell.classList.replace("one", "empty")
            cell.innerText = "";
            cell.style = "background-color:#ffffff";
            break;

        default:
            cell.classList.replace("empty", "zero")
            cell.innerText = "0";
            cell.style = "background-color:#ffe66d";
    }
}

function getValues() {
    let cells = document.getElementsByClassName("cell");
    let size = grid.style.getPropertyValue('--grid-size');
    let values = size.toString().concat(":");

    for (let i = 0; i < size ** 2; i++) {
        let cell_value = cells.item(i).innerText;
        values = values.concat(cell_value === "" ? "_" : cell_value);
    }
    console.log(values);
    return values;
}

// TODO: function sendValues() qui transfère les values to php avec AJAX

// TODO: function qui call sendValues() après x secondes

downloadAndParseGrid();

