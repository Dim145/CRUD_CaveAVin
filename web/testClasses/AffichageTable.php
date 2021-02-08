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
    foreach ( $tab as $obj )
    {
        echo "<tr>";
        echo $obj;
        if($_GET['action'] == 'modifier')
        {
            echo "<form action=".$_SERVER['PHP_SELF']." method='POST'>";
            echo    "<td><input type='SUBMIT' name='ActionSurTuple' value='Modifier'/></td>";
            echo    "<td><input type='SUBMIT' name='ActionSurTuple' value='Supprimer'/></td>";
            echo "</form>";
        }
        echo "</tr>";
    }
    echo("</table>");

    echo FonctionsUtiles::getFinHTML();

?>