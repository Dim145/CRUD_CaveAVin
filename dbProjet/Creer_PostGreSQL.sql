DROP TABLE IF EXISTS Categorie   CASCADE;
DROP TABLE IF EXISTS Appellation CASCADE;
DROP TABLE IF EXISTS Oenologue   CASCADE;
DROP TABLE IF EXISTS Bouteille   CASCADE;
DROP TABLE IF EXISTS Degustation CASCADE;
DROP TABLE IF EXISTS Quantite    CASCADE;
DROP TABLE IF EXISTS Cave;


-----------------------------
--                         --
--   CREATION DES TABLES   --
--                         --
-----------------------------

CREATE TABLE Categorie
(
    id_categorie      SERIAL PRIMARY KEY,
    robe_bouteille    VARCHAR(10) CHECK
        (
            robe_bouteille='Rouge' OR
            robe_bouteille='Blanc' OR
            robe_bouteille='Rosé'
        ),
    sucrage_bouteille VARCHAR(20) CHECK
        (
            sucrage_bouteille='Sec'      OR
            sucrage_bouteille='Demi-sec' OR
            sucrage_bouteille='Moelleux' OR
            sucrage_bouteille='Liquoreux'
        ),
    type_bouteille    VARCHAR(20) CHECK
        (
            type_bouteille='Vin tranquille'   OR
            type_bouteille='Vin effervescent' OR
            type_bouteille='Vin doux naturel' OR
            type_bouteille='Vin cuit'
        )
);


CREATE TABLE Appellation
(
    id_appellation        SERIAL PRIMARY KEY,
    nom_appellation       VARCHAR(30) NOT NULL,
    categorie_appellation VARCHAR(20) CHECK
        (
            categorie_appellation='Vin de table' OR
            categorie_appellation='Vin de pays'  OR
            categorie_appellation='AOC/AOP'      OR
            categorie_appellation='IGP'          OR
            categorie_appellation='VDQS'
        )
);


CREATE TABLE Oenologue
(
    id_oenologue  SERIAL PRIMARY KEY,
    nom_oenologue VARCHAR(30) NOT NULL
);


CREATE TABLE Bouteille
(
    id_bouteille        SERIAL PRIMARY KEY,
    nom_bouteille       VARCHAR(50) NOT NULL,
    volume_bouteille    NUMERIC CHECK
        (
            volume_bouteille=37.5 OR volume_bouteille=75   OR volume_bouteille=150  OR
            volume_bouteille=300  OR volume_bouteille=500  OR volume_bouteille=600  OR
            volume_bouteille=900  OR volume_bouteille=1200 OR volume_bouteille=1500 OR
            volume_bouteille=1800
        ),
    millesime_bouteille INT CHECK ( millesime_bouteille > 0 AND millesime_bouteille <= 2099 ), --on considere qu'un vin ne peut avoir plus de 2020 ans
    prix_bouteille      NUMERIC CHECK ( prix_bouteille > 0 ),
    id_categorie        SERIAL REFERENCES Categorie   ON DELETE CASCADE ON UPDATE CASCADE,
    id_appellation      SERIAL REFERENCES Appellation ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT cst_bouteilleUnique UNIQUE( nom_bouteille, volume_bouteille, millesime_bouteille )
);

CREATE TABLE Degustation
(
    id_degustation   SERIAL PRIMARY KEY,
    note_degustation NUMERIC CHECK ( note_degustation>=0 AND note_degustation<=20 ),
    date_degustation DATE NOT NULL,
    id_bouteille     SERIAL REFERENCES Bouteille ON DELETE CASCADE ON UPDATE CASCADE,
    id_oenologue     SERIAL REFERENCES Oenologue ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE Quantite
(
    nom_bouteille       VARCHAR(50),
    volume_bouteille    NUMERIC NOT NULL,
    millesime_bouteille INT CHECK ( millesime_bouteille > 0 AND millesime_bouteille <= 2099 ), --on considere qu'un vin ne peut avoir plus de 2020 ans
    qte_bouteille       INT CHECK ( qte_bouteille >= 0 ),
    FOREIGN KEY (nom_bouteille, volume_bouteille, millesime_bouteille)
        REFERENCES Bouteille(nom_bouteille, volume_bouteille, millesime_bouteille) ON DELETE CASCADE ON UPDATE CASCADE
);