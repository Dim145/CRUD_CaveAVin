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
        if($_POST['actionSurTuple'] == 'supprimer')
        {
            echo "Suppression : ".$_POST['actionSurTuple'].$_POST['ligne'];
        }
        else
        {
            echo "<form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST'>";

            $instance = new ReflectionClass($_GET['table']);
            $obj      = isset($_POST['ligne']) ? FonctionsUtiles::getDataBaseObject($_GET['table'], $_POST['ligne']) : $instance->newInstance();

            echo "<table>";
            echo $obj->toStringPageForm(isset($_POST['ligne']));
            echo "<tr><td><input type='SUBMIT' name='Valider' value='OK'/></td></tr>";
            echo "<table>";

            echo "</form>";
        }
    }
    echo FonctionsUtiles::getFinHTML();

?>