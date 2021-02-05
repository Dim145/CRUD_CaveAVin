<?php

class Quantite extends DataBaseObject
{
    private string $nom_bouteille;
    private int    $volume_bouteille;
    private int    $millesime_bouteille;
    private int    $qte_bouteille;


    function saveInDB(): void
    {
        // TODO: Implement saveInDB() method.
    }

    function __toString(): string
    {
        return "<tr><td>" . $this->nom_bouteille       . "</td><td>" . $this->volume_bouteille . "</td><td>"
                          . $this->millesime_bouteille . "</td><td>" . $this->qte_bouteille    . "</td></tr>";
    }

    public function getColumsName(): array
    {
        $allAtribute = $this->getReflexion()->getProperties(ReflectionProperty::IS_PRIVATE);

        $colums = array();

        foreach ( $allAtribute as $attribute )
            array_push($colums, $attribute->getName());

        return $colums;
    }
}