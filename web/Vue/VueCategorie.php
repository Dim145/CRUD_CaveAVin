<?php


class VueCategorie extends AbstractVueRelation
{

    public function getHTML4Entity(DataBaseObject $e): string
    {
        if($e instanceof categorie) {
            $PK = $e->get_id_categorie();
            return "<tr class='EntityDescription CategorieDescription'><td>" . $e->get_robe_bouteille() . "</td><td>" .
                $e->get_sucrage_bouteille() . "</td><td>" . $e->get_type_bouteille() . "</td>".
                "<td><a href='?action=ModifierEntite&PK=".$PK."'>Modifier</a>".
                "<a href='?action=SupprimerEntite&PK=".$PK."'>Supprimer</a> </td></tr>";
        } else return "";
    }

    public function getAllEntities(array $Entities): string
    {
        $All = "<table class='AllEntities AllCategorie'>";
        $All .= "<tr><th>robe_bouteille</th><th>sucrage_bouteille</th><th>type_bouteille</th><th>Action</th></tr>";
        foreach($Entities as &$e){
            $All .= $this->getHTML4Entity($e);
        }
        $All .= "</table>";
        return $All;
    }

    public function getForm4Entity(DataBaseObject $e, bool $isForModifier): string
    {
        if($e instanceof categorie) {
            $get = $isForModifier ? "?action=ModifierEntite" : "?action=InsererEntite";
            return "<form class='EntityForm CategorieForm' action='".$_SERVER['PHP_SELF']. $get . "' method='GET' ><table><tr><td>robe_bouteille    </td><td>"." : "."<input type='text' name='1' value=\"" . ( $isForModifier ? $e->get_robe_bouteille() : "" ) . "\" required pattern='(Rouge|Blanc|Rosé)'
                                                                      title='Doit être Rouge, Blanc ou Rosé'/></td></tr>" .
                "<tr><td>sucrage_bouteille </td><td>"." : "."<input type='text' name='2' value=\"" . ( $isForModifier ? $e->get_sucrage_bouteille() : "" ) . "\" required pattern='(Sec|Demi-sec|Moelleux|Liquoreux'
                                                                      title='Doit être Sec, Demi-sec, Moelleux, Liquoreux'/></td></tr>" .
                "<tr><td>type_bouteille    </td><td>"." : "."<input type='text' name='3' value=\"" . ( $isForModifier ? $e->get_type_bouteille() : "" ) . "\" required pattern='(Vin\stranquille|Vin\seffervesent|Vin\sdoux\snaturel|Vin\scuit)'
                                                                      title='Doit être Vin tranquille, Vin effervesent, Vin doux naturel ou Vin cuit'/></td></tr></table></form>";
        } else return "";
    }
}