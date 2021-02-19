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
use entite\Appellation;
use entite\Bouteille;
use entite\Categorie;
use entite\DataBaseObject;
use entite\Degustation;
use entite\Oenologue;
use entite\Quantite;
use Exception;
use PDO;
use ReflectionClass;
use ReflectionException;

/**
 * Class FonctionsUtiles
 */
class FonctionsSGBD
{
    private static ?PDO $bdd = null;


    /**
     * Récupère toutes les instance d'une class dans la base de donnée
     * @param ReflectionClass $class classe visée
     * @param string|null $orderBy
     * @return DataBaseObject[] tableau d'objet correpondant
     */
    public static function getAllFromClass(ReflectionClass $class, string $orderBy = "" ): array
    {
        $nom = strtolower($class->getName());
        $iterator = new entite\DataBaseObjectIterator($nom, $orderBy);

        $tab = array();
        foreach( $iterator as $tuple )
        {
            array_push($tab, $tuple);
        }

        return $tab;
    }

    /**
     * Récupère toutes les instance d'une class dans la base de donnée selon son nom
     * @param string $className nom de la classe visée
     * @return DataBaseObject[] tableau d'objet correpondant
     */
    public static function getAllFromClassName( string $className, string $orderBy = ""): array
    {
        try
        {
            return self::getAllFromClass((new ReflectionClass($className)), $orderBy);
        }
        catch (ReflectionException)
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
     * Cette méthode n'est pas récursive... C'est a cause de la table Quantite
     * Qui ne devrais meme pas exister. Cette table doit subir un traitement
     * spécifique, et donc ne peut pas etre traiter en lot de facon recursif.
     * TOUS LES GET d'objet au dessus ne devrais même pas exister de ce fait.
     *
     * @param string $objectClassName
     * @param $id
     * @return DataBaseObject|null
     */
    public static function getDataBaseObject(string $objectClassName, $id): ?entite\DataBaseObject
    {
        $bdd = self::getBDD();
        $class = null;

        try
        {
            $class = new ReflectionClass($objectClassName); //erreur si class inexistante

            $instanceExemple = $class->newInstance(); //erreur si class ininstenciable
            if ( !is_a($instanceExemple, DataBaseObject::class ) ) // erreur si n'est pas une DataBaseObject
                throw new Exception("La class donnée doit etre une instance de DatabaseObject");
        }
        catch (Exception) // récupère les differente erreurs prévu, qui indiquent que les types sont mauvais.
        {
            return null;
        }

        $requete = "SELECT * FROM " . $class->getShortName() . " WHERE ";

        $tabAllAttribute = $instanceExemple->getColumsName(false); // je sais que je suis sur un DataBaseObject grace au try.
        $nbId            = str_contains(strtolower($class->getShortName()), "quantite") ? 3 : 1;

        if( $nbId == 1 && is_string($id) ) return null; // dans le cas ou on envoi une chaine pour id, mais que l'objet n'est pas quantite.

        for ($cpt = 0; $cpt < $nbId; $cpt++ )
            $requete .= $tabAllAttribute[$cpt] . " = ? AND ";

        $reponse = $bdd->prepare(substr($requete, 0, -4)); // j'enleve le dernier And.
        $reponse->execute( $nbId == 1 ? array($id) : explode(",", $id) );

        return $reponse->fetchObject($class->getName());

        /*return match (strtolower($objectClassName))
        {
            strtolower(entite\Bouteille::class  ) => self::getBouteille($id),
            strtolower(entite\Appellation::class) => self::getAppellation($id),
            strtolower(entite\Categorie::class  ) => self::getCategorie($id),
            strtolower(entite\Degustation::class) => self::getDegustation($id),
            strtolower(entite\Oenologue::class  ) => self::getOenologue($id),
            strtolower(entite\Quantite::class   ) => self::getQuantite($id),

            default => null,
        };*/
    }

    public static function getNbInstanceOf( string $class ): int
    {
        try
        {
            $refClass = new ReflectionClass($class);
            $bdd = self::getBDD();
            $reponse = $bdd->query("SELECT count(*) FROM $refClass->name");

            return $reponse->fetch()[0];
        }
        catch (Exception $e)
        {
            //echo "Error: " . $e;

            return 0;
        }
    }

    public static function supprimer( entite\DataBaseObject $obj ): bool
    {
        if( is_a($obj, entite\Quantite::class) )
            throw new Exception("Une méthode spécial doit etre utilisé pour quantité car elle n'as pas d'id");

        $bdd = self::getBDD();

        $arraysColumnsName = $obj->getColumsName(false);
        $res = $bdd->exec("DELETE FROM " . (new ReflectionClass($obj))->getShortName() . " WHERE " . $arraysColumnsName[0] . " = " . $obj->getColumsValues()[$arraysColumnsName[0]] );

        return $bdd->exec("DELETE FROM " . (new ReflectionClass($obj))->getShortName() . " WHERE " . $arraysColumnsName[0] . " = " . $obj->getColumsValues()[$arraysColumnsName[0]] );
    }

    public static function supprimerQuantite( entite\Quantite $qte ):bool
    {
        $bdd = self::getBDD();

        $arrayColumsvalue  = $qte->getColumsValues();

        $str = "DELETE FROM " . (new ReflectionClass($qte))->getShortName() . " WHERE ";

        foreach ( $arrayColumsvalue as $key => $value )
            $str .= $key . " = " . (is_string($value) ? "'$value'" : $value) . " AND ";

        $str = substr($str, 0, strlen($str) - 5); // enleve le dernier and

        //echo $str;

        return $bdd->exec($str);
    }
}


$object = FonctionsSGBD::getDataBaseObject(Quantite::class, "Blanc Essence,300,1997");
$object = FonctionsSGBD::getDataBaseObject(Appellation::class, "Blanc Essence,300,1997");
if( $object != null )
    $object->setObjects();

echo $object;