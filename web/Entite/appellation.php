<?php
namespace entite;
use entite;

class Appellation extends DataBaseObject
{

    private int    $id_appellation;
    private string $nom_appellation;
    private string $categorie_appellation;

    // Valeurs de $categorie_appellation :
    public const categories = ["Vin de table", "Vin de pays", "VDQS", "AOC/AOP", "IGP"];

    public function getIdAppellation(): int
    {
        return $this->id_appellation;
    }

    public function setIdAppellation(int $id_appellation)
    {
        $this->id_appellation = $id_appellation;
    }

    public function getNomAppellation(): string
    {
        return $this->nom_appellation;
    }

    public function setNomAppellation(string $nom_appellation)
    {
        $this->nom_appellation = $nom_appellation;
    }

    public function getCategorieAppellation(): string
    {
        return $this->categorie_appellation;
    }

    public function setCategorieAppellation(string $categorie_appellation)
    {
        if(in_array($categorie_appellation, self::categories))
            $this->categorie_appellation = $categorie_appellation;
        else
            throw new \Exception("La catégorie doit etre égale a une de ces valeurs: " . implode(" - ", self::categories));
    }

    function setObjects(): void
    {
        // Ne fais rien car pas d'objets dans categories
    }

    public function getColumsName( bool $includeSubObjects ): array
    {
        $allAtribute = $this->getReflexion()->getProperties(\ReflectionProperty::IS_PRIVATE);

        $colums = array();

        foreach ( $allAtribute as $attribute )
            array_push($colums, $attribute->getName());

        return $colums;
    }

    public function __toString(): string
    {
        return "<td>" . $this->nom_appellation . "</td><td>" . $this->categorie_appellation . "</td>";
    }

    public function toStringPageForm(bool $isForModifier = false): string
    {
        return "<tr><td>nom_appellation       </td><td>"." : "."<input type='text' name='nom_appellation' value=\"" . ( $isForModifier ? $this->nom_appellation       : "" ) . "\" required/></td></tr>" .
               "<tr><td>categorie_appellation </td><td>"." : "."<input type='text' name='categorie_appellation' value=\"" . ( $isForModifier ? $this->categorie_appellation : "" ) . "\" required pattern='(Vin\sde\stable|AOC\/AOP|IGP|Vin\sde\spays|VDQS)'
                    title='Doit être un Vin de table, Vin de pays, VDQS ou AOC/AOP'/></td></tr>";
    }

    public function getId()
    {
        return $this->getIdAppellation();
    }
}
?>