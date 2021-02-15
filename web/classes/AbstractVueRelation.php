<?php


abstract class AbstractVueRelation
{
    public function getDebutHTML(string $titre) : string {
        return
            "<html lang=\"fr\">
                    <head>
                        <title>$titre</title>
                        <link href='../style/style.css' rel='stylesheet' type='text/css'/>
                    </head>
                    <body>";
    }

    public function getFinHTML() : string {
        return
            "</body>
            </html>";
    }

    public abstract function getHTML4Entity(DataBaseObject $e) : string;

    public abstract function getAllEntities(array $Entities) : string;

    public abstract function getForm4Entity(DataBaseObject $e, bool $isForModifier) : string;
}