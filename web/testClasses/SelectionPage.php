<?php
    include_once "../includes/FonctionsUtiles.php";

    echo FonctionsUtiles::getDebutHTML("Accueil");

    $allFiles = scandir("../classes"); // En partant du principe que les class
// ont le même nom que le fichier dans lequel elle se trouve. (pas sensible a la case)

    echo "<center><h1>Que voulez vous faire?</h1></center>";
    echo "<table>";

    foreach ($allFiles as $fichier )
    {
        $fichier = substr($fichier, 0, -4);

        if( str_contains($fichier, "DataBase") || $fichier == "" ) continue;

        echo "<tr>";
        echo "<td>$fichier</td>";
        echo "<td><a href='AffichageTable.php?action=voir&table=$fichier'>Voir</a></td>";
        echo "<td><a href='AffichageTable.php?action=modifier&table=$fichier'>modifer</a></td>";
        echo "</tr>";
    }
    echo "</table>";

    echo FonctionsUtiles::getFinHTML();
?>
