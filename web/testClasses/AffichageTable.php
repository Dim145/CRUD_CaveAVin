<?php
    require_once "../classes/DataBaseObject.php";
    require_once "../classes/appellation.php";
    require_once "../includes/FonctionsUtiles.php";

    echo FonctionsUtiles::getDebutHTML("Test Appellation");

    if( !isset($_GET['table'])) die();

    if(!isset($_POST['actionSurTuple']))
    {
        if($_GET['action'] == 'modifier')
        {
            echo "<form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST'>";
            echo    "<td><input type='SUBMIT' name='actionSurTuple' value='Creer' /></td>";
            echo "</form>";
        }

        // ATTENTION, getAllFromClassName renvoie un tableau de DataBaseObjects.
        // Pour pouvoir utiliser / mofifier une colonne/valeur spécifique, il faut utiliser getColumsValues et/ou getColumsName
        echo("<table>");
        $tab = FonctionsUtiles::getAllFromClassName(htmlspecialchars($_GET['table']));

        if( count($tab) > 0 )
        {
            $colums = $tab[0]->getColumsName(true);
            echo "<tr>";
            foreach ( $colums as $col )
                if( !str_contains($col, "id") )
                    echo "<th>" . $col . "</th>";
            echo "</tr>";
        }

        $i = 1;

        foreach ( $tab as $obj )
        {
            echo "<tr>";
            echo $obj;
            if($_GET['action'] == 'modifier')
            {
                echo "<form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST'>";
                echo    "<td><input type='SUBMIT' name='actionSurTuple' value='Modifier' /></td>";
                echo    "<input     type='HIDDEN' name='ligne'          value='".$obj->getId()."'   />";
                echo    "<td><input type='SUBMIT' name='actionSurTuple' value='Supprimer'/></td>";
                echo "</form>";
            }
            $i++;
            echo "</tr>";
        }
        echo("</table>");
    }
    else
    {
        $instance = new ReflectionClass($_GET['table']);
        $obj      = isset($_POST['ligne']) ? FonctionsUtiles::getDataBaseObject($_GET['table'], $_POST['ligne']) : $instance->newInstance();

        if($_POST['actionSurTuple'] == 'Supprimer')
        {
            if( $instance->getName() == Quantite::class ) FonctionsUtiles::supprimerQuantite($obj);
            else                                          FonctionsUtiles::supprimer($obj);

            echo "objet supprimer = <br/>";
            echo "<table><tr>" . $obj . "</tr></table>";

            header("Location: " . $_SERVER['PHP_SELF'] . "?table=".$_GET['table']."&action=modifier");
        }
        else if( $_POST['actionSurTuple'] == 'Modifier' || $_POST['actionSurTuple'] == 'Creer' )
        {
            echo "<form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST'>";

            echo "<table>";
            echo $obj->toStringPageForm(isset($_POST['ligne']));
            echo "<tr><td><input type='SUBMIT' name='actionSurTuple' value='Save'/></td></tr>";
            echo "<table>";

            if( isset($_POST['ligne']) )
                echo "<input type=\"HIDDEN\" name=\"ligne\" value=\"".$_POST['ligne']."\"/>";

            echo "</form>";
        }
        else if( $_POST['actionSurTuple'] == 'Save' )
        {
            echo 'save obj...';

            if( !isset($_POST['ligne']) ) // si c un nouveaux
                $obj->initAllVariables(); // permet aussi de réinitialiser l'objet si il n'est pas "vide". -> ne devrais pas arriver

            foreach ( $_POST as $key => $value )
            {
                if( $key != 'Save' && $key != 'actionSurTuple' && $key != 'ligne' )
                {
                    $properties = $instance->getProperty($key);
                    $isAccessible = $properties->isPublic();

                    if( !$isAccessible ) $properties->setAccessible(true);

                    $properties->setValue($obj, $value);

                    if( !$isAccessible ) $properties->setAccessible(false);
                }
            }

            $obj->setObjects();
            $obj->saveInDB();

            echo "<table><tr>" . $obj . "</tr></table>" . $obj->getId();
            header("Location: " . $_SERVER['PHP_SELF'] . "?table=".$_GET['table']."&action=modifier");
        }
        else
        {
            echo 'error';
        }
    }
    echo FonctionsUtiles::getFinHTML();

?>