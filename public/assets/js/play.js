// General elements of the document
const grid = document.getElementById("grid");
const backwardBtn = document.getElementById("backward");
const forwardBtn = document.getElementById("forward");
const soluceBtn = document.getElementById("soluce");
const pauseBtn = document.getElementById("pause");

// return grid size from url
function getSize() {
    let url = window.location.href;
    let res = url.match(/((?<=size=)[0-9]+)/g);
    if (res.toString() === "") {
        return 8; // taille par défaut
    } else {
        return parseInt(res.toString());
    }
}

// fetch grid from php api
function downloadAndParseGrid() {
    fetch("?action=api-generate&fillPercentage=0.4&size=" + getSize())
        .then(response => response.text())
        .then(data => {
            console.log(data);
            setupGrid(data.split(":")[0], data.split(":")[1]);
            initialGrid = data;
        })
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

function countValuesFilled() {
    valuesFilled = 0;
    for (let cell of grid.children) {
        cell.classList.remove("wrong");
        if (cell.innerText !== "") valuesFilled++;
    }
}

function changeValue(cell) {

    if (cell.classList.contains("static")) return;

    // count values filled & reset wrong values
    countValuesFilled();

    clearTimeout(timer);
    timer = setTimeout(sendValues, 3000);

    switch (cell.innerText) {
        case "0":
            cell.classList.replace("zero", "one")
            cell.innerText = "1";
            made_action(cell.id, "0", "1");
            break;

        case "1":
            cell.classList.replace("one", "empty")
            cell.innerText = "";
            made_action(cell.id, "1", "");
            break;

        default:
            cell.classList.replace("empty", "zero")
            cell.innerText = "0";
            made_action(cell.id, "", "0");
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

// send values to the php api
function sendValues() {
    fetch("?action=api-check&message=" + getValues())
        .then(response => response.text())
        .then(data => alertWin(data))
        .catch((error) => alert("Impossible de charger la grille: " + error))
}

function alertWin(data) {
    if (data === "OK") {
        if (getValues().search(/_/g) === -1) alert("Bravo");
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

function made_action(cell_id, old_value, new_value) {
    if (!forwardBtn.disabled) {
        // we are in the past time (not at the last action made)
        // rewiring the history
        history = history.slice(0, history_pointer);
    }

    history.push([cell_id, old_value, new_value]);
    history_pointer++;
    refresh_buttons();
}

// backward in grids history
function backward() {
    // cannot read deeper into history
    if (history_pointer < 0) return;

    // decrease pointer to "go back in time"
    // then revert old value
    history_pointer--;
    let change = history[history_pointer];

    set_value_for_cell(change[0], change[1]);

    // count values filled & reset wrong values
    countValuesFilled();

    clearTimeout(timer);
    timer = setTimeout(sendValues, 3000);

    refresh_buttons();
}

// forward in grids history
function forward() {
    // cannot read further into history
    if (history_pointer > history.length - 1) return;

    // re-apply change then increase pointer
    // we are working our way back to "present time"
    let change = history[history_pointer];
    set_value_for_cell(change[0], change[2]);
    history_pointer++;

    // count values filled & reset wrong values
    countValuesFilled();

    clearTimeout(timer);
    timer = setTimeout(sendValues, 3000);

    refresh_buttons();
}

function refresh_buttons() {
    backwardBtn.disabled = history_pointer <= 0;
    forwardBtn.disabled = history_pointer > history.length - 1;
}

function set_value_for_cell(cell_id, value) {
    let cell = document.getElementById(cell_id)
    cell.innerText = value;

    switch (value) {
        case '0':
            cell.classList.remove("one", "empty")
            cell.classList.add("zero")
            break;

        case '1':
            cell.classList.remove("zero", "empty")
            cell.classList.add("one")
            break;

        default:
            cell.classList.remove("one", "zero")
            cell.classList.add("empty")
    }
}

let pause = false;

// get the soluce from the php api
function solve() {
    fetch("?action=api-solve&message=" + initialGrid)
        .then(response => response.text())
        .then(data => displaySoluce(data))
        .catch((error) => alert("Impossible de charger la solution : " + error))
}

// display the soluce for the current grid
function displaySoluce(data) {
    // make it so that no error show up when soluce is displayed
    clearTimeout(timer);
    console.log("⭐ SOLUTION: " + data);
    let sol = data.split(":")[1];
    let i = 0;
    for (let cell of grid.children) {
        cell.classList.remove("wrong");
        cell.classList.add("static");
        cell.style = "background-color:#e6ee9c"
        cell.textContent = sol[i];
        i++;
    }
    // disable all buttons
    soluceBtn.disabled = true;
    backwardBtn.disabled = true;
    forwardBtn.disabled = true;
    pauseBtn.disabled = true;


    pause = true;
    setTime();
}

// general values bound to be changed
let cells = document.getElementsByClassName("cell");
let size = getSize();
let valuesFilled = 0;
let initialGrid = "";

// timer for sending grids to api
let timer = setTimeout(sendValues, 3000);
clearTimeout(timer);

// grid history
let history = [];
let history_pointer = 0;

// buttons disabled by default
backwardBtn.disabled = true;
forwardBtn.disabled = true;

downloadAndParseGrid();



/*TIMER*/
var heuresLabel = document.getElementById("heures");
var minutesLabel = document.getElementById("minutes");
var secondesLabel = document.getElementById("secondes");
var totalSecondes = 0;
setInterval(setTime, 1000);

/*POPUP*/
let popupContainer = document.getElementById("popup-container");
var pauseMenuPopup = document.getElementById("myPopupOption");
var depause = document.getElementById("depause");


pauseBtn.onclick = () => {showPopup(pauseMenuPopup); pause = true; setTime();}
depause.onclick = () => {hidePopup(pauseMenuPopup); pause = false; setTime();}



function setTime()
{
    if (pause === false) { // jeu pas en pause
        ++totalSecondes;
    }
    secondesLabel.innerHTML = pad(totalSecondes%60);
    minutesLabel.innerHTML = pad(parseInt(totalSecondes/60));
    heuresLabel.innerHTML = pad(parseInt(totalSecondes/3600));
}

function pad(val)
{
    var valString = val + "";
    if(valString.length < 2)
    {
        return "0" + valString;
    }
    else
    {
        return valString;
    }
}


let nameRules = document.getElementById("nameRules");
let suite = document.getElementById("suite");
let multiplicite = document.getElementById("multiplicite");
let pattern = document.getElementById("pattern");

function ukRules(){
    nameRules.textContent = nameRules.textContent.replace(nameRules.textContent, "📜 Rules");

    suite.textContent = suite.textContent.replace(suite.textContent, "You can't have the same number three times in a row");
    multiplicite.textContent = multiplicite.textContent.replace(multiplicite.textContent, "You must have the same number of 0's and 1's in a row / column");
    pattern.textContent = pattern.textContent.replace(pattern.textContent, "You cannot have the same pattern in different rows / columns");
}

function frRules(){
    nameRules.textContent = nameRules.textContent.replace(nameRules.textContent, "📜 Règles");

    suite.textContent = suite.textContent.replace(suite.textContent, "Vous ne pouvez pas avoir trois fois le même numéro à la suite");
    multiplicite.textContent = multiplicite.textContent.replace(multiplicite.textContent, "Vous devez avoir le même nombre de 0 et 1 dans une ligne/colonne");
    pattern.textContent = pattern.textContent.replace(pattern.textContent, "Vous ne pouvez pas avoir le même motif dans différentes lignes/colonnes");
}
