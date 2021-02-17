<?php
    include_once "../SGBD/FonctionsSGBD.php";
    include_once "../Vue/AbstractVueRelation.php";

    echo AbstractVueRelation::getDebutHTML("Accueil");

    $allFiles = scandir("../Entite"); // En partant du principe qu'une class
// a le même nom que le fichier dans lequel elle se trouve. (pas sensible a la case)

    echo "<center><h1>Base de données: Cave à vin</h1></center>";
echo "<center><h2>Selectionnez une table</h2></center>";
    echo"<div class='fondTableau'>";
    echo "<table>";

    foreach ($allFiles as $fichier )
    {
        $fichier = substr($fichier, 0, stripos($fichier, ".")); // retire l'extension a la fin

        if( str_contains($fichier, "DataBase") || $fichier == "" ) continue;
        // $fichier est vide si il est = a . ou .. => c'est a dire aux rep courant et parent.
        echo "<tr>";
        echo "<td>$fichier</td>";
        echo "<td><a href='AffichageTable.php?table=$fichier'>Consulter</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo"</div>";

    echo AbstractVueRelation::getFinHTML();
?>
