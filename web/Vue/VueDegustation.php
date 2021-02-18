<?php
namespace vues;
use entite;
use sgbd;

class VueDegustation extends AbstractVueRelation
{

    public function getHTML4Entity(entite\DataBaseObject $e): string
    {
        if($e instanceof entite\degustation)
        {
            $PK = $e->getIdDegustation();

            return "<tr class='EntityDescription DegustationDescription'><td>" . $e->getNoteDegustation() . "</td><td>"
                . $e->getDateDegustation()               . "</td><td>"
                . $e->getBouteille()->getNomBouteille()   . "</td><td>"
                . $e->getOenologue()->getNomOenologue() . "</td>".
                "<td><form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST'>".
                "<button type='SUBMIT' name='actionSurTuple' value='Modifier'  class='bouton boutonModifier'><img src='../images/edit.png' height='15'  alt='oups'/> </button>".
                "<input type='HIDDEN' name='PK'          value='".$e->getId()."'/>".
                "<button type='SUBMIT' name='actionSurTuple' value='Supprimer' class='bouton boutonSupprimer'><img src='../images/trash.png' height='15'  alt='oups'/> </button>".
                "</form></td></tr>";
        }
        else return "";
    }

    public function getAllEntities(array $Entities): string
    {
        $All = "<div class='fondTableau'><table class='AllEntities AllDegustation'>";
        $All .= "<tr>";

        foreach ($Entities[0]->getColumsName(false) as $name)
            if( !str_contains($name, "id"))
                $All .= "<th><a href='AffichageTable.php?table=". $_GET['table'] ."&orderBy=$name'>$name</a></th>";

        $All .= "<th>nom_bouteille</th><th>nom_oenologue</th><th>Action</th></tr>";

        foreach($Entities as $e)
            $All .= $this->getHTML4Entity($e);

        $All .= "</table></div>";

        return $All;
    }

    public function getForm4Entity(entite\DataBaseObject $e, bool $isForModifier): string
    {
        if($e instanceof entite\degustation){
            $get = $isForModifier ? "?action=ModifierEntite" : "?action=InsererEntite";

            return "<form form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST'>".
                    "<div class='fondTableau'><table>".
                        "<tr>".
                            "<td>note_degustation </td>".
                            "<td>"." : "."<input type='number' name='note_degustation'  required value=\"" . ( $isForModifier ? $e->getNoteDegustation() : "" ) . "\" min='0' max='20' step='0.1' title='Doit être entre 0 et 20 compris'/></td>".
                        "</tr>".
                        "<tr>".
                            "<td>date_degustation </td><td>"." : "."<input type='date' name='date_degustation'  value=\"". ( $isForModifier ? $e->getDateDegustation() : date('Y-m-d')) ."\" /></td>".
                        "</tr>".
                        "<tr>".
                            "<td>Bouteille        </td>".
                            "<td>"." : ". AbstractVueRelation::getHTMLListFor(sgbd\FonctionsSGBD::getAllFromClassName(entite\Bouteille::class), 2, $isForModifier ? $e->getIdBouteille() : -1)."</td>".
                        "</tr>".
                        "<tr>".
                            "<td>Oenologue        </td>".
                            "<td>"." : ". AbstractVueRelation::getHTMLListFor(sgbd\FonctionsSGBD::getAllFromClassName(entite\Oenologue::class), 2, $isForModifier ? $e->getIdOenologue() : -1)."</td>".
                        "</tr>".
                        "<tr>".
                            "<td colspan=2><input type='SUBMIT' name='actionSurTuple' value='Confirmer' class='bouton boutonCreer'/></td>".
                        "</tr>".
                    "</table></div>".
                    ($isForModifier ? "<input type='HIDDEN' name='PK' value='".$e->getId()."'/>" : " ").
                    "<input type='HIDDEN' name='referer' value=\"" . $_SERVER['HTTP_REFERER'] . "\" />".
                "</form>";
        }
        else return "";
    }
}