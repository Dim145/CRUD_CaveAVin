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
        $bdd = FonctionsUtiles::getBDD();
        $ref = $this->getReflexion();

        $tabName  = $this->getColumsName(false);
        $tabValue = $this->getColumsValues();

        $statement = $bdd->prepare("SELECT * FROM quantite WHERE nom_bouteille = ? and volume_bouteille = ? and ".
        "millesime_bouteille = ?");

        $statement->execute(array($this->nom_bouteille, $this->volume_bouteille, $this->millesime_bouteille));

        if( $statement->fetch() && $tabValue[$tabName[0]] > 0 ) // n'est pas un nouveaux
        {
            $statement = $bdd->prepare("UPDATE quantite SET qte_bouteille = $this->qte_bouteille WHERE nom_bouteille = ? and volume_bouteille = ? and ".
                "millesime_bouteille = ?") ;

            $statement->execute(array($this->nom_bouteille, $this->volume_bouteille, $this->millesime_bouteille));
        }
        else // est un nouveau
        {
            $str = "INSERT INTO quantite VALUES ( '$this->nom_bouteille', $this->volume_bouteille, $this->millesime_bouteille, $this->qte_bouteille )";

            $bdd->exec($str);
        }
    }

    public function getId(): string
    {
        return $this->nom_bouteille . "," . $this->volume_bouteille . "," . $this->millesime_bouteille;
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
        if( $isForModifier )
        {
            $bdd = FonctionsUtiles::getBDD();
            $statement = $bdd->prepare("Select * from bouteille WHERE nom_bouteille = ? AND ".
            "volume_bouteille = ? AND millesime_bouteille = ?");

            $statement->execute(array($this->nom_bouteille, $this->volume_bouteille, $this->millesime_bouteille));
            $obj = $statement->fetchObject(Bouteille::class);
        }

        return "<tr><td>bouteille     </td><td> : " . FonctionsUtiles::getHTMLListFor(FonctionsUtiles::getAllFromClassName(Bouteille::class), 2, $isForModifier ? $obj->getIdBouteille() : -1) . "</td></tr>".
               "<tr><td>qte bouteille </td><td> : <input type='number' name='qte_bouteille' value=\"".( $isForModifier ? $this->qte_bouteille : "")."\" required /></td></tr>";

    }
}