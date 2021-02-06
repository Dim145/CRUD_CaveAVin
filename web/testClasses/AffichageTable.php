<?php
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

    echo FonctionsUtiles::getFinHTML();

?>