--Table globale, contient les insertions dans le fichier init puis une fois que toute les tables ont recuperé ses données elle est drop
CREATE TABLE Cave
(
    nom_bouteille         VARCHAR(50) NOT NULL,
    volume_bouteille      NUMERIC CHECK
        (
            volume_bouteille = 37.5 OR volume_bouteille = 75 OR volume_bouteille = 150 OR
            volume_bouteille = 300 OR volume_bouteille = 500 OR volume_bouteille = 600 OR
            volume_bouteille = 900 OR volume_bouteille = 1200 OR volume_bouteille = 1500 OR
            volume_bouteille = 1800
        ),
    millesime_bouteille   INT CHECK ( millesime_bouteille > 0 AND millesime_bouteille <= 2099 ), --on considere qu'un vin ne peut avoir plus de 2020 ans
    prix_bouteille        INT CHECK ( prix_bouteille > 0 ),
    qte_bouteille         INT CHECK ( qte_bouteille >= 0 ),
    robe_bouteille        VARCHAR(10) CHECK
        (
            robe_bouteille = 'Rouge' OR
            robe_bouteille = 'Blanc' OR
            robe_bouteille = 'Rosé'
        ),
    sucrage_bouteille     VARCHAR(20) CHECK
        (
            sucrage_bouteille = 'Sec' OR
            sucrage_bouteille = 'Demi-sec' OR
            sucrage_bouteille = 'Moelleux' OR
            sucrage_bouteille = 'Liquoreux'
        ),
    type_bouteille        VARCHAR(20) CHECK
        (
            type_bouteille = 'Vin tranquille' OR
            type_bouteille = 'Vin effervescent' OR
            type_bouteille = 'Vin doux naturel' OR
            type_bouteille = 'Vin cuit'
        ),
    nom_appellation       VARCHAR(30) NOT NULL,
    categorie_appellation VARCHAR(20) CHECK
        (
            categorie_appellation = 'Vin de table' OR
            categorie_appellation = 'Vin de pays' OR
            categorie_appellation = 'AOC/AOP' OR
            categorie_appellation = 'IGP' OR
            categorie_appellation = 'VDQS'
        ),
    nom_oenologue     VARCHAR(30) NOT NULL,
    note_degustation      NUMERIC CHECK ( note_degustation >= 0 AND note_degustation <= 20 ),
    date_degustation  DATE NOT NULL
);

---------------------------------------------------------------
--                                                           --
--   INSERTION DES VALEURS DANS LA TABLE DE REGROUPEMENENT   --
--                                                           --
---------------------------------------------------------------



