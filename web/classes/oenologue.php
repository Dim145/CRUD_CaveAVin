<?php

class Oenologue extends DataBaseObject
{
    private int $id_oenologue;
    private string $nom_oenologue;

    public function get_id_oenologue(): int
    {
        return $this->id_oenologue;
    }

    public function set_id_oenologue(int $id_oenologue)
    {
        $this->id_oenologue = $id_oenologue;
    }

    public function get_nom_oenologue(): string
    {
        return $this->nom_oenologue;
    }

    public function set_nom_oenologue(int $nom_oenologue)
    {
        $this->nom_oenologue = $nom_oenologue;
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

    public function __toString(): string
    {
        return "<td>" . $this->nom_oenologue . "</tr>";
    }
}