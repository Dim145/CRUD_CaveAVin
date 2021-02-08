<?php
    require_once "../connexionPerso.php";
    require_once "../classes/DataBaseObject.php";
    require_once "../classes/degustation.php";
    require_once "../classes/quantite.php";
    require_once "../classes/bouteille.php";
    require_once "../classes/appellation.php";
    require_once "../classes/categorie.php";
    require_once "../classes/oenologue.php";

    require_once "../classes/DataBaseObjectIterator.php";

/**
 * Class FonctionsUtiles
 */
class FonctionsUtiles
{
    private static ?PDO $bdd = null;

    /**
     * Crée le debut de la page HTML
     * @param string $titre Le titre de la page
     * @return string Le contenu de la page
     */
    public static function getDebutHTML(string $titre):string
    {
        return "<html lang=\"fr\">
                    <head>
                        <title>$titre</title>
                        <link href='../style/style.css' rel='stylesheet' type='text/css'/>
                    </head>
                    <body>";
    }

    /**
     * crée la fin de la page HTML
     * @return string Le contenu de la page
     */
    public static function getFinHTML():string
    {
        return "</body>
            </html>";
    }

    /**
     * Récupère toutes les instance d'une class dans la base de donnée
     * @param ReflectionClass $class classe visée
     * @return DataBaseObject[] tableau d'objet correpondant
     */
    public static function getAllFromClass( ReflectionClass $class ): array
    {
        $bdd = self::getBDD();

        $requete = $bdd->query("SELECT * FROM $class->name");

        $tab = array();

        while( ($obj = $requete->fetchObject($class->getName())) != null )
        {
            $obj->setObjects();
            array_push($tab, $obj);
        }

        return $tab;
    }

    /**
     * Récupère toutes les instance d'une class dans la base de donnée selon son nom
     * @param string $className nom de la classe visée
     * @return DataBaseObject[] tableau d'objet correpondant
     */
    public static function getAllFromClassName( string $className ): array
    {
        try
        {
            return self::getAllFromClass((new ReflectionClass($className)));
        }
        catch (ReflectionException $e)
        {
            return array();
        }
    }

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
        return connexionBD();
    }

    /**
     * @param int $id_bouteille L'identifiant de la bouteille voulue
     * @return Bouteille|null Objet de type Bouteille
     */
    public static function getBouteille(int $id_bouteille): ?Bouteille
    {
        $bdd = self::getBDD();
        $reponse = $bdd->query("SELECT * FROM bouteille where id_bouteille = $id_bouteille");

        $bouteille = $reponse->fetchObject(Bouteille::class);

        if( $bouteille === false )
            return null;

        $bouteille->setObjects();

        return $bouteille;
    }

    /**
     * @param int $id_appellation L'identifiant de l'appellation voulue
     * @return Appellation|null Objet de type Appellation
     */
    public static function getAppellation(int $id_appellation): ?Appellation
    {
        $bdd = self::getBDD();
        $reponse = $bdd->query("SELECT * FROM appellation where id_appellation = $id_appellation");

        $obj = $reponse->fetchObject(Appellation::class);

        return $obj === false ? null : $obj;
    }

    /**
     * @param int $id_categorie L'identifiant de la catégorie voulue
     * @return Categorie|null Objet de type Categorie
     */
    public static function getCategorie(int $id_categorie): ?Categorie
    {
        $bdd = self::getBDD();
        $reponse = $bdd->query("SELECT * FROM categorie where id_categorie = $id_categorie");

        $obj = $reponse->fetchObject(Categorie::class);

        return $obj === false ? null : $obj;
    }

    /**
     * @param int $id_oenologue L'identifiant de l'oenologue voulue
     * @return Oenologue|null Objet de type Oenologue
     */
    public static function getOenologue(int $id_oenologue): ?Oenologue
    {
        $bdd = self::getBDD();

        $reponse = $bdd->query("SELECT * FROM oenologue WHERE id_oenologue = $id_oenologue");

        $obj = $reponse->fetchObject(Oenologue::class);

        return $obj === false ? null : $obj;
    }

    /**
     * @param int $id_degustation L'identifiant de la dégustation voulue
     * @return Degustation|null Objet de type Dégustation
     */
    public static function getDegustation(int $id_degustation): ?Degustation
    {
        $bdd = self::getBDD();

        $reponse = $bdd->query("SELECT * FROM degustation WHERE id_degustation = $id_degustation");

        $obj = $reponse->fetchObject(Degustation::class);
        return $obj === false ? null : $obj;
    }

    /**
     * @param int $id_quantite
     * @return Quantite|null Objet de type Quantité
     */
    public static function getQuantite(int $id_quantite): ?Quantite
    {
        $bdd = self::getBDD();

        $reponse = $bdd->query("SELECT * FROM quantite WHERE id_quantite = $id_quantite");

        $obj = $reponse->fetchObject(Degustation::class);
        return $obj === false ? null : $obj;
    }

    public static function getNbInstanceOf( string $class ): int
    {
        try
        {
            $refClass = new ReflectionClass($class);

            $bdd = self::getBDD();

            $reponse = $bdd->query("SELECT count(id_$refClass->name) FROM $refClass->name");

            return $reponse->fetch()[0];
        }
        catch (Exception $e)
        {
            echo "Error: " . $e;

            return 0;
        }
    }

    public static function supprimer( DataBaseObject $obj ): bool
    {
        if( is_a($obj, Quantite::class) )
            throw new Exception("Une méthode spécial doit etre utilisé pour quantité car elle n'as pas d'id");

        $bdd = self::getBDD();

        $arraysColumnsName = $obj->getColumsName(false);
        $res = $bdd->exec("DELETE FROM " . $obj::class . " WHERE " . $arraysColumnsName[0] . " = " . $obj->getColumsValues()[$arraysColumnsName[0]] );

        return $res;
    }

    public static function supprimerQuantite( Quantite $qte ):bool
    {
        $bdd = self::getBDD();

        $arrayColumsvalue  = $qte->getColumsValues();

        $str = "DELETE FROM " . $qte::class . " WHERE ";

        foreach ( $arrayColumsvalue as $key => $value )
            $str .= $key . " = " . (is_string($value) ? "'$value'" : $value) . " AND ";

        $str = substr($str, 0, strlen($str) - 5); // enleve le dernier and

        echo $str;

        $res = $bdd->exec($str);

        return $res;
    }
}

/*$iterator = new DataBaseObjectIterator(Appellation::class);

echo "test: " . $iterator->count() . "<br/>";
foreach ($iterator as $bouteille)
{
    $bouteille->setObjects();
    echo $bouteille;
}*/