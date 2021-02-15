<?php

class Categorie extends DataBaseObject
{
    private int    $id_categorie;
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
        else
            throw new Exception("valeur de robe invalide");
    }

    public function get_robe_bouteille(): string
    {
        return $this->robe_bouteille;
    }


    public function set_sucrage_bouteille($sucrage_bouteille)
    {
        if (in_array($sucrage_bouteille, self::sucrages))
            $this->sucrage_bouteille = $sucrage_bouteille;
        else
            throw new Exception("Valeur de sucrage invalide");
    }

    public function get_sucrage_bouteille(): string
    {
        return $this->sucrage_bouteille;
    }

    public function set_type_bouteille($type_bouteille)
    {
        if (in_array($type_bouteille, self::types))
            $this->type_bouteille = $type_bouteille;
        else
            throw new Exception("Type De bouteille invalide");
    }

    public function get_type_bouteille(): string
    {
        return $this->type_bouteille;
    }

    function setObjects(): void
    {
        // Ne fais rien car pas d'objets dans categories
    }

    public function getId()
    {
        return $this->get_id_categorie();
    }

    public function getColumsName( bool $includeSubObjects ): array
    {
        $allAtribute = $this->getReflexion()->getProperties(ReflectionProperty::IS_PRIVATE);

        $colums = array();

        foreach ( $allAtribute as $attribute )
            array_push($colums, $attribute->getName());

        return $colums;
    }

    public function __toString(): string
    {
        return "<td>" . $this->robe_bouteille . "</td><td>" . $this->sucrage_bouteille . "</td><td>" . $this->type_bouteille . "</td>";
    }

    public function toStringPageForm(bool $isForModifier = false): string
    {
        return "<tr><td>robe_bouteille    </td><td>"." : "."<input type='text' name='1' value=\"" . ( $isForModifier ? $this->robe_bouteille : "" ) . "\" required pattern='(Rouge|Blanc|Rosé)'
                                                                  title='Doit être Rouge, Blanc ou Rosé'/></td></tr>" .
               "<tr><td>sucrage_bouteille </td><td>"." : "."<input type='text' name='2' value=\"" . ( $isForModifier ? $this->sucrage_bouteille : "" ) . "\" required pattern='(Sec|Demi-sec|Moelleux|Liquoreux)'
                                                                  title='Doit être Sec, Demi-sec, Moelleux, Liquoreux'/></td></tr>" .
               "<tr><td>type_bouteille    </td><td>"." : "."<input type='text' name='3' value=\"" . ( $isForModifier ? $this->type_bouteille : "" ) . "\" required pattern='(Vin\stranquille|Vin\seffervesent|Vin\sdoux\snaturel|Vin\scuit)'
                                                                  title='Doit être Vin tranquille, Vin effervesent, Vin doux naturel ou Vin cuit'/></td></tr>";
    }
}

?>