<?php


class VueOenologue extends AbstractVueRelation
{

    public function getHTML4Entity(DataBaseObject $e): string
    {
        if($e instanceof oenologue){
            $PK = $e->get_id_oenologue();
            return "<tr class='EntityDescription OenologueDescription'><td>" . $e->get_nom_oenologue() . "</td>".
                "<a href='?action=ModifierEntite&PK=".$PK."'>Modifier</a>".
                "<a href='?action=SupprimerEntite&PK=".$PK."'>Supprimer</a> </td></tr>";
        } else return "";
    }

    public function getAllEntities(array $Entities): string
    {
        $All = "<table class='AllEntities AllOenologue'>";
        $All .= "<tr><th>nom_oenologue</th><th>Action</th></tr>";
        foreach($Entities as &$e){
            $All .= $this->getHTML4Entity($e);
        }
        $All .= "</table>";
        return $All;
    }

    public function getForm4Entity(DataBaseObject $e, bool $isForModifier): string
    {
        if($e instanceof oenologue){
            $get = $isForModifier ? "?action=ModifierEntite" : "?action=InsererEntite";
            return "<form class='EntityForm OenologueForm' action='".$_SERVER['PHP_SELF']. $get . "' method='GET'><table><tr><td>nom_oenologue </td><td>"." : ". "<input type='text' name='nom_oenologue' value=\"" .
                ( $isForModifier ? $e->get_nom_oenologue() : "" ) . "\" required /></td></tr></table></form>";
        } else return "";
    }
}