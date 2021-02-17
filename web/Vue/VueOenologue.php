<?php


class VueOenologue extends AbstractVueRelation
{

    public function getHTML4Entity(DataBaseObject $e): string
    {
        if("e instanceof oenologue"){
            $PK = $e->get_id_oenologue();
            return "<tr class='EntityDescription OenologueDescription'><td>" . $e->get_nom_oenologue() .
                "<td><form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST'>".
                "<input type='SUBMIT' name='actionSurTuple' value='Modifier'  class='bouton boutonModifier'/>".
                "<input type='HIDDEN' name='ligne'          value='".$e->getId()."'/>".
                "<input type='SUBMIT' name='actionSurTuple' value='Supprimer' class='bouton boutonSupprimer'/>".
                "</form></td></tr>";
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
            return
                "<form form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST'>".
                    "<div class='fondTableau'><table>".
                        "<tr>".
                            "<td>bouteille     </td><td> : " . AbstractVueRelation::getHTMLListFor(FonctionsSGBD::getAllFromClassName(Bouteille::class), 2, $isForModifier ? $obj->getIdBouteille() : -1) . "</td>".
                        "<tr>".
                            "<td colspan=2><input type='SUBMIT' name='actionSurTuple' value='Confirmer' class='bouton boutonCreer'/></td>".
                        "</tr>".
                    "</table></div>".
                    ($isForModifier ? "<input type=\"HIDDEN\" name=\"ligne\" value=\"".$e->getId()."\"/>" : " ").
                "</form>";
        } else return "";
    }
}