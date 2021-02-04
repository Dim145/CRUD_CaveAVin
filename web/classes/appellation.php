<?php

class Appellation extends DataBaseObject
{
    private int $id_appellation;
    private string $nom_appellation;
    private string $categorie_appellation;

    public function get_id_appellation(): int
    {
        return $this->id_appellation;
    }

    public function set_id_appellation(string $id_appellation)
    {
        $this->id_appellation = $id_appellation;
    }

    public function get_nom_appellation(): string
    {
        return $this->nom_appellation;
    }

    public function set_nom_appellation(string $nom_appellation)
    {
        $this->nom_appellation = $nom_appellation;
    }

    public function get_categorie_appellation(): string
    {
        return $this->categorie_appellation;
    }

    public function set_categorie_appellation(string $id_appellation)
    {
        $this->id_appellation = $id_appellation;
    }

    public function __toString(): string
    {
        return "id_appellation : " . $this->id_appellation . "  |  nom_appellation : " . $this->nom_appellation . "  |  categorie_appellation : " . $this->categorie_appellation;
    }

    function saveInDB(): void
    {
        // TODO: Implement saveInDB() method.
    }

    function setObjects(): void
    {
        // TODO: Implement setObjects() method.
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

?>