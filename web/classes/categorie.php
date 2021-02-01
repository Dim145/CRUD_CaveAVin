<?php

class Categorie
{
    private int    $id_categorie;
    private string $robe_bouteille;
    private string $sucrage_bouteille;
    private string $type_bouteille;


    public function set_id_categorie($id_categorie) { return $this->id_categorie = $id_categorie; }
    public function get_id_categorie():int          { return $this->id_categorie; }


    public function set_robe_bouteille($robe_bouteille) { return $this->robe_bouteille = $robe_bouteille; }
    public function get_robe_bouteille():string         { return $this->robe_bouteille; }


    public function set_sucrage_bouteille($sucrage_bouteille) { return $this->sucrage_bouteille = $sucrage_bouteille; }
    public function get_sucrage_bouteille():string            { return $this->sucrage_bouteille; }

    public function set_type_bouteille($type_bouteille) { return $this->type_bouteille = $type_bouteille; }
    public function get_type_bouteille():string         { return $this->type_bouteille; }

    public function __toString():string
    {
        return "id_categorie : ".$this->id_categorie."  |  robe_bouteille : ".$this->robe_bouteille."  |  sucrage_bouteille : ".$this->sucrage_bouteille."  |  type_bouteille : ".$this->type_bouteille;
    }
}

?>