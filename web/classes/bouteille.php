<?php

class Bouteille extends DatabaseObject
{
    private int    $id_bouteille;
    private string $nom_bouteille;
    private int    $millesime_bouteille;
    private float  $volume_bouteille;
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

    public function getId()
    {
        return $this->getIdBouteille();
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

    /**
     * @param bool $includeSubObjects
     * @return string[]
     */
    public function getColumsName( bool $includeSubObjects ): array
    {
        $allAtribute = $this->getReflexion()->getProperties(ReflectionProperty::IS_PRIVATE);

        $colums = array();

        foreach ( $allAtribute as $attribute )
            array_push($colums, $attribute->getName());

        if( $includeSubObjects )
        {
            array_push($colums, $this->appellation->getColumsName(false)[1]); // second attribut = plus important apres l'id
            array_push($colums, $this->categorie->getColumsName(false)[1]);
        }

        return $colums;
    }

    public function __toString(): string
    {
        return  "<td>" . $this->nom_bouteille . "</td><td>" .
            $this->millesime_bouteille        . "</td><td>" .
            $this->volume_bouteille           . "</td><td>" .
            $this->prix_bouteille             . "</td><td>" .
            $this->appellation->get_nom_appellation() . "</td><td>" .
            $this->categorie->get_robe_bouteille()    . "</td>";
    }

    public function toStringPageForm(bool $isForModifier = false ): string
    {
        return "<tr><td>nom_bouteille         </td><td>"." : "."<input type='text' name='nom_bouteille'         value=\"" . ($isForModifier ? $this->nom_bouteille : "") . "\" required/></td></tr>" .
               "<tr><td>volume_bouteille      </td><td>"." : "."<input type='text' name='volume_bouteille'      value=\"" . ($isForModifier ? $this->volume_bouteille : "") . "\" required pattern='^(37.5|75|150|300|500|600|900|1200|1500|1800)$'
                                                                      title='Doit être égale a 37.5,  75, 150, 300, 500, 600, 900, 1200, 1500 ou 1800'/></td></tr>" .
               "<tr><td>millesime_bouteille   </td><td>"." : "."<input type='number' name='millesime_bouteille'   value=\"" . ($isForModifier ? $this->millesime_bouteille : "") . "\" required min='1' max='2099' step='1'
                                                                      title='Doit être entre 1 et 2099 compris'/></td></tr>" .
               "<tr><td>prix_bouteille        </td><td>"." : "."<input type='number' name='prix_bouteille'        value=\"" . ($isForModifier ? $this->prix_bouteille : "") . "\" required pattern='^\d+(.\d{1,2})?$'
                                                                      title='Doit être composé de chiffre et eventuellement de 2 chiffres apres le point'/></td></tr>" .
               "<tr><td>Appellation           </td><td>"." : ". FonctionsUtiles::getHTMLListFor(FonctionsUtiles::getAllFromClassName(Appellation::class), 2, $isForModifier ? $this->id_appellation : -1)."</td></tr>".
               "<tr><td>Categorie             </td><td>"." : ". FonctionsUtiles::getHTMLListFor(FonctionsUtiles::getAllFromClassName(Categorie::class), 3, $isForModifier ? $this->id_categorie : -1)  ."</td></tr>";
    }
}