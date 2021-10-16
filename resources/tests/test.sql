-----------------------------------------
-- TEST DE CRÉATION DE LA BD DE TAKUZU --
-----------------------------------------


-- RESET DE LA BD

-- Supression des tables pré-existantes
DROP TABLE grilles CASCADE CONSTRAINTS;
DROP TABLE scoreboard CASCADE CONSTRAINTS;


-- CRÉATION DES TABLES

-- Création de la table contenant les grilles
CREATE TABLE Grilles (
  id NUMBER,
  difficulte NUMBER NOT NULL,
  taille NUMBER NOT NULL,
  grille JSON NOT NULL,
  grille_sol JSON NOT NULL,
  CONSTRAINT pk_grille PRIMARY KEY (id)
);

-- Création de la table contenant les scores
CREATE TABLE Scoreboard (
  id_score NUMBER,
  name VARCHAR(16),
  score NUMBER,
  id_grille NUMBER,
  CONSTRAINT pk_scoreboard PRIMARY KEY (id_score),
  CONSTRAINT fk_idGrille FOREIGN KEY (id_grille) REFERENCES Grilles(id)
);


-- CRÉATION PROCÉDURES

CREATE OR REPLACE PROCEDURE AjouterGrille (
  p_difficulte Grilles.difficulte%TYPE,
  p_taille Grilles.taille%TYPE,
  p_grille Grilles.grille%TYPE,
  p_grile_sol Grilles.grille_sol%TYPE
) IS
  countGrilles INTEGER;
BEGIN
  SELECT COUNT(id) INTO countGrilles FROM Grilles;
  INSERT INTO Grilles VALUES (countGrilles + 1, p_difficulte, p_taille, p_grille, p_grile_sol);
END;


-- INSERTION DES GRILLES DE TEST

-- (20minutes.fr grille n2024)
INSERT INTO Grilles VALUES (0, 0, 8,
  '[["GAP", "GAP", "GAP", "GAP", "GAP", "GAP", "GAP", "GAP"],
    [  "1", "GAP", "GAP", "GAP", "GAP", "GAP", "GAP", "GAP"],
    ["GAP", "GAP", "GAP",   "0", "GAP",   "1", "GAP", "GAP"],
    ["GAP", "GAP", "GAP",   "0", "GAP", "GAP",   "0",   "0"],
    ["GAP", "GAP", "GAP", "GAP", "GAP", "GAP",   "0", "GAP"],
    [  "1", "GAP", "GAP", "GAP", "GAP", "GAP", "GAP", "GAP"],
    [  "1",   "1", "GAP", "GAP", "GAP", "GAP", "GAP", "GAP"],
    ["GAP", "GAP",   "0", "GAP", "GAP", "GAP", "GAP", "GAP"]]
  ',
  '[[  "0",   "0",   "1",   "1",   "0",   "0",   "1",   "1"],
    [  "1",   "0",   "0",   "1",   "1",   "0",   "0",   "1"],
    [  "0",   "1",   "1",   "0",   "0",   "1",   "1",   "0"],
    [  "1",   "0",   "1",   "0",   "1",   "1",   "0",   "0"],
    [  "0",   "1",   "0",   "1",   "1",   "0",   "0",   "1"],
    [  "1",   "0",   "1",   "0",   "0",   "1",   "1",   "0"],
    [  "1",   "1",   "0",   "0",   "1",   "0",   "0",   "1"],
    [  "0",   "1",   "0",   "1",   "0",   "1",   "1",   "0"]]
  '
);

COMMIT;
