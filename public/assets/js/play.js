const grid = document.getElementById("grid");
const backwardBtn = document.getElementById("backward");
const forwardBtn = document.getElementById("forward");

// return grid size from url
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

// fetch grid from php api
function downloadAndParseGrid() {
    fetch("?action=api-generate&size=" + getSize())
        .then(response => response.text())
        .then(data => fillGrid(data.split(":")[0], data.split(":")[1], true))
        .catch((error) => alert("Impossible de charger la grille: " + error))
}

// create an empty html grid
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

// fill-in values in the grid
function fillGrid(size, content, init = false) {
    if (grid.children.length == 0) {
        generateEmptyGrid(size);
    }

    /** @type {string[]} **/
    let arr = Array.from(content);

    // TODO: do something about statics, maybe new function for init grid or if
    if (init == true) {
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
    } else {
        for (let cell of grid.children) {
            if (!cell.classList.contains("static"))
                switch (arr[cell.id]) {
                    case "_":
                        cell.classList.replace("zero", "empty");
                        cell.classList.replace("one", "empty");
                        cell.textContent = "";
                        break;
                    case "0":
                        cell.classList.replace("empty", "zero");
                        cell.classList.replace("one", "zero");
                        cell.textContent = "0";
                        break;
                    case "1":
                        cell.classList.replace("empty", "one");
                        cell.classList.replace("zero", "one");
                        cell.textContent = "1";
                        break;
                }
        }
    }
}

// change value of a cell when clicked
function changeValue(cell) {
    valuesFilled = 0;
    for (let cell of grid.children) {
        cell.classList.remove("wrong");
        if (cell.innerText !== "") valuesFilled++;
    }

    if (cell.classList.contains("static")) return;
    clearTimeout(timer);
    timer = setTimeout(sendValues, 3000);

    currGrid = getValues();
    backwardGrids.push(currGrid);
    switch (cell.innerText) {
        case "0":
            cell.classList.replace("zero", "one")
            cell.innerText = "1";
            break;

        case "1":
            cell.classList.replace("one", "empty")
            cell.innerText = "";
            break;

        default:
            cell.classList.replace("empty", "zero")
            cell.innerText = "0";
    }
    backwardBtn.disabled = false;
}

// return values from the grid
function getValues() {
    let values = "";
    for (let i = 0; i < size ** 2; i++) {
        let cell_value = (cells.item(i) == null ? "" : cells.item(i).innerText);
        values = values.concat(cell_value === "" ? "_" : cell_value);
    }
    return values;
}

// return gridd with values and proper formating for api
function getGrid() {
    let size = grid.style.getPropertyValue('--grid-size');
    let gridStr = size.toString().concat(":").concat(getValues());
    console.log("\n" + "📨 GRID:   " + gridStr);
    return gridStr;
}

// send values to the php api
function sendValues() {
    fetch("?action=api-check&message=" + getGrid())
        .then(response => response.text())
        .then(data => alertWin(data))
        .catch((error) => alert("Impossible de charger la grille: " + error))
}

// show if game is won or if there are errors
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

// apply colors to the grid to show errors
function highlightErrors(errors) {
    let errsplit = errors.split(":");
    if (errsplit[1] === "c") {
        for (let i = parseInt(errsplit[3]); i < size ** 2; i = i + size) {
            cells.item(i).classList.add("wrong");
        }
    } else {
        for (let i = errsplit[2] * size; i < errsplit[2] * size + size; i++) {
            cells.item(i).classList.add("wrong");
        }
    }
}

// backward in grids history
function backward() {
    // add previous grid to forwardGrids
    forwardBtn.disabled = false;
    currGrid = getValues();
    forwardGrids.push(currGrid);

    // update currGrid by taking latest grid from backwardGrids
    currGrid = backwardGrids.pop();
    fillGrid(size, currGrid);

    // disable btn if backward is impossible
    if (backwardGrids.length == 0) backwardBtn.disabled = true;
}

// forward in grids history
function forward() {
    // add previous grid to backwardGrids
    backwardBtn.disabled = false;
    currGrid = getValues();
    backwardGrids.push(currGrid);

    // update currGrid by taking latest grid from backwardGrids
    currGrid = forwardGrids.pop();
    fillGrid(size, currGrid);

    // disable btn if forward is impossible
    if (forwardGrids.length == 0) forwardBtn.disabled = true;
}

let valuesFilled = 0;
let cells = document.getElementsByClassName("cell");
let size = getSize();

// timer for sending grids to api
let timer = setTimeout(sendValues, 3000);
clearTimeout(timer);

// grid history
let backwardGrids = [];
let forwardGrids = [];
let currGrid = "";

// buttons disabled
backwardBtn.disabled = true;
forwardBtn.disabled = true;

downloadAndParseGrid();

