<?php


class VueAppellation extends AbstractVueRelation
{

    public function getHTML4Entity(DataBaseObject $e): string
    {
        if("$e instanceof appelation") {
            $PK = $e->get_id_appellation();
            return "<tr class='EntityDescription AppellationDescription'><td>" . $e->get_nom_appellation() . "</td><td>"
                . $e->get_categorie_appellation() . "</td>".
                "<td><a href='?action=ModifierEntite&PK=".$PK."'>Modifier</a>".
                "<a href='?action=SupprimerEntite&PK=".$PK."'>Supprimer</a> </td></tr>";
        } else return "";
    }

    public function getAllEntities(array $Entities): string
    {
        $All = "<table class='AllEntities AllAppelation'>";
        $All .= "<tr><th>nom_appellation</th><th>categorie_appellation</th><th>Action</th></tr>";
        foreach($Entities as $e){
            $All .= $this->getHTML4Entity($e);
        }
        $All .= "</table>";
        return $All;
    }

    public function getForm4Entity(DataBaseObject $e, bool $isForModifier): string
    {
        if($e instanceof appelation) {
            $get = $isForModifier ? "?action=ModifierEntite" : "?action=InsererEntite";
            $Form = "<form class='EntityForm AppellationForm' action='".$_SERVER['PHP_SELF']. $get ."' method='GET'>\n".
                "<table><tr><td>nom_appellation</td><td>"." : ".
                "<input type='text' required name='1' value='" . (isForModifier ? $e->get_nom_appellation() : "" ) .
                "' /></td></tr>" . "<tr><td>categorie_appellation </td><td>"." : ".
                "<input type='text' required name='2' value=\"" . (isForModifier ? $e->get_categorie_appellation() : "" ) . "\" /></td></tr></table></form>";

            return $Form;
        } else return "";
    }
}