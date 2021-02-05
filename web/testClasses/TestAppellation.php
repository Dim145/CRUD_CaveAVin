<?php
    require_once "../classes/DataBaseObject.php";
    require_once "../classes/appellation.php";
    require_once "../includes/FonctionsUtiles.php";

    FonctionsUtiles::getDebutHTML("Test Appellation");
    $pdo = FonctionsUtiles::getBDD();


    $requete = $pdo->prepare("select * from Appellation");
    $requete->execute();

    $tab = $requete->fetchObject(Appellation::class);

    echo("<table>");
    while($tab != null)
    {
        echo($tab);
        $tab = $requete->fetchObject(Appellation::class);
    }
    echo("</table>");



    FonctionsUtiles::getBDD();
    FonctionsUtiles::getFinHTML();

?>