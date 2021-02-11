<?php
    include_once "../includes/FonctionsUtiles.php";

    echo FonctionsUtiles::getDebutHTML("Accueil");

    echo "<center><h1>Que voulez vous faire?</h1></center>";
    echo "<table>";
    echo "<tr>";
    echo "<td>Appellation</td>";
    echo "<td><a href='AffichageTable.php?action=voir&table=".Appellation::class."'>Voir</a></td>";
    echo "<td><a href='AffichageTable.php?action=modifier&table=".Appellation::class."'>modifer</a></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Bouteille</td>";
    echo "<td><a href='AffichageTable.php?action=voir&table=".Bouteille::class."'>Voir</a></td>";
    echo "<td><a href='AffichageTable.php?action=modifier&table=".Bouteille::class."'>modifer</a></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Catégorie</td>";
    echo "<td><a href='AffichageTable.php?action=voir&table=".Categorie::class."'>Voir</a></td>";
    echo "<td><a href='AffichageTable.php?action=modifier&table=".Categorie::class."'>modifer</a></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Dégustation</td>";
    echo "<td><a href='AffichageTable.php?action=voir&table=".Degustation::class."'>Voir</a></td>";
    echo "<td><a href='AffichageTable.php?action=modifier&table=".Degustation::class."'>modifer</a></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Oenologue</td>";
    echo "<td><a href='AffichageTable.php?action=voir&table=".Oenologue::class."'>Voir</a></td>";
    echo "<td><a href='AffichageTable.php?action=modifier&table=".Oenologue::class."'>modifer</a></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>quantité</td>";
    echo "<td><a href='AffichageTable.php?action=voir&table=".Quantite::class."'>Voir</a></td>";
    echo "<td><a href='AffichageTable.php?action=modifier&table=".Quantite::class."'>modifer</a></td>";
    echo "</tr>";
    echo "</table>";

    echo FonctionsUtiles::getFinHTML();
?>
