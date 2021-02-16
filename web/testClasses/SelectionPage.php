<?php
    include_once "../includes/FonctionsUtiles.php";

    echo FonctionsUtiles::getDebutHTML("Accueil");

    $allFiles = scandir("../classes"); // En partant du principe qu'une class
// a le même nom que le fichier dans lequel elle se trouve. (pas sensible a la case)

    echo "<center><h1>Que voulez vous faire?</h1></center>";
    echo"<div class='fondTableau'>";
    echo "<table>";

    foreach ($allFiles as $fichier )
    {
        $fichier = substr($fichier, 0, stripos($fichier, ".")); // retire l'extension a la fin

        if( str_contains($fichier, "DataBase") || $fichier == "" ) continue;
        // $fichier est vide si il est = a . ou .. => c'est a dire aux rep courant et parent.

        echo "<tr>";
        echo "<td>$fichier</td>";
        echo "<td><a href='AffichageTable.php?action=voir&table=$fichier'>Voir</a></td>";
        echo "<td><a href='AffichageTable.php?action=modifier&table=$fichier'>modifer</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo"</div>";

    echo FonctionsUtiles::getFinHTML();
?>
