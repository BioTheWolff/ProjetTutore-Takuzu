const grid = document.getElementById("grid");
const size = 8;

function generateGrid() {
  grid.style.setProperty('--grid-size', size);
  for (let i = 0; i < (size * size); i++) {
    let cell = document.createElement("div");
    cell.innerText = "";
    cell.setAttribute("onclick", "changeValue(this)");
    grid.appendChild(cell).className = "cell c".concat(i);
  };
}

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

// TODO: function qui call sendValues() après x secondes

// TODO: function qui transfère les values to php avec AJAX

generateGrid(size);
