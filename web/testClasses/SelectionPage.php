<?php
    include_once "../includes/FonctionsUtiles.php";

    FonctionsUtiles::getDebutHTML("Accueil");

    echo "<center><h1>Que voulez vous faire?</h1></center>";
    echo "<table>";
    echo "<tr>";
    echo "<td>Appellation</td>";
    echo "<td><a href='AffichageTable.php?action=voir&table=appellation'>Voir</a></td>";
    echo "<td><a href='AffichageTable.php?action=modifier&table=appellation'>modifer</a></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Bouteille</td>";
    echo "<td><a href='AffichageTable.php?action=voir&table=bouteille'>Voir</a></td>";
    echo "<td><a href='AffichageTable.php?action=modifier&table=bouteille'>modifer</a></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Catégorie</td>";
    echo "<td><a href='AffichageTable.php?action=voir&table=categorie'>Voir</a></td>";
    echo "<td><a href='AffichageTable.php?action=modifier&table=categorie'>modifer</a></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Dégustation</td>";
    echo "<td><a href='AffichageTable.php?action=voir&table=degustation'>Voir</a></td>";
    echo "<td><a href='AffichageTable.php?action=modifier&table=degustation'>modifer</a></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Oenologue</td>";
    echo "<td><a href='AffichageTable.php?action=voir&table=oenologue'>Voir</a></td>";
    echo "<td><a href='AffichageTable.php?action=modifier&table=oenologue'>modifer</a></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>quantité</td>";
    echo "<td><a href='AffichageTable.php?action=voir&table=quantite'>Voir</a></td>";
    echo "<td><a href='AffichageTable.php?action=modifier&table=quantite'>modifer</a></td>";
    echo "</tr>";
    echo "</table>";

    FonctionsUtiles::getFinHTML();
?>
