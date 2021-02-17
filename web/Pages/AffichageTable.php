<?php
require_once "../Entite/DataBaseObject.php";
require_once "../Entite/appellation.php";
require_once "../Vue/AbstractVueRelation.php";
require_once "../Vue/VueAppellation.php";
require_once "../Vue/VueDegustation.php";
require_once "../Vue/VueCategorie.php";
require_once "../Vue/VueBouteille.php";
require_once "../Vue/VueOenologue.php";
require_once "../Vue/VueQuantite.php";
require_once "../SGBD/FonctionsSGBD.php";

echo AbstractVueRelation::getDebutHTML("Test Appellation");

if( !isset($_GET['table'])) die();

$entiteClasse = null;
$vueClasse = null;
try
{
    $entiteClasse = new ReflectionClass(htmlspecialchars($_GET['table'])); // test si la table donnée existe.
    $vueClasse = new ReflectionClass("Vue".ucfirst($_GET['table']));
}
catch (ReflectionException $e)
{
    header("Location: SelectionPage.php"); // sinon, retourne sur la selection des tables
}

echo "<form action='..' class='enLigne'>
            <td><input type='SUBMIT' value='Menu' class='bouton boutonMenu'/></td>
          </form>";

if(!isset($_POST['actionSurTuple']))
{
    echo "<form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST' class='enLigne'/>";
    echo    "<input type='SUBMIT' name='actionSurTuple' value='Créer' class='bouton boutonCreer'/>";
    echo "</form>";

    // ATTENTION, getAllFromClassName renvoie un tableau de DataBaseObjects.
    // Pour pouvoir utiliser / mofifier une colonne/valeur spécifique, il faut utiliser getColumsValues et/ou getColumsName
    $Entities = FonctionsSGBD::getAllFromClassName(htmlspecialchars($_GET['table']));
    $vue = $vueClasse->newInstance();
    echo $vue->getAllEntities($Entities);

}
else
{
    $obj = isset($_POST['PK']) ? FonctionsSGBD::getDataBaseObject($_GET['table'], $_POST['PK']) : $entiteClasse->newInstance();

    switch($_POST['actionSurTuple']){
        case 'Supprimer':
            $obj->setObjects();
            echo "objet supprimer = <br/>";
            echo "<table><tr>" . $obj . "</tr></table>";
            if( $entiteClasse->getName() == Quantite::class ) FonctionsSGBD::supprimerQuantite($obj);
            else                                          FonctionsSGBD::supprimer($obj);
            header("Location: " . $_SERVER['PHP_SELF'] . "?table=".$_GET['table']."&action=modifier");
            break;
        case 'Modifier':
        case 'Créer':
            $vue = $vueClasse->newInstance();
            echo $vue->getForm4Entity($obj,isset($_POST['PK']));
            echo "<a class='bouton' href='AffichageTable.php?table=". $_GET['table'] ."'>Annuler</a>";
            break;

        case 'Confirmer':
            echo 'save obj...';

            if( !isset($_POST['PK']) ) // si c'est un nouveaux
                $obj->initAllVariables(); // permet aussi de réinitialiser l'objet si il n'est pas "vide". -> ne devrait pas arriver

            if($entiteClasse->getName() == Quantite::class)
            {
                $bouteille = FonctionsSGBD::getBouteille($_POST['id_bouteille']);
                $obj->setVolumeBouteille($bouteille->getVolumeBouteille());
                $obj->setMillesimeBouteille($bouteille->getMillesimeBouteille());
                $obj->setNomBouteille($bouteille->getNomBouteille());
                $obj->setQteBouteille($_POST['qte_bouteille']);
            }
            else
            {
                foreach ( $_POST as $key => $value )
                {
                    if($key != 'Save' && $key != 'actionSurTuple' && $key != 'PK')
                    {
                        echo "<h1>".$key."</h1>";
                        $properties = $entiteClasse->getProperty($key);
                        $isAccessible = $properties->isPublic();

                        if( !$isAccessible ) $properties->setAccessible(true);

                        $properties->setValue($obj, $value);

                        if( !$isAccessible ) $properties->setAccessible(false);
                    }
                }
            }

            $obj->setObjects();
            $obj->saveInDB();

            echo "<table><tr>" . $obj . "</tr></table>" . $obj->getId();
            header("Location: " . $_SERVER['PHP_SELF'] . "?table=".$_GET['table']."&action=modifier");
            break;
        default:
            echo 'error';
            break;
    }
}
echo AbstractVueRelation::getFinHTML();

?>