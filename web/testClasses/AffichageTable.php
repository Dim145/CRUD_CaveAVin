<?php
    require_once "../classes/DataBaseObject.php";
    require_once "../classes/appellation.php";
    require_once "../includes/FonctionsUtiles.php";

    echo FonctionsUtiles::getDebutHTML("Test Appellation");
    $pdo = FonctionsUtiles::getBDD();

    if( !isset($_GET['table'])) die();

    echo("<table>");
    $tab = FonctionsUtiles::getAllFromClassName($_GET['table']);
    foreach ( $tab as $obj ) echo $obj;
    echo("</table>");

    echo FonctionsUtiles::getFinHTML();

?>