<?php


class VueCategorie extends AbstractVueRelation
{

    public function getHTML4Entity(DataBaseObject $e): string
    {
        if("e instanceof categorie") {
            $PK = $e->getIdCategorie();
            return "<tr class='EntityDescription CategorieDescription'><td>" . $e->getRobeBouteille() . "</td><td>" .
                $e->getSucrageBouteille() . "</td><td>" . $e->getTypeBouteille() . "</td>".
                "<td><form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST'>".
                "<input type='SUBMIT' name='actionSurTuple' value='Modifier'  class='bouton boutonModifier'/>".
                "<input type='HIDDEN' name='PK'          value='".$e->getId()."'/>".
                "<input type='SUBMIT' name='actionSurTuple' value='Supprimer' class='bouton boutonSupprimer'/>".
                "</form></td></tr>";
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
        if("e instanceof categorie") {
            $get = $isForModifier ? "?action=ModifierEntite" : "?action=InsererEntite";
            return
                "<form form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST'>".
                    "<div clas='fondTableau'><table>".
                        "<tr>".
                            "<td>robe_bouteille    </td>".
                            "<td>"." : "."<input type='text' name='robe_bouteille' value=\"" . ( $isForModifier ? $e->getRobeBouteille() : "" ) . "\" required pattern='(Rouge|Blanc|Rosé)' title='Doit être Rouge, Blanc ou Rosé'/></td>".
                        "</tr>".
                        "<tr>".
                            "<td>sucrage_bouteille </td>".
                            "<td>"." : "."<input type='text' name='sucrage_bouteille' value=\"" . ( $isForModifier ? $e->getSucrageBouteille() : "" ) . "\" required pattern='(Sec|Demi-sec|Moelleux|Liquoreux' title='Doit être Sec, Demi-sec, Moelleux, Liquoreux'/></td>".
                        "</tr>".
                        "<tr>".
                            "<td>type_bouteille    </td>".
                            "<td>"." : "."<input type='text' name='type_bouteille' value=\"" . ( $isForModifier ? $e->getTypeBouteille() : "" ) . "\" required pattern='(Vin\stranquille|Vin\seffervescent|Vin\sdoux\snaturel|Vin\scuit)' title='Doit être Vin tranquille, Vin effervescent, Vin doux naturel ou Vin cuit'/></td>".
                        "</tr>".
                        "<tr>".
                            "<td colspan=2><input type='SUBMIT' name='actionSurTuple' value='Confirmer' class='bouton boutonCreer'/></td>".
                        "</tr>".
                    "</table></div>".
                    ($isForModifier ? "<input type='HIDDEN' name='PK' value='".$e->getId()."'/>" : " ").
                "</form>";
        } else return "";
    }
}