ALTER TABLE quantite DROP CONSTRAINT quantite_millesime_bouteille_check;
ALTER TABLE quantite ADD CONSTRAINT quantite_millesime_bouteille_check CHECK( millesime_bouteille > 0 AND millesime_bouteille <= 2099);

--VUE 1
--Affiche toutes les table de la cave dans une seule vue
--Permet d'avoir accès a chaque attributs existants dans la base

DROP VIEW IF EXISTS CaveEnDetail;
CREATE OR REPLACE VIEW CaveEnDetail(nom_bouteille,millesime_bouteille, volume_bouteille,prix_bouteille, qte_bouteille ,robe_bouteille, sucrage_bouteille, type_bouteille,nom_appellation, categorie_appellation, note_degustation, date_degustation, nom_oenologue)
AS SELECT Bouteille.nom_bouteille,Bouteille.millesime_bouteille, Bouteille.volume_bouteille,prix_bouteille, qte_bouteille ,robe_bouteille, sucrage_bouteille, type_bouteille ,nom_appellation , categorie_appellation, note_degustation, date_degustation, nom_oenologue
FROM Bouteille
INNER JOIN Quantite
ON Bouteille.nom_bouteille = Quantite.nom_bouteille
AND Bouteille.millesime_bouteille = Quantite.millesime_bouteille
AND Bouteille.volume_bouteille = Quantite.volume_bouteille
INNER JOIN Categorie
ON Bouteille.id_categorie = Categorie.id_categorie
INNER JOIN Appellation
ON Bouteille.id_appellation = Appellation.id_appellation
INNER JOIN Degustation
ON Bouteille.id_bouteille = Degustation.id_bouteille
INNER JOIN Oenologue
ON Degustation.id_oenologue = Oenologue.id_oenologue;

--SELECT * from CaveEnDetail;  --TEST


--VUE 2
--Affiche toute les bouteilles detenu dans la cave (dont la quantité est > 0 donc)
--Permet de savoir quelles bouteilles le détenteur de la cave il peut boire ou vendre

DROP VIEW IF EXISTS InfosBouteillesIndisponibles;
CREATE VIEW InfosBouteillesIndisponibles(nom_bouteille, millesime_bouteille, volume_bouteille, prix_bouteille) AS
SELECT Bouteille.nom_bouteille, Bouteille.millesime_bouteille, Bouteille.volume_bouteille, prix_bouteille
FROM Bouteille INNER JOIN Quantite
ON Bouteille.nom_bouteille = Quantite.nom_bouteille
AND Bouteille.millesime_bouteille = Quantite.millesime_bouteille
AND Bouteille.volume_bouteille = Quantite.volume_bouteille
WHERE qte_bouteille = 0;

--SELECT * FROM infosBouteillesIndisponibles; --TEST



--VUE 3
--Affiche toute les bouteilles qui ont une note au dessus de 10
--Permet de savoir quelles sont les bonnes bouteilles

DROP VIEW IF EXISTS bouteilleAuDessusDeLaMoyenne;
CREATE VIEW bouteilleAuDessusDeLaMoyenne(nom_bouteille, millesime_bouteille, note_degustation) AS
SELECT DISTINCT (nom_bouteille), millesime_bouteille, note_degustation
FROM Bouteille NATURAL JOIN degustation
WHERE note_degustation>=10;

--SELECT * FROM bouteilleAuDessusDeLaMoyenne; --TEST


--FONCTION 1
--Fonction qui remplace le prix d'une bouteille trouvée par son nom, son millesime et son volume par un nouveau prix
--Permet de changer le prix d'une bouteille, plus le temps passe plus une bouteille prend en valeur

DROP PROCEDURE setModificationPrix(nom varchar, millesime int, volume NUMERIC, nouveauPrix NUMERIC);
CREATE OR REPLACE PROCEDURE setModificationPrix(nom varchar, millesime int, volume NUMERIC, nouveauPrix NUMERIC) AS $$
BEGIN
    IF nom = NULL THEN
        RAISE EXCEPTION 'nom incorrect : %', nom;
    END IF;
    IF millesime < 0 OR millesime > 2099 THEN
        RAISE EXCEPTION 'Date de millesime incorrecte : %', millesime;
    END IF;
    IF volume != 37.5 AND volume != 75  AND volume != 150 AND volume != 300 AND
       volume != 500 AND volume != 600 AND volume != 900 AND volume != 1200 AND volume != 1500 AND volume != 1800 THEN
       RAISE EXCEPTION 'Volume inexistant : %', volume;
    END IF;
    IF nouveauPrix <= 0 THEN
        RAISE EXCEPTION 'Nouveau prix incorrect : %', nouveauPrix;
    END IF;

    UPDATE bouteille SET prix_bouteille = nouveauPrix
    WHERE nom_bouteille = nom AND millesime_bouteille = millesime AND volume_bouteille = volume;

    IF NOT FOUND
        THEN RAISE EXCEPTION 'Bouteille non trouvée';
    END IF;

END;
$$LANGUAGE plpgsql;

--CALL setModificationPrix('Beachcomber', 2016, 1200, 158); --TEST




--FONCTION 2
--Fonction qui affiche la quantite totale de bouteilles dans la cave
--Permet au détenteur de la cave de savoir combien de bouteilles il lui reste en tout et si il peux en acheter si il lui reste de la place ou en vendre

