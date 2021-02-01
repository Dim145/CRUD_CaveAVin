<?php

class Bouteille
{
    private int    $id_bouteille;
    private string $nom_bouteille;
    private float  $volume_bouteille;
    private string $millesime_bouteille;
    private int    $prix_bouteille;
    private int    $id_appellation;
    private int $id_categorie;

    private Appellation $appellation;

    public function setObjects(): void
    {
        $this->appellation = getAppellation($this->id_appellation);
    }

    public function __toString(): string
    {
        return "id: "        . $this->id_bouteille        . "<br/>" .
               "nom: "       . $this->nom_bouteille       . "<br/>" .
               "volume: "    . $this->volume_bouteille    . "<br/>" .
               "millesime: " . $this->millesime_bouteille . "<br/>" .
               "prix: "      . $this->prix_bouteille      . "<br/>" .
               "id_cate: "   . $this->id_categorie        . "<br/>" .
               "id_appel: "  . $this->id_appellation      . "<br/><br/>" .
                $this->appellation->__toString();
    }
}