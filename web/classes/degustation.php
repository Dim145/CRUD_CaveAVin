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

    function __toString(): string
    {
        return "<tr><td>" . $this->note_degustation . "</td><td>" . $this->date_degustation . "</td><td>"
                          . $this->bouteille->getNomBouteille()   . "</td><td>"
                          . $this->oenologue->get_nom_oenologue() . "</td></tr>";
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