INSERT INTO Cave VALUES('Chenin Blanc'                         , 75  , 2016, 4.55  , 3 , 'Blanc', 'Sec'      , 'Vin tranquille'    , 'Sauvignon'          , 'Vin de pays' , 'Kevin Kary'            , 8   , '2018-09-24');
INSERT INTO Cave VALUES('Entre deux Mers'                      , 150 , 2014, 7.80  , 82, 'Blanc', 'Demi-sec' , 'Vin tranquille'    , 'Pinot Blanc'        , 'Vin de pays' , 'Elie Yaffa'            , 14  , '2017-06-14');
INSERT INTO Cave VALUES('Paraje Casa del Titere'               , 75  , 2014, 14.50 , 85, 'Blanc', 'Liquoreux', 'Vin effervescent'  , 'Traminette'         , 'AOC/AOP'     , 'Kerry James'           , 16.3, '2016-11-20');
INSERT INTO Cave VALUES('Mariposa'                             , 37.5, 2010, 8.20  , 5 , 'Blanc', 'Moelleux' , 'Vin doux naturel'  , 'Chardonnay '        , 'IGP'         , 'Elie Yaffa'            , 7.2 , '2014-10-15');
INSERT INTO Cave VALUES('Reserve Sandstone'                    , 150 , 1998, 31.30 , 41, 'Blanc', 'Demi-sec' , 'Vin effervescent'  , 'Traminette'         , 'Vin de table', 'Julien Mari'           , 13  , '2015-01-29');
INSERT INTO Cave VALUES('Blanc Essence'                        , 300 , 1997, 40.8  , 11, 'Blanc', 'Liquoreux', 'Vin doux naturel'  , 'Traminette'         , 'Vin de table', 'Médine Zaouiche'       , 14.6, '2000-02-01');
INSERT INTO Cave VALUES('Mariposa'                             , 500 , 2011, 58    , 14, 'Blanc', 'Demi-sec' , 'Vin doux naturel'  , 'Chardonnay '        , 'VDQS'        , 'Kerry James'           , 11.5, '2014-06-08');
INSERT INTO Cave VALUES('Beachcomber'                          , 1800, 1934, 299.99, 2 , 'Blanc', 'Liquoreux', 'Vin effervescent'  , 'Pinot Gris'         , 'IGP'         , 'Médine Zaouiche'       , 19.8, '1997-08-12');
INSERT INTO Cave VALUES('Beachcomber'                          , 1200, 2016, 43.99 , 1 , 'Blanc', 'Liquoreux', 'Vin doux naturel'  , 'Pinot Gris'         , 'Vin de pays' , 'Kerry James'           , 9.4 , '2018-09-05');
INSERT INTO Cave VALUES('The Reserve'                          , 150 , 1998, 90    , 85, 'Blanc', 'Demi-sec' , 'Vin effervescent'  , 'Chardonnay '        , 'AOC/AOP'     , 'Médine Zaouiche'       , 14.9, '2006-12-26');
INSERT INTO Cave VALUES('The Reserve'                          , 150 , 1987, 35.99 , 23, 'Blanc', 'Demi-sec' , 'Vin effervescent'  , 'Chardonnay'         , 'IGP'         , 'Julien Mari'           , 16  , '2001-01-28');
INSERT INTO Cave VALUES('Blanc Essence'                        , 37.5, 1894, 99.80 , 0 , 'Blanc', 'Moelleux' , 'Vin effervescent'  , 'Pinot Blanc'        , 'Vin de pays' , 'Julien Mari'           , 9   , '1995-01-07');
INSERT INTO Cave VALUES('Entre deux Mers'                      , 900 , 2014, 82.80 , 58, 'Blanc', 'Moelleux' , 'Vin cuit'          , 'Pinot Blanc'        , 'AOC/AOP'     , 'Julien Mari'           , 12  , '2019-01-01');
INSERT INTO Cave VALUES('Entre deux Mers'                      , 300 , 2011, 45.50 , 97, 'Blanc', 'Moelleux' , 'Vin cuit'          , 'Pinot Blanc'        , 'VDQS'        , 'Okou Gnakouri'         , 5.8 , '2019-04-06');
INSERT INTO Cave VALUES('Fleur De Lys'                         , 1800, 2011, 199.99, 3 , 'Blanc', 'Moelleux' , 'Vin effervescent'  , 'Vin de Savoie'      , 'VDQS'        , 'Okou Gnakouri'         , 13.8, '2016-06-18');
INSERT INTO Cave VALUES('Reserve Sandstone'                    , 900 , 1897, 199.99, 3 , 'Blanc', 'Sec'      , 'Vin cuit'          , 'Chardonnay'         , 'IGP'         , 'Elie Yaffa'            , 12.4, '1999-06-23');
INSERT INTO Cave VALUES('Fleur De Lys'                         , 1800, 2003, 499.99, 1 , 'Blanc', 'Sec'      , 'Vin tranquille'    , 'Vin de Savoie'      , 'AOC/AOP'     , 'Elie Yaffa'            , 19.9, '2020-02-17');
INSERT INTO Cave VALUES('Blanc Essence'                        , 150 , 2001, 499.99, 0 , 'Blanc', 'Sec'      , 'Vin effervescent'  , 'Pinot Blanc'        , 'AOC/AOP'     , 'Elie Yaffa'            , 18.2, '2013-12-14');
INSERT INTO Cave VALUES('The Reserve'                          , 1500, 2003, 72    , 0 , 'Blanc', 'Moelleux' , 'Vin effervescent'  , 'Chardonnay'         , 'AOC/AOP'     , 'Okou Gnakouri'         , 12.5, '2014-10-27');
INSERT INTO Cave VALUES('Chenin Blanc'                         , 75  , 2016, 4.55  , 3 , 'Blanc', 'Sec'      , 'Vin tranquille'    , 'Sauvignon'          , 'Vin de pays' , 'Kerry James'           , 7.7 , '2020-08-20');
INSERT INTO Cave VALUES('Chenin Blanc'                         , 75  , 2016, 4.55  , 3 , 'Blanc', 'Sec'      , 'Vin tranquille'    , 'Sauvignon'          , 'Vin de pays' , 'Elie Yaffa'            , 7.4 , '2020-09-20');
INSERT INTO Cave VALUES('Diorite - Domaine Coquard' 	       , 75  , 2018, 10.30 , 3 , 'Rouge', 'Sec'      , 'Vin tranquille'    , 'Côte de Brouilly'   , 'AOC/AOP'     , 'David Lieu'        	 , 16  , '2018-09-24');
INSERT INTO Cave VALUES('Nos Racines - Famille Raymond'        , 75  , 2017, 3.47  , 10, 'Rouge', 'Moelleux' , 'Vin doux naturel'  , 'Corbières'      	, 'AOC/AOP' 	, 'Millicent Vadeboncoeur',  8  , '2020-10-03');
INSERT INTO Cave VALUES('Nos Racines - Famille Raymond'        , 75  , 2017, 3.47  , 10, 'Rouge', 'Moelleux' , 'Vin doux naturel'  , 'Corbières'      	, 'AOC/AOP' 	, 'Ranger Richer'     	 , 11  , '2020-10-03');
INSERT INTO Cave VALUES('Henri Collin et Louis Bourisse'       , 150 , 1998, 5.36  , 16, 'Rouge', 'Moelleux' , 'Vin cuit'          , 'Chiroubes'      	, 'IGP'     	, 'Felicien Goddu'    	 , 19  , '1999-02-15');
INSERT INTO Cave VALUES('Olivier Coquard - Terra Vitis'        , 75  , 2000, 6.00  , 4 , 'Rouge', 'Liquoreux', 'Vin tranquille'    , 'Beaujolais'     	, 'AOC/AOP' 	, 'Felicien Goddu'    	 , 15  , '2005-06-20');
INSERT INTO Cave VALUES('Domaine de la Tradition'   	       , 300 , 2014, 6.75  , 29, 'Rouge', 'Sec'      , 'Vin effervescent'  , 'Beaujolais'     	, 'AOC/AOP' 	, 'Dreux Beaulieu'    	 , 19  , '2016-11-11');
INSERT INTO Cave VALUES('Le Passelys - Prestige'    	       , 75  , 2017, 9.99  , 9 , 'Rouge', 'Demi-sec' , 'Vin doux naturel'  , 'Cahors'         	, 'IGP'     	, 'Leal Laurent'      	 ,  2  , '2017-10-09');
INSERT INTO Cave VALUES('Le Passelys - Prestige'    	       , 75  , 2017, 9.99  , 9 , 'Rouge', 'Demi-sec' , 'Vin doux naturel'  , 'Cahors'         	, 'IGP'     	, 'Odette Rouleau'    	 , 17  , '2017-10-09');
INSERT INTO Cave VALUES('Le Passelys - Prestige'    	       , 75  , 2017, 9.99  , 9 , 'Rouge', 'Demi-sec' , 'Vin doux naturel'  , 'Cahors'         	, 'IGP'     	, 'Platt Viens'       	 , 10  , '2017-10-11');
INSERT INTO Cave VALUES('Château Saincrit'                     , 75  , 2000, 6.25  , 7 , 'Rouge', 'Liquoreux', 'Vin effervescent'  , 'Bordeaux superieur' , 'AOC/AOP' 	, 'Liane Beaulé'      	 , 20  , '2016-10-09');
INSERT INTO Cave VALUES('Domaine Didier Desvignes'	           , 37.5, 2000, 4.95  , 6 , 'Rouge', 'Liquoreux', 'Vin effervescent'  , 'Beaujolais village' , 'AOC/AOP' 	, 'Julien Migneault'  	 ,  0  , '2016-10-09');
INSERT INTO Cave VALUES('Château Hurardin'                     , 37.5, 2005, 9.50  , 14, 'Rouge', 'Sec'      , 'Vin doux naturel'  , 'Grave'          	, 'Vin de pays' , 'Satordi Charette'  	 , 12  , '2016-10-10');
INSERT INTO Cave VALUES('Château Hurardin'                     , 37.5, 2005, 9.50  , 14, 'Rouge', 'Sec'      , 'Vin doux naturel'  , 'Grave'              , 'Vin de pays' , 'Melville Garceau'  	 , 19  , '2016-10-10');
INSERT INTO Cave VALUES('Clos des Mûres'                       , 37.5, 2009, 6.18  , 9 , 'Rouge', 'Liquoreux', 'Vin doux naturel'  , 'Côte du Rhône'  	, 'VDQS'        , 'Ranger Richer'     	 , 12  , '2017-12-24');
INSERT INTO Cave VALUES('Chapaize Haut - Domaine Perrin'       , 75  , 2009, 16.81 , 11, 'Rouge', 'Moelleux' , 'Vin effervescent'  , 'Maranges'       	, 'AOC/AOP' 	, 'Julien Migneault'  	 , 14  , '2019-01-15');
INSERT INTO Cave VALUES('La Fussière - Domaine Monnot'         , 900 , 2018, 18.20 , 13, 'Rouge', 'Sec'      , 'Vin tranquille'    , 'Côte du Rhône'  	, 'Vin de table', 'Zerbino Michaud'   	 , 10  , '2020-02-20');
INSERT INTO Cave VALUES('Maranges Côte de Beaune'   	         , 75  , 2009, 7.30  , 2 , 'Rouge', 'Sec'      , 'Vin cuit'          , 'Beaujolais'     	, 'Vin de table', 'Dreux Bonenfant'   	 , 10  , '2019-12-19');
INSERT INTO Cave VALUES('Château La Roque'          	         , 75  , 2011, 11.49 , 1 , 'Rouge', 'Demi-sec' , 'Vin tranquille'    , 'Pic Saint-Loup' 	, 'AOC/AOP' 	, 'Ogier Rochon'      	 , 10  , '2019-08-21');
INSERT INTO Cave VALUES('Romain Duvernay'           	         , 150 , 2019, 3.99  , 5 , 'Rouge', 'Sec'      , 'Vin cuit'          , 'Beaujolais'     	, 'AOC/AOP' 	, 'Elita Bonenfant'   	 ,  9  , '2019-07-29');
INSERT INTO Cave VALUES('Domaine de Coudoulis'      	         , 150 , 2020, 13.95 , 6 , 'Rouge', 'Moelleux' , 'Vin cuit'    	     , 'Beaumes de Venise'  , 'IGP'         , 'Vedette David'     	 , 20  , '2019-05-01');
INSERT INTO Cave VALUES('Cote Saint Ange'           	         , 75  , 1999, 5.31  , 10, 'Rouge', 'Moelleux' , 'Vin cuit'   	     , 'Beaujolais'     	, 'IGP'         , 'Julien Liver'      	 , 17  , '2001-06-19');
INSERT INTO Cave VALUES('Château Lynch Bages'       	         , 37.5, 2015, 6.64  , 16, 'Rouge', 'Demi-sec' , 'Vin doux naturel'  , 'Beaujolais'     	, 'Vin de table', 'Lundy Legault'     	 , 17  , '2018-11-20');
INSERT INTO Cave VALUES('Château La Confession'     	         , 75  , 2006, 9.98  , 9 , 'Rouge', 'Liquoreux', 'Vin tranquille'    , 'Beaumes de Venise'  , 'Vin de table', 'Royden Fecteau'    	 , 14  , '2019-05-30');
INSERT INTO Cave VALUES('Château Pontet-Canet'      	         , 150 , 2020, 11.02 , 5 , 'Rouge', 'Moelleux' , 'Vin tranquille'    , 'Grave'          	, 'IGP'         , 'Rule Henrichon'    	 , 15  , '2019-12-25');
INSERT INTO Cave VALUES('Château Montrose'          	         , 75  , 2010, 67.50 , 3 , 'Rouge', 'Demi-sec' , 'Vin effervescent'  , 'Côte de Brouilly'   , 'VDQS'        , 'Patricia Bellefeuille', 19  , '2014-12-24');
INSERT INTO Cave VALUES('Château Pape Clément'      	         , 75  , 2019, 29.61 , 6 , 'Rouge', 'Liquoreux', 'Vin effervescent'  , 'Côte du Rhône'  	, 'VDQS'        , 'Senior Faucher'       ,  6  , '2019-12-12');
INSERT INTO Cave VALUES('Le Petit Mouton de Mouton Rothschild' , 75  , 2015, 223.00, 0 , 'Rouge', 'Sec'      ,'Vin tranquille'     , 'Bordeaux'           , 'AOC/AOP'     ,'Mattias Eyherabide'    , 16  , '2018-09-24');
INSERT INTO Cave VALUES('Château Labégorce'                    , 300 , 2016, 29.00 , 2 , 'Rouge', 'Demi-sec' ,'Vin tranquille'     , 'Bordeaux'           , 'AOC/AOP'     ,'Florian Boireau'       , 14  , '2018-10-27');
INSERT INTO Cave VALUES('Château Ferrière'                     , 150 , 2008, 51.23 , 7 , 'Rouge', 'Sec'      ,'Vin tranquille'     , 'Bordeaux'           , 'AOC/AOP'     ,'Jerôme Laurent'        , 10  , '2009-07-27');
INSERT INTO Cave VALUES('Château Silex'                        , 75  , 2018, 4.15  , 6 , 'Rouge', 'Demi-sec' ,'Vin doux naturel'   , 'Rhone'              , 'AOC/AOP'     ,'Jean Dupont'           , 13  , '2019-03-12');
INSERT INTO Cave VALUES('Château Silex'                        , 75  , 2018, 4.15  , 6 , 'Rouge', 'Demi-sec' ,'Vin doux naturel'   , 'Rhone'              , 'AOC/AOP'     ,'Tristan Rahard'        , 13  , '2018-10-21');
INSERT INTO Cave VALUES('Château Gemeillan'                    , 75  , 2015, 8.50  , 4 , 'Rouge', 'Demi-sec' ,'Vin cuit'           , 'Bordeaux'           , 'AOC/AOP'     ,'Roger Duparc'          , 9   , '2016-04-01');
INSERT INTO Cave VALUES('Jean Philippe Marchand - Le Bareuzaï' , 37.5, 2017, 18.50 , 2 , 'Rouge', 'Sec'      ,'Vin tranquille'     , 'Bourgogne'          , 'AOC/AOP'     ,'Florian Boireau'       , 4   , '2019-12-13');
INSERT INTO Cave VALUES('Jean Philippe Marchand - Le Bareuzaï' , 37.5, 2015, 8.50  , 4 , 'Rouge', 'Demi-sec' ,'Vin cuit'           , 'Bordeaux'           , 'AOC/AOP'     ,'Roger Duparc'          , 9   , '2017-04-01');
INSERT INTO Cave VALUES('Château Mouton Rothschild'            , 75  , 2017, 480.00, 9 , 'Rouge', 'Sec'      ,'Vin tranquille'     , 'Bordeaux'           , 'AOC/AOP'     ,'Mattias Eyherabide'    , 18  , '2017-11-25');
INSERT INTO Cave VALUES('Château Larose-Trintaudon'            , 500 , 2015, 28.00 , 0 , 'Rouge', 'Moelleux' ,'Vin tranquille'     , 'Bordeaux'           , 'AOC/AOP'     ,'Roger Duparc'          , 17  , '2016-09-24');
INSERT INTO Cave VALUES('Château Larose-Trintaudon'            , 500 , 2015, 28.00 , 0 , 'Rouge', 'Moelleux' ,'Vin tranquille'     , 'Bordeaux'           , 'AOC/AOP'     ,'Florian Boireau'       , 19  , '2016-09-26');
INSERT INTO Cave VALUES('Château Labégorce'                    , 300 , 2016, 29.00 , 2 , 'Rouge', 'Demi-sec' ,'Vin tranquille'     , 'Bordeaux'           , 'AOC/AOP'     ,'Florian Boireau'       , 14  , '2018-10-27');
INSERT INTO Cave VALUES('Jean-Luc Colombo - Les Lauves'        , 75  , 2017, 23.00 , 5 , 'Rouge', 'Demi-sec' ,'Vin tranquille'     , 'Rhone'              , 'AOC/AOP'     ,'Tristan Rahard'        , 5   , '2017-10-13');
INSERT INTO Cave VALUES('Domaine Jacqueline Frachet'           , 75  , 2015, 19.95 , 1 , 'Rouge', 'Liquoreux','Vin doux naturel'   , 'Beaune'             , 'AOC/AOP'     ,'Nicolas Sarkozy'       , 15  , '2018-10-12');
INSERT INTO Cave VALUES('Domaine Jacqueline Frachet'           , 75  , 2015, 19.95 , 1 , 'Rouge', 'Liquoreux','Vin doux naturel'   , 'Beaune'             , 'AOC/AOP'     ,'Florian Boireau'       , 11  , '2018-08-03');
INSERT INTO Cave VALUES('La Dame de Montrose'                  , 600 , 2016, 38.30 , 2 , 'Rouge', 'Moelleux' ,'Vin doux naturel'   , 'Bordeaux'           , 'AOC/AOP'     ,'Emmanuel Vincuit'      , 7   , '2017-05-29');
INSERT INTO Cave VALUES('Clos du Pavillon-Domaine des Marrans' , 1200, 2017, 15.99 , 4 , 'Rouge', 'Sec'      ,'Vin cuit'           , 'Beaujolais'         , 'AOC/AOP'     ,'Marcel Rigolo'         , 2   , '2020-01-05');
INSERT INTO Cave VALUES('Clos du Pavillon-Domaine des Marrans' , 1200, 2017, 15.99 , 4 , 'Rouge', 'Sec'      ,'Vin cuit'           , 'Beaujolais'         , 'AOC/AOP'     ,'Roger Duparc'          , 16  , '2019-12-23');
INSERT INTO Cave VALUES('K de Kirwan'                          , 37.5, 2016, 23.90 , 0 , 'Rouge', 'Demi-sec' ,'Vin doux naturel'   , 'Bordeaux'           , 'AOC/AOP'     ,'Marc Polo'             , 13  , '2020-05-11');
INSERT INTO Cave VALUES('Dourthe - Château Reysson '           , 1800, 2015, 13.25 , 8 , 'Rouge', 'Sec'      ,'Vin doux naturel'   , 'Bordeaux'           , 'AOC/AOP'     ,'Jerôme Laurent'        , 08  , '2016-05-11');
INSERT INTO Cave VALUES('Domaine des Couronnières'             , 75  , 2019, 3.50  , 6 , 'Rosé' , 'Moelleux' , 'Vin tranquille'    , 'Cabernet d''Anjou'  , 'AOC/AOP'     , 'Charles Feray'        , 16  , '2020-06-12');
INSERT INTO Cave VALUES('Very Pamp'                            , 75  , 2016, 8.46  , 5 , 'Rosé' , 'Demi-sec' , 'Vin tranquille'    , 'Cabernet d''Anjou'  , 'IGP'         , 'Matteo Renault'       , 17  , '2017-05-27');
INSERT INTO Cave VALUES('Baie Des Anges'                       , 300 , 2019, 7.43  , 1 , 'Rosé' , 'Moelleux' , 'Vin tranquille'    , 'Côtes de Provences' , 'AOC/AOP'     , 'Phillipe Lemme'       , 2.4 , '2020-08-18');
INSERT INTO Cave VALUES('Antoine de la Farge Reully Gris'      , 37.5, 2019, 8.46  , 0 , 'Rosé' , 'Liquoreux', 'Vin doux naturel'  , 'Loire'              , 'AOC/AOP'     , 'Charles Feray'        , 13.7, '2020-06-08');
INSERT INTO Cave VALUES('L''ame de Causse'                     , 75  , 2019, 7.10  , 2 , 'Rosé' , 'Sec'      , 'Vin effervescent'  , 'Corbières'          , 'Vin de table', 'Jean Nage'            , 11.6, '2019-11-17');
INSERT INTO Cave VALUES('Vignerons de Mancey'                  , 37.5, 2018, 4.56  , 1 , 'Rosé' , 'Demi-sec' , 'Vin cuit'          , 'Mâcon'              , 'AOC/AOP'     , 'Pacome Liaziz'        , 17  , '2019-12-10');
INSERT INTO Cave VALUES('Un petit air de Rosé'                 , 150 , 2012, 7.90  , 2 , 'Rosé' , 'Moelleux' , 'Vin tranquille'    , 'Méditerranée'       , 'IGP'         , 'Fabien Picton'        , 12.5, '2015-03-22');
INSERT INTO Cave VALUES('Le Petit Cochonnet - Grenache - V&CO' , 75  , 2008, 3.45  , 8 , 'Rosé' , 'Moelleux' , 'Vin effervescent'  , 'Pays d''Oc'         , 'IGP'         , 'Olivier Binouz'       , 13.7, '2010-02-09');
INSERT INTO Cave VALUES('Chateau des cossé - Bag in Box'       , 300 , 2013, 13.30 , 1 , 'Rosé' , 'Liquoreux', 'Vin doux naturel'  , 'Cabernet d''Anjou'  , 'VDQS'        , 'Charles Feray'        , 12.4, '2020-06-12');
INSERT INTO Cave VALUES('Very Framboise'                       , 75  , 2016, 2.70  , 15, 'Rosé' , 'Demi-sec' , 'Vin tranquille'    , 'Cabernet dAnjou'    , 'IGP'         , 'Judith Picault'       , 16.2, '2018-06-21');
INSERT INTO Cave VALUES('Bulle Nature Rosé'                    , 37.5, 2019, 13.95 , 1 , 'Rosé' , 'Sec'      , 'Vin effervescent'  , 'Gros lot - Cabernet', 'Vin de table', 'Elie Yaffa'           , 14.5, '2019-10-14');
INSERT INTO Cave VALUES('Very Framboise'                       , 75  , 2016, 2.70  , 15, 'Rosé' , 'Demi-sec' , 'Vin tranquille'    , 'Cabernet dAnjou'    , 'IGP'         , 'Tristan Rahard'       , 15.6, '2018-06-21');



