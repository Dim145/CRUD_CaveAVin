<?php

class Quantite extends DataBaseObject
{
    private string $nom_bouteille;
    private float  $volume_bouteille;
    private int    $millesime_bouteille;
    private int    $qte_bouteille;

    public const volumes = [37.5, 75, 150, 300, 500, 600, 900, 1200, 1500, 1800];


    function saveInDB(): void
    {
        // TODO: Implement saveInDB() for quantite => special
    }

    /**
     * @return int
     */
    public function getVolumeBouteille(): float
    {
        return $this->volume_bouteille;
    }

    /**
     * @param float $volume_bouteille
     * @throws Exception
     */
    public function setVolumeBouteille(float $volume_bouteille): void
    {
        if(in_array($volume_bouteille, self::volumes))
            $this->volume_bouteille = $volume_bouteille;
        else
            throw new Exception("Le volume doit etre egale a une de ces valeurs: " . implode(" - ", self::volumes));
    }

    /**
     * @return string
     */
    public function getNomBouteille(): string
    {
        return $this->nom_bouteille;
    }

    /**
     * @param string $nom_bouteille
     */
    public function setNomBouteille(string $nom_bouteille): void
    {
        $this->nom_bouteille = $nom_bouteille;
    }

    /**
     * @return int
     */
    public function getMillesimeBouteille(): int
    {
        return $this->millesime_bouteille;
    }

    /**
     * @param int $millesime_bouteille
     * @throws Exception
     */
    public function setMillesimeBouteille(int $millesime_bouteille): void
    {
        if($millesime_bouteille > 0 && $millesime_bouteille <= 2099)
            $this->millesime_bouteille = $millesime_bouteille;
        else
            throw new Exception("la millesime doit etre comprise entre 1 et 2099.");
    }

    /**
     * @return int
     */
    public function getQteBouteille(): int
    {
        return $this->qte_bouteille;
    }

    /**
     * @param int $qte_bouteille
     */
    public function setQteBouteille(int $qte_bouteille): void
    {
        $this->qte_bouteille = $qte_bouteille;
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

    function __toString(): string
    {
        return "<td>" . $this->nom_bouteille       . "</td><td>"
            . $this->volume_bouteille              . "</td><td>"
            . $this->millesime_bouteille           . "</td><td>"
            . $this->qte_bouteille                 . "</td>";
    }

    public function toStringPageForm(bool $isForModifier = false): string
    {
        return "";
    }
}