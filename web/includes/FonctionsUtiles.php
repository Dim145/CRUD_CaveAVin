<?php
    require_once "../classes/DataBaseObject.php";
    require_once "../classes/degustation.php";
    require_once "../classes/quantite.php";
    require_once "../classes/bouteille.php";
    require_once "../classes/appellation.php";
    require_once "../classes/categorie.php";
    require_once "../classes/oenologue.php";

/**
 * Class FonctionsUtiles
 */
class FonctionsUtiles
{
    private static ?PDO $bdd = null;

    /**
     * Retourne une PDO déjà instanciée ou en instancie une avant de la retourner
     * @return PDO L'instance actuelle de PDO
     */
    public static function getBDD(): PDO
    {
        if( self::$bdd == null ) self::$bdd = self::connexionBD();

        return self::$bdd;
    }

    /**
     * Ferme la PDO
     */
    public static function closeBDD(): void
    {
        self::$bdd->commit();
        self::$bdd = null;
    }

    /**
     * Connexion a la base de donnée
     * @return PDO L'instance de PDO
     */
    public static function connexionBD(): PDO
    {
        return new PDO('pgsql:host=postgresql-cavevin.alwaysdata.net;dbname=cavevin_base1', 'cavevin', 'iYMYpR7X@X@$qPDN', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }

    /**
     * @param int $id_bouteille L'identifiant de la bouteille voulue
     * @return Bouteille Objet de type Bouteille
     */
    public static function getBouteille(int $id_bouteille): Bouteille
    {
        $bdd = self::getBDD();
        $reponse = $bdd->query("SELECT * FROM bouteille where id_bouteille = $id_bouteille");

        $bouteille = $reponse->fetchObject(Bouteille::class);
        $bouteille->setObjects();

        return $bouteille;
    }

    /**
     * @param int $id_appellation L'identifiant de l'appellation voulue
     * @return Appellation Objet de type Appellation
     */
    public static function getAppellation(int $id_appellation): Appellation
    {
        $bdd = self::getBDD();
        $reponse = $bdd->query("SELECT * FROM appellation where id_appellation = $id_appellation");

        return $reponse->fetchObject(Appellation::class);
    }

    /**
     * @param int $id_categorie L'identifiant de la catégorie voulue
     * @return Categorie Objet de type Categorie
     */
    public static function getCategorie(int $id_categorie): Categorie
    {
        $bdd = self::getBDD();
        $reponse = $bdd->query("SELECT * FROM categorie where id_categorie = $id_categorie");

        return $reponse->fetchObject(Categorie::class);
    }

    /**
     * @param int $id_oenologue L'identifiant de l'oenologue voulue
     * @return Oenologue Objet de type Oenologue
     */
    public static function getOenologue(int $id_oenologue): Oenologue
    {
        $bdd = self::getBDD();

        $reponse = $bdd->query("SELECT * FROM oenologue WHERE id_oenologue = $id_oenologue");

        return $reponse->fetchObject(Oenologue::class);
    }

    /**
     * @param int $id_degustation L'identifiant de la dégustation voulue
     * @return Degustation Objet de type Dégustation
     */
    public static function getDegustation(int $id_degustation): Degustation
    {
        $bdd = self::getBDD();

        $reponse = $bdd->query("SELECT * FROM degustation WHERE id_degustation = $id_degustation");

        return $reponse->fetchObject(Degustation::class);
    }

    /**
     * @param int $id_quantite
     * @return Quantite Objet de type Quantité
     */
    public static function getQuantite(int $id_quantite): Quantite
    {
        $bdd = self::getBDD();

        $reponse = $bdd->query("SELECT * FROM quantite WHERE id_quantite = $id_quantite");

        return $reponse->fetchObject(Degustation::class);
    }

    /**
     * Retourne un tableau affichant l'objet en paramètre
     * @param DataBaseObject $object Objet a afficher
     * @return string chaine d'affichage
     */
    public function getHTMLTab( DataBaseObject $object ): string
    {
        $sRet = "";

        foreach ( $object->getColumsValues() as $name => $value )
        {
            // ect...
        }

        return $sRet;
    }
}

    print_r(FonctionsUtiles::getBouteille(1)->getColumsValues());