<?php
namespace pages;
use vues;
use sgbd;
use entite;

require_once "../Vue/AbstractVueRelation.php";
require_once "../Vue/VueAppellation.php";
require_once "../Vue/VueDegustation.php";
require_once "../Vue/VueCategorie.php";
require_once "../Vue/VueBouteille.php";
require_once "../Vue/VueOenologue.php";
require_once "../Vue/VueQuantite.php";
require_once "../SGBD/FonctionsSGBD.php";



echo vues\AbstractVueRelation::getDebutHTML("Test Appellation");

if( !isset($_GET['table'])) die();

$entiteClasse = null;
$vueClasse    = null;

try
{
    $entiteClasse = new \ReflectionClass("entite\\".htmlspecialchars($_GET['table'])); // test si la table donnée existe.
    $vueClasse    = new \ReflectionClass("vues\\Vue".ucfirst($_GET['table']));
}
catch (\ReflectionException $e)
{
    header("Location: SelectionPage.php"); // sinon, retourne sur la selection des tables
}

echo "<form action='..' class='enLigne'>
            <td><input type='SUBMIT' value='Menu' class='bouton boutonMenu'/></td>
      </form>";

if(!isset($_POST['actionSurTuple']))
{

    echo "<form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST' class='enLigne'/>";
    echo "    <input type='SUBMIT' name='actionSurTuple' value='Créer' class='bouton boutonCreer'/>";
    echo "</form>";

    // ATTENTION, getAllFromClassName renvoie un tableau de DataBaseObjects.
    // Pour pouvoir utiliser / mofifier une colonne/valeur spécifique, il faut utiliser getColumsValues et/ou getColumsName
    $Entities = sgbd\FonctionsSGBD::getAllFromClassName(htmlspecialchars("entite\\".$_GET['table']), isset($_GET['orderBy']) ? htmlspecialchars($_GET['orderBy']) : "");
    $vue = $vueClasse->newInstance();
    echo $vue->getAllEntities($Entities);
}
else
{
    $obj = isset($_POST['PK']) ? sgbd\FonctionsSGBD::getDataBaseObject($_GET['table'], $_POST['PK']) : $entiteClasse->newInstance();

    switch($_POST['actionSurTuple'])
    {
        case 'Supprimer':
            $obj->setObjects();

            echo "objet supprimer = <br/>";
            echo "<table><tr>" . $obj . "</tr></table>";
            if( $entiteClasse->getName() == entite\Quantite::class ) sgbd\FonctionsSGBD::supprimerQuantite($obj);
            else                                                     sgbd\FonctionsSGBD::supprimer($obj);
            header("Location: " . $_SERVER['HTTP_REFERER']);
        break;

        case 'Modifier':
        case 'Créer':
            $vue = $vueClasse->newInstance();

            echo $vue->getForm4Entity($obj,isset($_POST['PK']));
            echo "<a class='bouton' href=\"".$_SERVER['HTTP_REFERER']."\">Annuler</a>";
        break;

        case 'Confirmer':
            echo 'sauvegarde du tuple...';

            if( !isset($_POST['PK']) ) // si c'est un nouveaux
                $obj->initAllVariables(); // permet aussi de réinitialiser l'objet si il n'est pas "vide". -> ne devrait pas arriver

            if($entiteClasse->getName() == entite\Quantite::class)
            {
                $bouteille = sgbd\FonctionsSGBD::getBouteille($_POST['id_bouteille']);
                $obj->setVolumeBouteille($bouteille->getVolumeBouteille());
                $obj->setMillesimeBouteille($bouteille->getMillesimeBouteille());
                $obj->setNomBouteille($bouteille->getNomBouteille());
                $obj->setQteBouteille($_POST['qte_bouteille']);
            }
            else
            {
                foreach ( $_POST as $key => $value )
                {
                    if($key != 'Save' && $key != 'actionSurTuple' && $key != 'PK' && $key != 'referer')
                    {
                        $properties = $entiteClasse->getProperty($key);
                        $isAccessible = $properties->isPublic();

                        if( !$isAccessible ) $properties->setAccessible(true);

                        $properties->setValue($obj, $value);

                        if( !$isAccessible ) $properties->setAccessible(false);
                    }
                }
            }

            try
            {
                $obj->setObjects();
                $obj->saveInDB();

                header("Location: " . $_SERVER['HTTP_REFERER'] );
            }
            catch(PDOException $e)
            {
                echo "<div class='messageErreur'><h1>Erreur lors de l'édition de la base de données : </h1>";
                echo "<p>".$e->getMessage()."</p></div>";
                echo "<a class='bouton' href='".$_SERVER['HTTP_REFERER']."'>Annuler</a>";
            }
        break;
        default: echo 'error';
    }
}
echo vues\AbstractVueRelation::getFinHTML();