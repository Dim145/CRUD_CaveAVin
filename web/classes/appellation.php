<?php

class Appellation
{
    private int    $id_appellation;
    private string $nom_appellation;
    private string $categorie_appellation;

    /*public function __construct(int $id_appellation, string $nom_appellation, string $categorie_appellation)
    {
        $this->$id_appellation  = $id_appellation;
        $this->$nom_appellation = $nom_appellation;
        if($categorie_appellation == "Vin de table" || $categorie_appellation == "Vin de pays" || 
           $categorie_appellation == "AOC/AOP"      || $categorie_appellation == "IGP"         ||
           $categorie_appellation == "VDQS")
            $this->$categorie_appellation = $categorie_appellation;
        else
            throw new Exception("Le paramètre categorie_appellation ne correspond au resultat attendu", 1);
    }*/

    public function get_id_appellation():int                   { return $this->id_appellation; }
    public function set_id_appellation(string $id_appellation) { $this->id_appellation = $id_appellation; }

    public function get_nom_appellation():string                 { return $this->nom_appellation; }
    public function set_nom_appellation(string $nom_appellation) { $this->nom_appellation = $nom_appellation; }

    public function get_categorie_appellation():string                             { return $this->categorie_appellation; }
    public function set_categorie_appellation(string $categorie_appid_appellation) { $this->id_appellation = $id_appellation; }

    public function __toString():string
    {
       return "id_appellation : ".$this->id_appellation."  |  nom_appellation : ".$this->nom_appellation."  |  categorie_appellation : ".$this->categorie_appellation;
    }
}

?>