<?php

class Oenologue
{
    private int    $id_oenologue;
    private string $nom_oenologue;

    public function get_id_oenologue():int              { return $this->id_oenologue; }
    public function set_id_oenologue(int $id_oenologue) { $this->id_oenologue = $id_oenologue; }

    public function get_nom_oenologue():string            { return $this->nom_oenologue; }
    public function set_nom_oenologue(int $nom_oenologue) { $this->nom_oenologue = $nom_oenologue; }

    public function __toString():string { return "id_oenologue : ".$this->id_oenologue."  |  nom_oenologue : ".$this->nom_oenologue;}
}