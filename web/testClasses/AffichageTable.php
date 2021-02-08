<?php
    require_once "../classes/DataBaseObject.php";
    require_once "../classes/appellation.php";
    require_once "../includes/FonctionsUtiles.php";

    echo FonctionsUtiles::getDebutHTML("Test Appellation");

    if( !isset($_GET['table'])) die();

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

    foreach ( $tab as $obj ) echo $obj;
    echo("</table>");

    if(!isset($_POST['actionSurTuple']))
    {
        // ATTENTION, getAllFromClassName renvoie un tableau de DataBaseObjects.
        // Pour pouvoir utiliser / mofifier une colonne/valeur spécifique, il faut utiliser getColumsValues et/ou getColumsName
        echo("<table>");
        $tab = FonctionsUtiles::getAllFromClassName(htmlspecialchars($_GET['table']));
        $i = 1;
        foreach ( $tab as $obj )
        {
            echo "<tr>";
            echo $obj;
            if($_GET['action'] == 'modifier')
            {
                echo "<form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST'>";
                echo    "<td><input type='SUBMIT' name='actionSurTuple' value='Modifier' /></td>";
                echo    "<input     type='HIDDEN' name='ligne'          value='".$i."'   />";
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
        echo $_POST['actionSurTuple'].$_POST['ligne'];
    }
    echo FonctionsUtiles::getFinHTML();

?>