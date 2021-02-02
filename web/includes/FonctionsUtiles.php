<?php
    require_once "../classes/DataBaseObject.php";
    require_once "../classes/degustation.php";
    require_once "../classes/quantite.php";
    require_once "../classes/bouteille.php";
    require_once "../classes/appellation.php";
    require_once "../classes/categorie.php";
    require_once "../classes/oenologue.php";

class FonctionsUtiles
{
    private static ?PDO $bdd = null;

    public static function getBDD(): PDO
    {
        if( self::$bdd == null ) self::$bdd = self::connexionBD();

        return self::$bdd;
    }

    public static function closeBDD()
    {
        self::$bdd->commit();
        self::$bdd = null;
    }

    public static function connexionBD(): PDO
    {
        return new PDO('pgsql:host=postgresql-cavevin.alwaysdata.net;dbname=cavevin_base1', 'cavevin', 'iYMYpR7X@X@$qPDN', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }

    public static function getBouteille(int $id_bouteille): Bouteille
    {
        $bdd = self::getBDD();
        $reponse = $bdd->query("SELECT * FROM bouteille where id_bouteille = $id_bouteille");

        $bouteille = $reponse->fetchObject(Bouteille::class);
        $bouteille->setObjects();

        return $bouteille;
    }

    public static function getAppellation(int $id_appellation): Appellation
    {
        $bdd = self::getBDD();
        $reponse = $bdd->query("SELECT * FROM appellation where id_appellation = $id_appellation");

        return $reponse->fetchObject(Appellation::class);
    }

    public static function getCategorie(int $id_categorie): Categorie
    {
        $bdd = self::getBDD();
        $reponse = $bdd->query("SELECT * FROM categorie where id_categorie = $id_categorie");

        return $reponse->fetchObject(Categorie::class);
    }

    public static function getOenologue(int $id_oenologue): Oenologue
    {
        $bdd = self::getBDD();

        $reponse = $bdd->query("SELECT * FROM oenologue WHERE id_oenologue = $id_oenologue");

        return $reponse->fetchObject(Oenologue::class);
    }

    public static function getDegustation(int $id_degustation): Degustation
    {
        $bdd = self::getBDD();

        $reponse = $bdd->query("SELECT * FROM degustation WHERE id_degustation = $id_degustation");

        return $reponse->fetchObject(Degustation::class);
    }

    public static function getQuantite(int $id_quantite): Quantite
    {
        $bdd = self::getBDD();

        $reponse = $bdd->query("SELECT * FROM quantite WHERE id_quantite = $id_quantite");

        return $reponse->fetchObject(Degustation::class);
    }
}

    echo FonctionsUtiles::getBouteille(1);