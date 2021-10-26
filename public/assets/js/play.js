const grid = document.getElementById("grid");

function getSize() {
    let url = window.location.href;
    let pattern = /((?<=size=)[0-9]+)/g;
    let res = url.match(pattern);
    if (res.toString() === "") {
        return 8; // valeur par défaut
    } else {
        return parseInt(res.toString());
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


function changeValue(cell) {
    clearTimeout(timer);
    timer = setTimeout(sendValues, 3000);
    valuesFilled = 0;
    for (let cell of grid.children) {
        cell.classList.remove("wrong");
        if (cell.innerText !== "") valuesFilled++;
    }
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
    let size = grid.style.getPropertyValue('--grid-size');
    let values = size.toString().concat(":");

    for (let i = 0; i < size ** 2; i++) {
        let cell_value = (cells.item(i) == null ? "" : cells.item(i).innerText);
        values = values.concat(cell_value === "" ? "_" : cell_value);
    }
    console.log("\n" + "📨 GRID:   " + values);
    return values;
}

function sendValues() {
    fetch("?action=api-check&message=" + getValues())
        .then(response => response.text())
        .then(data => alertWin(data))
        .catch((error) => alert("Impossible de charger la grille: " + error))
}

function alertWin(data) {
    if (data === "OK") {
        if (parseInt(valuesFilled) === size ** 2) alert("Bravo");
    } else if (data === "NOK") {
        alert("ERREUR");
    } else {
        console.log("❌ ERREUR: " + data);
        highlightErrors(data);
    }
}

function highlightErrors(errors) {
    let errsplit = errors.split(":")[1].split(",");
    if (errsplit[0] === "c") {
        for (let i = parseInt(errsplit[2]); i < size ** 2; i = i + size) {
            cells.item(i).classList.add("wrong");
        }
    } else {
        for (let i = errsplit[1] * size; i < errsplit[1] * size + size; i++) {
            cells.item(i).classList.add("wrong");
        }
    }
}

let valuesFilled = 0;
let cells = document.getElementsByClassName("cell");
let timer = setTimeout(sendValues, 3000);
let size = getSize();
clearTimeout(timer);
downloadAndParseGrid();

