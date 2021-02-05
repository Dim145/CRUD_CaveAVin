<?php

class Categorie extends DataBaseObject
{
    private int $id_categorie;
    private string $robe_bouteille;
    private string $sucrage_bouteille;
    private string $type_bouteille;

    // Valeurs de $robe_bouteille :
    public const robes = ['Rouge', 'Blanc', 'Rosé'];
    // Valeurs de $sucrage_bouteille :
    public const sucrages = ['Sec', 'Demi-sec', 'Moelleux', 'Liquoreux'];
    // Valeurs de $type_boutille :
    public const types = ['Vin tranquille', 'Vin effervescent', 'Vin doux naturel', 'Vin cuit'];

    public function set_id_categorie($id_categorie)
    {
        $this->id_categorie = $id_categorie;
    }

    public function get_id_categorie(): int
    {
        return $this->id_categorie;
    }


    public function set_robe_bouteille($robe_bouteille)
    {
        if (in_array($robe_bouteille, self::robes))
            $this->robe_bouteille = $robe_bouteille;
        else;// TODO throw
    }

    public function get_robe_bouteille(): string
    {
        return $this->robe_bouteille;
    }


    public function set_sucrage_bouteille($sucrage_bouteille)
    {
        if (in_array($sucrage_bouteille, self::sucrages))
            $this->sucrage_bouteille = $sucrage_bouteille;
        else;// TODO throw
    }

    public function get_sucrage_bouteille(): string
    {
        return $this->sucrage_bouteille;
    }

    public function set_type_bouteille($type_bouteille)
    {
        if (in_array($type_bouteille, self::types))
            $this->type_bouteille = $type_bouteille;
        else;// TODO throw
    }

    public function get_type_bouteille(): string
    {
        return $this->type_bouteille;
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
        return "<tr><td>" . $this->robe_bouteille . "</td><td>" . $this->sucrage_bouteille . "</td><td>" . $this->type_bouteille . "</td></tr>";
    }
}

?>