DROP FUNCTION IF EXISTS getnombretotalbouteilles();
CREATE OR REPLACE FUNCTION getNombreTotalBouteilles() RETURNS int AS $$
    DECLARE
        retourNbBouteille int;
    BEGIN
        SELECT sum(qte_bouteille) INTO retourNbBouteille
        FROM   quantite;


        IF NOT FOUND THEN RAISE EXCEPTION 'Aucune bouteille trouvée';
        END IF;

        RETURN retourNbBouteille;
    END
$$ LANGUAGE plpgsql;

--SELECT * FROM getNombreTotalBouteilles(); --TEST



--FONCTION 3
--Fonction qui retourne le nom, le millesime et le prix des bouteilles dont le volume est supérieur a 1500cl (15L)
--Permet de trouver les grosses bouteilles a sortir lors de très grandes occasions, gala, mariage, ...

DROP FUNCTION IF EXISTS getBouteilleDe15LitresOuPlus();
CREATE OR REPLACE FUNCTION getBouteilleDe15LitresOuPlus() RETURNS table(nom varchar, millesime int, prix NUMERIC, volume NUMERIC) AS $$
BEGIN

    RETURN QUERY SELECT nom_bouteille, millesime_bouteille, prix_bouteille, volume_bouteille
    FROM bouteille
    WHERE volume_bouteille = 1500 OR volume_bouteille = 1800;

    IF NOT FOUND THEN RAISE EXCEPTION 'Aucun resultat trouvé';
    END IF;
    RETURN;
END;
$$ LANGUAGE plpgsql;

--SELECT * FROM getBouteilleDe15LitresOuPlus(); --TEST




--TRIGGER 1
/*Trigger qui affiche la différence de prix entre l'ancien et le nouveau prix lors
  de la modification d'une bouteille mais aussi affichera la nouvelle bouteille après création de celle-ci
  et la bouteille supprimée après suppression de celle-ci*/
--Permet de savoir lors d'une modification du prix si ce prix a baissé ou si il à monté

DROP FUNCTION IF EXISTS funcTrigDifferencePrixBouteille;
CREATE OR REPLACE FUNCTION funcTrigDifferencePrixBouteille() RETURNS TRIGGER AS $$
    BEGIN
        IF(tg_when = 'AFTER') THEN
            IF(tg_op = 'UPDATE' AND tg_level = 'ROW' AND OLD.prix_bouteille IS DISTINCT FROM NEW.prix_bouteille) THEN
                RAISE NOTICE 'Modification en cours : TG_OP=%', TG_OP;
                RAISE NOTICE 'Modification du prix d''une bouteille | OLD : %', OLD;
                RAISE NOTICE 'Modification du prix d''une bouteille | NEW : %', NEW;
                IF(OLD.prix_bouteille > NEW.prix_bouteille) THEN
                    RAISE NOTICE 'Diminution du prix   : %', OLD.prix_bouteille-NEW.prix_bouteille;
                ELSE --OLD.prix_bouteille ne peux etre = a NEW.prix_bouteille
                    RAISE NOTICE 'Augmentation du prix : %', NEW.prix_bouteille-OLD.prix_bouteille;
                END IF;
            ELSIF(tg_op = 'INSERT' AND tg_level = 'ROW') THEN
                RAISE NOTICE 'Modification en cours : TG_OP=%', TG_OP;
                RAISE NOTICE 'Nouvelle bouteille crée : %', NEW;
            ELSIF(tg_op = 'DELETE' AND tg_level = 'ROW') THEN
                RAISE NOTICE 'Modification en cours : TG_OP=%', TG_OP;
                RAISE NOTICE 'Bouteille supprimée : %', OLD;
            END IF;
        END IF;
        RETURN NEW;
    END;
$$LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigDifferencePrixBouteille ON bouteille;
CREATE TRIGGER trigDifferencePrixBouteille
    AFTER UPDATE OR INSERT OR DELETE ON bouteille
    FOR EACH ROW
    EXECUTE PROCEDURE funcTrigDifferencePrixBouteille();

UPDATE bouteille SET prix_bouteille = 23 WHERE volume_bouteille= 75;
INSERT INTO bouteille VALUES(DEFAULT,'Zivorac de Neuilly', 75, 1180, 1800, 1, 2);
INSERT INTO bouteille VALUES(DEFAULT,'Zivorac de Neuilly', 37.5, 1180, 1800, 1, 2);
DELETE FROM bouteille WHERE nom_bouteille = 'Zivorac de Neuilly';

--UPDATE bouteille SET prix_bouteille=10 WHERE volume_bouteille=75; --TEST




--TRIGGER 2
--Trigger qui affiche la quantite de bouteilles dans la cave après que celle ci a été modifié
--Permet de savoir après modification d'une ou plusieurs quantité combien de bouteilles contient la cave

CREATE FUNCTION trigNbBouteilles() RETURNS trigger AS $$
DECLARE
    nbBouteillesTot int;
BEGIN
    SELECT SUM(qte_bouteille) INTO nbBouteillesTot from Quantite;
    RAISE NOTICE 'Il y a acuellement % Bouteilles présentes dans la cave', nbBouteillesTot;
    RETURN NEW;
END $$ LANGUAGE plpgsql;

CREATE TRIGGER nbBouteilles
    AFTER UPDATE OR INSERT OR DELETE ON Quantite
    FOR EACH STATEMENT
    EXECUTE PROCEDURE trigNbBouteilles();

--UPDATE quantite SET qte_bouteille= 99 WHERE volume_bouteille = 37.5; --TEST