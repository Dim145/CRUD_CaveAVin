<?php


class VueDegustation extends AbstractVueRelation
{

    public function getHTML4Entity(DataBaseObject $e): string
    {
        if($e instanceof degustation){
            $PK = $e->getIdDegustation();
            return "<tr class='EntityDescription DegustationDescription'><td>" . $e->getNoteDegustation()     . "</td><td>"
                . $e->getDateDegustation()               . "</td><td>"
                . $e->getBouteille()->getNomBouteille()   . "</td><td>"
                . $e->getOenologue()->get_nom_oenologue() . "</td><td>".
                "<a href='?action=ModifierEntite&PK=".$PK."'>Modifier</a>".
                "<a href='?action=SupprimerEntite&PK=".$PK."'>Supprimer</a> </td></tr>";
        } else return "";
    }

    public function getAllEntities(array $Entities): string
    {
        $All = "<table class='AllEntities AllDegustation'>";
        $All .= "<tr><th>note_degustation</th><th>date_degustation</th><th>nom_bouteille</th><th>nom_oenologue</th><th>Action</th></tr>";
        foreach($Entities as &$e){
            $All .= $this->getHTML4Entity($e);
        }
        $All .= "</table>";
        return $All;
    }

    public function getForm4Entity(DataBaseObject $e, bool $isForModifier): string
    {
        if($e instanceof degustation){
            $get = $isForModifier ? "?action=ModifierEntite" : "?action=InsererEntite";
            return "<form class='EntityForm DegustationForm' action='".$_SERVER['PHP_SELF']. $get . "' method='GET'><table><tr><td>note_degustation </td><td>"." : "."<input type='text' name='note_degustation'  value=\"" . ( $isForModifier ? $e->getNoteDegustation() : "" ) . "\" required pattern='^((0|1)\d)|20 '
                                                                     title='Doit être en 0 et 20 compris'/></td></tr>" .
                "<tr><td>date_degustation </td><td>"." : "."<input type='date' name='date_degustation'  value=\"". ( $isForModifier ? $e->getDateDegustation() : date('Y-m-d')) ."\" /></td></tr>".
                "<tr><td>Bouteille        </td><td>"." : ". FonctionsUtiles::getHTMLListFor(FonctionsUtiles::getAllFromClassName(Bouteille::class), 2, $isForModifier ? $e->getIdBouteille() : -1)."</td></tr>".
                "<tr><td>Oenologue        </td><td>"." : ". FonctionsUtiles::getHTMLListFor(FonctionsUtiles::getAllFromClassName(Oenologue::class), 2, $isForModifier ? $this->getIdOenologue() : -1)."</td></tr></table></form>";
        } else return "";
    }
}