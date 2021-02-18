<?php
namespace sgbd;

require_once "../connexionPerso.php";
require_once "../Entite/DataBaseObject.php";
require_once "../Entite/degustation.php";
require_once "../Entite/quantite.php";
require_once "../Entite/bouteille.php";
require_once "../Entite/appellation.php";
require_once "../Entite/categorie.php";
require_once "../Entite/oenologue.php";
require_once "../Entite/DataBaseObjectIterator.php";

use entite;

/**
 * Class FonctionsUtiles
 */
class FonctionsSGBD
{
    private static ?\PDO $bdd = null;


    /**
     * Récupère toutes les instance d'une class dans la base de donnée
     * @param ReflectionClass $class classe visée
     * @return DataBaseObject[] tableau d'objet correpondant
     */
    public static function getAllFromClass( \ReflectionClass $class ): array
    {
        $bdd = self::getBDD();

        $nom = $class->getShortName();
        $requete = $bdd->query("SELECT * FROM $nom");

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
            return self::getAllFromClass((new \ReflectionClass($className)));
        }
        catch (\ReflectionException $e)
        {
            return array();
        }
    }

    /**
     * Retourne une PDO déjà instanciée ou en instancie une avant de la retourner
     * @return PDO L'instance actuelle de PDO
     */
    public static function getBDD(): \PDO
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
    public static function connexionBD(): \PDO
    {
        return connexionBD();
    }

    /**
     * @param int $id_bouteille L'identifiant de la bouteille voulue
     * @return Bouteille|null Objet de type Bouteille
     */
    public static function getBouteille(int $id_bouteille): ?entite\Bouteille
    {
        $bdd = self::getBDD();
        $reponse = $bdd->query("SELECT * FROM bouteille where id_bouteille = $id_bouteille");

        $bouteille = $reponse->fetchObject(entite\Bouteille::class);

        if( $bouteille === false ) return null;

        $bouteille->setObjects();

        return $bouteille;
    }

    /**
     * @param int $id_appellation L'identifiant de l'appellation voulue
     * @return Appellation|null Objet de type Appellation
     */
    public static function getAppellation(int $id_appellation): ?entite\Appellation
    {
        $bdd = self::getBDD();
        $reponse = $bdd->query("SELECT * FROM appellation where id_appellation = $id_appellation");

        $obj = $reponse->fetchObject(entite\Appellation::class);

        return $obj === false ? null : $obj;
    }

    /**
     * @param int $id_categorie L'identifiant de la catégorie voulue
     * @return Categorie|null Objet de type Categorie
     */
    public static function getCategorie(int $id_categorie): ?entite\Categorie
    {
        $bdd = self::getBDD();
        $reponse = $bdd->query("SELECT * FROM categorie where id_categorie = $id_categorie");

        $obj = $reponse->fetchObject(entite\Categorie::class);

        return $obj === false ? null : $obj;
    }

    /**
     * @param int $id_oenologue L'identifiant de l'oenologue voulue
     * @return Oenologue|null Objet de type Oenologue
     */
    public static function getOenologue(int $id_oenologue): ?entite\Oenologue
    {
        $bdd = self::getBDD();

        $reponse = $bdd->query("SELECT * FROM oenologue WHERE id_oenologue = $id_oenologue");

        $obj = $reponse->fetchObject(entite\Oenologue::class);

        return $obj === false ? null : $obj;
    }

    /**
     * @param int $id_degustation L'identifiant de la dégustation voulue
     * @return Degustation|null Objet de type Dégustation
     */
    public static function getDegustation(int $id_degustation): ?entite\Degustation
    {
        $bdd = self::getBDD();

        $reponse = $bdd->query("SELECT * FROM degustation WHERE id_degustation = $id_degustation");

        $obj = $reponse->fetchObject(entite\Degustation::class);
        return $obj === false ? null : $obj;
    }

    /**
     * NE DEVRAIS PAS EXISTER. Mais comme la class Quantite ne possede pas
     * d'attribut de type "id", nous ne pouvons pas utiliser la recursivité pour celle-ci.
     *
     * @param string $ids_quantite sous forme nom_bouteille,volume_bouteille,millesime_bouteille
     * @return Quantite|null Objet de type Quantité
     */
    public static function getQuantite(string $ids_quantite): ?entite\Quantite
    {
        $bdd = self::getBDD();

        $reponse = $bdd->prepare("SELECT * FROM quantite WHERE nom_bouteille = ? AND ".
        "volume_bouteille = ? AND millesime_bouteille = ?");

        $reponse->execute(explode(",", $ids_quantite));

        $obj = $reponse->fetchObject(entite\Quantite::class);
        return $obj === false ? null : $obj;
    }

    /**
     * @param string $objectClassName
     * @param $id
     * @return DataBaseObject|null
     */
    public static function getDataBaseObject(string $objectClassName, $id): ?entite\DataBaseObject
    {
        return match (strtolower($objectClassName))
        {
            cstrtolower(entite\Bouteille::class) => self::getBouteille($id),
            strtolower(entite\Appellation::class)=> self::getAppellation($id),
            strtolower(entite\Categorie::class)  => self::getCategorie($id),
            strtolower(entite\Degustation::class)=> self::getDegustation($id),
            strtolower(entite\Oenologue::class)  => self::getOenologue($id),
            strtolower(entite\Quantite::class)   => self::getQuantite($id),

            default => null,
        };
    }

    public static function getNbInstanceOf( string $class ): int
    {
        try
        {
            $refClass = new \ReflectionClass($class);
            $bdd = self::getBDD();
            $reponse = $bdd->query("SELECT count(*) FROM $refClass->name");

            return $reponse->fetch()[0];
        }
        catch (\Exception $e)
        {
            //echo "Error: " . $e;

            return 0;
        }
    }

    public static function supprimer( entite\DataBaseObject $obj ): bool
    {
        if( is_a($obj, entite\Quantite::class) )
            throw new \Exception("Une méthode spécial doit etre utilisé pour quantité car elle n'as pas d'id");

        $bdd = self::getBDD();

        $arraysColumnsName = $obj->getColumsName(false);
        $res = $bdd->exec("DELETE FROM " . (new \ReflectionClass($obj))->getShortName() . " WHERE " . $arraysColumnsName[0] . " = " . $obj->getColumsValues()[$arraysColumnsName[0]] );

        return $bdd->exec("DELETE FROM " . $obj::class . " WHERE " . $arraysColumnsName[0] . " = " . $obj->getColumsValues()[$arraysColumnsName[0]] );
    }

    public static function supprimerQuantite( entite\Quantite $qte ):bool
    {
        $bdd = self::getBDD();

        $arrayColumsvalue  = $qte->getColumsValues();

        $str = "DELETE FROM " . (new \ReflectionClass(obj))->getShortName() . " WHERE ";

        foreach ( $arrayColumsvalue as $key => $value )
            $str .= $key . " = " . (is_string($value) ? "'$value'" : $value) . " AND ";

        $str = substr($str, 0, strlen($str) - 5); // enleve le dernier and

        //echo $str;

        return $bdd->exec($str);
    }
}

/*$iterator = new DataBaseObjectIterator(Quantite::class);
$quantite = new Quantite();
$quantite->setNomBouteille("Nos Racines - Famille Raymond");
$quantite->setMillesimeBouteille(2017);
$quantite->setVolumeBouteille(75);
$quantite->setQteBouteille(51);
$quantite->saveInDB();

echo "test: " . $iterator->count() . "<br/>";
foreach ($iterator as $bouteille)
{
    $bouteille->setObjects();
    echo $bouteille;
}*/