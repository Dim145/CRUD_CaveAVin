<?php
namespace vues;
use entite;

class VueOenologue extends AbstractVueRelation
{

    public function getHTML4Entity(entite\DataBaseObject $e): string
    {
        if($e instanceof entite\oenologue){
            $PK = $e->getIdOenologue();

            return "<tr class='EntityDescription OenologueDescription'><td>" . $e->getNomOenologue() .
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
        $All  = "<div class='fondTableau'><table class='AllEntities AllOenologue'>";
        $All .= "<tr>";

        foreach ($Entities[0]->getColumsName(false) as $name)
            if( !str_contains($name, "id"))
                $All .= "<th><a href='AffichageTable.php?table=". $_GET['table'] ."&orderBy=$name'>$name</a></th>";

        $All .= "<th>Action</th></tr>";

        foreach($Entities as $e)
            $All .= $this->getHTML4Entity($e);

        $All .= "</table></div>";

        return $All;
    }

    public function getForm4Entity(entite\DataBaseObject $e, bool $isForModifier): string
    {
        if($e instanceof entite\oenologue){
            return
                "<form form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST'>".
                    "<div class='fondTableau'><table>".
                        "<tr>".
                            "<td>nom_oenologue </td>".
                            "<td>"." : "."<input type='text' name='nom_oenologue' value=\"" . ( $isForModifier ? $e->getNomOenologue() : "" ) . "\" required /></td>".
                        "</tr>".
                            "<td colspan=2><input type='SUBMIT' name='actionSurTuple' value='Confirmer' class='bouton boutonCreer'/></td>".
                        "</tr>".
                    "</table></div>".
                    ($isForModifier ? "<input type='HIDDEN' name='PK' value='".$e->getId()."'/>" : " ").
                "</form>";
        }
        else return "";
    }
}