<?php

    function connexionBD(): PDO
    {
        return new PDO('pgsql:host=postgresql-cavevin.alwaysdata.net;dbname=cavevin_base1', 'cavevin', 'iYMYpR7X@X@$qPDN', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }