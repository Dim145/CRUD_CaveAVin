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
    private Categorie   $categorie;

    public function setObjects(): void
    {
        $this->appellation = getAppellation($this->id_appellation);
        $this->categorie   = getCategorie($this->id_categorie);
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
     * @return float
     */
    public function getVolumeBouteille(): float
    {
        return $this->volume_bouteille;
    }

    /**
     * @param float $volume_bouteille
     */
    public function setVolumeBouteille(float $volume_bouteille): void
    {
        $this->volume_bouteille = $volume_bouteille;
    }

    /**
     * @return string
     */
    public function getMillesimeBouteille(): string
    {
        return $this->millesime_bouteille;
    }

    /**
     * @param string $millesime_bouteille
     */
    public function setMillesimeBouteille(string $millesime_bouteille): void
    {
        $this->millesime_bouteille = $millesime_bouteille;
    }

    /**
     * @return int
     */
    public function getPrixBouteille(): int
    {
        return $this->prix_bouteille;
    }

    /**
     * @param int $prix_bouteille
     */
    public function setPrixBouteille(int $prix_bouteille): void
    {
        $this->prix_bouteille = $prix_bouteille;
    }

    /**
     * @return int
     */
    public function getIdAppellation(): int
    {
        return $this->id_appellation;
    }

    /**
     * @param int $id_appellation
     */
    public function setIdAppellation(int $id_appellation): void
    {
        $this->id_appellation = $id_appellation;

        $this->appellation = $this->getAppellation($id_appellation);
    }

    /**
     * @return int
     */
    public function getIdCategorie(): int
    {
        return $this->id_categorie;
    }

    /**
     * @param int $id_categorie
     */
    public function setIdCategorie(int $id_categorie): void
    {
        $this->id_categorie = $id_categorie;

        $this->categorie = getCategorie($id_categorie);
    }

    /**
     * @return Appellation
     */
    public function getAppellation(): Appellation
    {
        return $this->appellation;
    }

    /**
     * @param Appellation $appellation
     */
    public function setAppellation(Appellation $appellation): void
    {
        $this->appellation = $appellation;

        $this->id_appellation = $appellation->get_id_appellation();
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
                $this->appellation->__toString()          . "<br/>" .
                $this->categorie->__toString();
    }
}