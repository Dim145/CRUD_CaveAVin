<?php

class Degustation extends DatabaseObject
{
    private int    $id_degustation;
    private int    $note_degustation;
    private string $date_degustation;
    private int    $id_bouteille;
    private int    $id_oenologue;
    protected DateTime  $date;

    protected Bouteille $bouteille;
    protected Oenologue $oenologue;

    /**
     * @return int
     */
    public function getIdDegustation(): int
    {
        return $this->id_degustation;
    }

    /**
     * @param int $id_degustation
     */
    public function setIdDegustation(int $id_degustation): void
    {
        $this->id_degustation = $id_degustation;
    }

    /**
     * @return int
     */
    public function getNoteDegustation(): int
    {
        return $this->note_degustation;
    }

    /**
     * @param int $note_degustation
     */
    public function setNoteDegustation(int $note_degustation): void
    {
        if($note_degustation >=0 && $note_degustation <=20)
            $this->note_degustation = $note_degustation;
        else
            throw new Exception("La note n'est pas comprise entre 0 et 20");
    }

    /**
     * @return string
     */
    public function getDateDegustation(): string
    {
        return $this->date_degustation;
    }

    /**
     * @param string $date_degustation
     */
    public function setDateDegustation(string $date_degustation): void
    {
        $this->date_degustation = $date_degustation;
    }

    /**
     * @return int
     */
    public function getIdBouteille(): int
    {
        return $this->id_bouteille;
    }

    /**
     * @param int $id_bouteille
     */
    public function setIdBouteille(int $id_bouteille): void
    {
        $this->id_bouteille = $id_bouteille;
    }

    /**
     * @return int
     */
    public function getIdOenologue(): int
    {
        return $this->id_oenologue;
    }

    /**
     * @param int $id_oenologue
     */
    public function setIdOenologue(int $id_oenologue): void
    {
        $this->id_oenologue = $id_oenologue;
    }



    public function setObjects(): void
    {
        $this->date      = new DateTime($this->date_degustation);
        $this->bouteille = FonctionsUtiles::getBouteille($this->id_bouteille);
        $this->oenologue = FonctionsUtiles::getOenologue($this->id_oenologue);
    }

    function saveInDB(): void
    {
        // TODO: Implement saveInDB() method.
    }

    public function getColumsName( bool $includeSubObjects ): array
    {
        $allAtribute = $this->getReflexion()->getProperties(ReflectionProperty::IS_PRIVATE);

        $colums = array();

        foreach ( $allAtribute as $attribute )
            array_push($colums, $attribute->getName());

        if( $includeSubObjects )
        {
            array_push($colums, $this->bouteille->getColumsName(false)[1]); // second attribut = plus important apres l'id
            array_push($colums, $this->oenologue->getColumsName(false)[1]);
        }

        return $colums;
    }

    function __toString(): string
    {
        return "<td>" . $this->note_degustation     . "</td><td>"
            . $this->date_degustation               . "</td><td>"
            . $this->bouteille->getNomBouteille()   . "</td><td>"
            . $this->oenologue->get_nom_oenologue() . "</td>";
    }
}