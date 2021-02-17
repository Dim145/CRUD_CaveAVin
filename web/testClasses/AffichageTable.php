<?php
    require_once "../Entite/DataBaseObject.php";
    require_once "../Entite/appellation.php";
    require_once "../Vue/AbstractVueRelation.php";
    require_once "../Vue/VueAppellation.php";
    require_once "../includes/FonctionsUtiles.php";

    session_start();

    $HTML = FonctionsUtiles::getDebutHTML("Test Appellation");

    if( !isset($_GET['table'])) die();
    else $_SESSION['table'] = $_GET['table'];

    $classeEntite = null;
    try
    {
        $classeEntite = new ReflectionClass(htmlspecialchars($_SESSION['table'])); // test si la table donnée existe.
        $classeVue = new ReflectionClass("Vue" . ucfirst($_SESSION['table']));
    }
    catch (ReflectionException $e)
    {
        echo "Vue" . ucfirst($_SESSION['table']);
        //header("Location: SelectionPage.php"); // sinon, retourne sur la selection des tables
    }

    // Bouton
    $HTML .=
        "<form action='..' class='enLigne'>
            <td><input type='SUBMIT' value='Menu' class='bouton boutonMenu'/></td>
         </form>";

    if(!isset($_GET['action']))
    {
        if($_GET['action'] == 'modifier')
        {
            $HTML .= "<form action=".$_SERVER['PHP_SELF']."?table=".$_SESSION['table'] ." method='POST' class='enLigne'/>";
            $HTML .=    "<input type='SUBMIT' name='actionSurTuple' value='Créer' class='bouton boutonCreer'/>";
            $HTML .= "</form>";
        }

        // ATTENTION, getAllFromClassName renvoie un tableau de DataBaseObjects.
        // Pour pouvoir utiliser / mofifier une colonne/valeur spécifique, il faut utiliser getColumsValues et/ou getColumsName
        $HTML .= "<div class='fondTableau'>"; // S'en débarasser avec Flo pour css----------------------------------------
        $Entites = FonctionsUtiles::getAllFromClassName(htmlspecialchars($_SESSION['table']));
        $vue = $classeVue->newInstance();
        if( count($Entites) > 0 )
        {
            $HTML .= $vue->getAllEntities($Entites);
        }
        $HTML .="</div>";
    }
    else
    {
        $obj = isset($_POST['PK']) ? FonctionsUtiles::getDataBaseObject($_SESSION['table'] , $_POST['PK']) : $classeEntite->newInstance();

        if($_POST['action'] == 'Supprimer')
        {
            $obj->setObjects();
            $HTML .= "objet supprimer = <br/>";
            $HTML .= "<table><tr>" . $obj . "</tr></table>";

            if( $classeEntite->getName() == Quantite::class ) FonctionsUtiles::supprimerQuantite($obj);
            else                                          FonctionsUtiles::supprimer($obj);

            header("Location: " . $_SERVER['PHP_SELF'] . "?table=".$_SESSION['table'] ."&action=modifier");
        }
        else if($_GET['action'] == 'ModifierEntite' || $_POST['actionSurTuple'] == 'Créer' )
        {
            $HTML .= "<form action=".$_SERVER['PHP_SELF']."?table=".$_SESSION['table'] ." method='POST'>";

            $HTML .= "<div class='fondTableau'><table>";
            $HTML .= $obj->toStringPageForm(isset($_POST['PK']));
            $HTML .= "<tr><td><input type='SUBMIT' name='actionSurTuple' value='Confirmer' class='bouton boutonCreer'/></td></tr>";
            $HTML .= "<table>";

            if( isset($_POST['PK']) )
                $HTML .= "<input type=\"HIDDEN\" name=\"ligne\" value=\"".$_POST['PK']."\"/>";

            $HTML .= "</form>";
            $HTML .= "</table></div>";
        }
        else if( $_POST['actionSurTuple'] == 'Confirmer' )
        {
            $HTML .= 'save obj...';

            if( !isset($_POST['PK']) ) // si c un nouveaux
                $obj->initAllVariables(); // permet aussi de réinitialiser l'objet si il n'est pas "vide". -> ne devrais pas arriver

            if( $classeEntite->getName() == Quantite::class )
            {
                $bouteille = FonctionsUtiles::getBouteille($_POST['id_bouteille']);

                $obj->setVolumeBouteille($bouteille->getVolumeBouteille());
                $obj->setMillesimeBouteille($bouteille->getMillesimeBouteille());
                $obj->setNomBouteille($bouteille->getNomBouteille());

                $obj->setQteBouteille($_POST['qte_bouteille']);
            }
            else
            {
                foreach ( $_POST as $key => $value )
                {
                    if( $key != 'Save' && $key != 'actionSurTuple' && $key != 'ligne' )
                    {
                        $properties = $classeEntite->getProperty($key);
                        $isAccessible = $properties->isPublic();

                        if( !$isAccessible ) $properties->setAccessible(true);

                        $properties->setValue($obj, $value);

                        if( !$isAccessible ) $properties->setAccessible(false);
                    }
                }
            }

            $obj->setObjects();
            $obj->saveInDB();

            $HTML .= "<table><tr>" . $obj . "</tr></table>" . $obj->getId();
            header("Location: " . $_SERVER['PHP_SELF'] . "?table=".$_SESSION['table'] ."&action=modifier");
        }
        else
        {
            $HTML .= 'error';
        }
    }
    $HTML .= FonctionsUtiles::getFinHTML();

    echo $HTML;
?>