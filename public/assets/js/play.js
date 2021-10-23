const grid = document.getElementById("grid");

function getSize() {
  let s = window.location.href.replace(/.*size=([0-9]).*/, "");
  if (s == "") {
    return 8; // valeur par défaut
  } else {
    return parseInt(s);
  }
}

function getGrid(size) {
  var xmlhttp = new XMLHttpRequest();
  let g = "";
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      g = this.responseText;
    }
  };
  xmlhttp.open("GET", "?action=api-generate&size=" + size, true);
  xmlhttp.send();
  return g;
}

function generateEmptyGrid() {
  grid.style.setProperty('--grid-size', size);
  for (let i = 0; i < size ** 2; i++) {
    let cell = document.createElement("div");
    cell.innerText = "";
    cell.setAttribute("onclick", "changeValue(this)");
    grid.appendChild(cell).className = "cell c".concat(i);
  };
}

// TODO: function qui entre les valeurs de getGrid() dans la grid vide

function changeValue(cell) {
  switch (cell.innerText) {
    case "0": cell.innerText = "1"; cell.style = "background-color:#ff6b6b"; getValues();
      break;

    case "1": cell.innerText = ""; cell.style = "background-color:#ffffff"; getValues();
      break;

    default: cell.innerText = "0"; cell.style = "background-color:#ffe66d"; getValues();
  }
}

function getValues() {
  let cells = document.getElementsByClassName("cell");
  let values = size.toString().concat(":");
  for (let i = 0; i < size ** 2; i++) {
    let cell_value = cells.item(i).innerText;
    values = values.concat(cell_value == "" ? "_" : cell_value);
  }
  console.log(values);
  return values;
}

// TODO: function sendValues() qui transfère les values to php avec AJAX

// TODO: function qui call sendValues() après x secondes

let size = getSize();
let gridString = getGrid();
generateEmptyGrid(size);

