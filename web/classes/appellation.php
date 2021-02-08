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

    public function set_id_appellation(int $id_appellation)
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

    public function set_categorie_appellation(string $categorie_appellation)
    {
        $this->categorie_appellation = $categorie_appellation;
    }

    public function __toString(): string
    {
        return "<td>" . $this->nom_appellation . "</td><td>" . $this->categorie_appellation . "</td>";
    }

    function saveInDB(): void
    {
        // TODO: Implement saveInDB() method.
    }

    function setObjects(): void
    {
        // Ne fais rien car pas d'objets dans categories
    }

    public function getColumsName( bool $includeSubObjects ): array
    {
        $allAtribute = $this->getReflexion()->getProperties(ReflectionProperty::IS_PRIVATE);

        $colums = array();

        foreach ( $allAtribute as $attribute )
            array_push($colums, $attribute->getName());

        return $colums;
    }
}

?>