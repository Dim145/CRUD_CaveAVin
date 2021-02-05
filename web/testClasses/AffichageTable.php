<?php
    require_once "../classes/DataBaseObject.php";
    require_once "../classes/appellation.php";
    require_once "../includes/FonctionsUtiles.php";

    FonctionsUtiles::getDebutHTML("Test Appellation");
    $pdo = FonctionsUtiles::getBDD();


    $requete = $pdo->prepare("select * from " . $_GET['table']);
    $requete->execute();

    $tab = FonctionsUtiles::faireFetch($_GET['table'], $requete);

    echo("<table>");
    while($tab != null)
    {
        echo($tab);
        $tab = FonctionsUtiles::faireFetch($_GET['table'], $requete);
    }
    echo("</table>");



    FonctionsUtiles::getBDD();
    FonctionsUtiles::getFinHTML();

?>