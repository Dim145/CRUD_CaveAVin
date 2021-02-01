<?php
    require_once "../classes/bouteille.php";
    require_once "../classes/appellation.php";
    require_once "../classes/categorie.php";

    function connexionBD(): PDO
    {
        return new PDO('pgsql:host=postgresql-cavevin.alwaysdata.net;dbname=cavevin_base1', 'cavevin', 'iYMYpR7X@X@$qPDN', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }

    function getBouteille( int $id_bouteille ): Bouteille
    {
        $bdd = connexionBD();
        $reponse = $bdd->query("SELECT * FROM bouteille where id_bouteille = " . $id_bouteille);

        $bouteille = $reponse->fetchObject(Bouteille::class );
        $bouteille->setObjects();

        return $bouteille;
    }

    function getAppellation( int $id_appellation ): Appellation
    {
        $bdd = connexionBD();
        $reponse = $bdd->query("SELECT * FROM appellation where id_appellation = " . $id_appellation);

        return $reponse->fetchObject(Appellation::class );
    }

    function getCategorie( int $id_categorie ): Categorie
    {
        $bdd = connexionBD();
        $reponse = $bdd->query("SELECT * FROM categorie where id_categorie = " . $id_categorie);

        return $reponse->fetchObject(Categorie::class );
    }

    echo getBouteille(1);