-----------------------------------------------
--                                           --
--   INSERTION DES VALEURS DANS LES TABLES   --
--                                           --
-----------------------------------------------



INSERT INTO Categorie(robe_bouteille,sucrage_bouteille,type_bouteille)
SELECT DISTINCT robe_bouteille,sucrage_bouteille,type_bouteille FROM Cave;

INSERT INTO Appellation(nom_appellation,categorie_appellation)
SELECT DISTINCT nom_appellation,categorie_appellation FROM Cave;

INSERT INTO Oenologue (nom_oenologue) SELECT DISTINCT nom_oenologue FROM Cave;

INSERT INTO Bouteille(nom_bouteille,volume_bouteille,millesime_bouteille,prix_bouteille,id_categorie,id_appellation)
SELECT DISTINCT nom_bouteille,volume_bouteille,millesime_bouteille,prix_bouteille, id_categorie, id_appellation FROM Cave JOIN Categorie
ON  (Cave.robe_bouteille = Categorie.robe_bouteille)
AND (Cave.sucrage_bouteille = Categorie.sucrage_bouteille)
AND (Cave.type_bouteille = Categorie.type_bouteille)
AND (Cave.robe_bouteille = Categorie.robe_bouteille)
JOIN Appellation
ON (Cave.nom_appellation = Appellation.nom_appellation)
AND (Cave.categorie_appellation = Appellation.categorie_appellation);

INSERT INTO Degustation (note_degustation,date_degustation,id_bouteille,id_oenologue)
SELECT note_degustation,date_degustation, id_bouteille,id_oenologue FROM Cave JOIN Oenologue
ON (Cave.nom_oenologue  = Oenologue.nom_oenologue)
JOIN Bouteille
ON (Cave.nom_bouteille = Bouteille.nom_bouteille)
AND (Cave.volume_bouteille = Bouteille.volume_bouteille)
AND (Cave.millesime_bouteille = Bouteille.millesime_bouteille);

INSERT INTO Quantite(nom_bouteille,volume_bouteille,millesime_bouteille,qte_bouteille)
SELECT DISTINCT nom_bouteille,volume_bouteille,millesime_bouteille,qte_bouteille FROM Cave;


DROP TABLE IF EXISTS Cave;