<?php

class Bouteille extends DatabaseObject
{
    private int    $id_bouteille;
    private string $nom_bouteille;
    private float  $volume_bouteille;
    private int    $millesime_bouteille;
    private int    $prix_bouteille;
    private int    $id_appellation;
    private int    $id_categorie;

    // Valeurs de $volume_bouteille :
    public const volumes = [37.5, 75, 150, 300, 500, 600, 900, 1200, 1500, 1800];

    protected Appellation $appellation;
    protected Categorie   $categorie;

    public function setObjects(): void
    {
        $this->appellation = FonctionsUtiles::getAppellation($this->id_appellation);
        $this->categorie   = FonctionsUtiles::getCategorie($this->id_categorie);
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
    public function getPrixBouteille(): int
    {
        return $this->prix_bouteille;
    }

    /**
     * @param int $prix_bouteille
     * @throws Exception
     */
    public function setPrixBouteille(int $prix_bouteille): void
    {
        if($prix_bouteille >= 0)
            $this->prix_bouteille = $prix_bouteille;
        else
            throw new Exception("Le prix ne peut pas etre inférieur a 0");
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

        $this->appellation = FonctionsUtiles::getAppellation($id_appellation); // surtout pas $this car ici on apelle bien la fonction dans FonctionUtile.php
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

        $this->categorie = FonctionsUtiles::getCategorie($id_categorie); // surtout pas $this car ici on apelle bien la fonction dans FonctionUtile.php
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

    public function saveInDB(): void
    {
        // TODO: Implement saveInDB() method.
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