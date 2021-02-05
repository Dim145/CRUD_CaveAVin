<?php
    require_once "../classes/DataBaseObject.php";
    require_once "../classes/appellation.php";
    require_once "../includes/FonctionsUtiles.php";

    echo FonctionsUtiles::getDebutHTML("Test Appellation");
    $pdo = FonctionsUtiles::getBDD();

    if( !isset($_GET['table'])) die();

    // ATTENTION, getAllFromClassName renvoie un tableau de DataBaseObjects.
    // Pour pouvoir utiliser / mofifier une colonne/valeur spécifique, il faut utiliser getColumsValues et/ou getColumsName
    echo("<table>");
    $tab = FonctionsUtiles::getAllFromClassName(htmlspecialchars($_GET['table']));
    foreach ( $tab as $obj ) echo $obj;
    echo("</table>");

    echo FonctionsUtiles::getFinHTML();

?>