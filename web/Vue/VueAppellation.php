<?php
namespace vues;
use entite;


class VueAppellation extends AbstractVueRelation
{

    public function getHTML4Entity(entite\DataBaseObject $e): string
    {
        if($e instanceOf entite\appellation)
        {
            return "<tr class='EntityDescription AppellationDescription'><td>" . $e->getNomAppellation() . "</td><td>"
                . $e->getCategorieAppellation() . "</td>".
                /*"<td><a href='?action=ModifierEntite&PK=".$PK."'>Modifier</a>".
                "<a href='?action=SupprimerEntite&PK=".$PK."'>Supprimer</a> </td></tr>";*/
                "<td><form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST'>".
                    "<input type='SUBMIT' name='actionSurTuple' value='Modifier'  class='bouton boutonModifier'/>".
                    "<input type='HIDDEN' name='PK'             value='".$e->getId()."'/>".
                    "<input type='SUBMIT' name='actionSurTuple' value='Supprimer' class='bouton boutonSupprimer'/>".
                "</form></td></tr>";
        }
        else
            return "";
    }

    public function getAllEntities(array $Entities): string
    {
        if (count($Entities) > 0)
        {
            $All = "<div class='fondTableau'> <table class='AllEntities AllAppelation'>";
            $All .= "<tr>";

            foreach ($Entities[0]->getColumsName(false) as $name)
                if( !str_contains($name, "id"))
                    $All .= "<th><a href='AffichageTable.php?table=". $_GET['table'] ."&orderBy=$name'>$name</a></th>";

            $All .= "<th>Action</th></tr>";

            foreach ($Entities as $e)
                $All .= $this->getHTML4Entity($e);

            $All .= "</table></div>";
        }
        else
            return "<div class='fondTableau'>Table appellation vide</div>";

        return $All;
    }

    public function getForm4Entity(entite\DataBaseObject $e, bool $isForModifier): string
    {
        if($e instanceof entite\Appellation) {
            $value = $isForModifier ? $e->getCategorieAppellation() : null;
            $selectCategorie = self::getSelectForAttribute("categorie_appellation", "--Selectionnez une catégorie",entite\appellation::categories, $isForModifier, $value);
            $Form =
                "<form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST'>".
                    "<div class='fondTableau'>".
                        "<table>".
                            "<tr>".
                                "<td>nom_appellation</td>".
                                "<td>"." : "."<input type='text' name='nom_appellation' value=\"" . ( $isForModifier ? $e->getNomAppellation()       : "" ) . "\" required/></td>".
                            "</tr>".
                            "<tr>".
                                "<td>categorie_appellation </td>".
                                 "<td>"." : ". $selectCategorie . "</td>".
                            "</tr>".
                            "<tr>".
                                "<td colspan=2><input type='SUBMIT' name='actionSurTuple' value='Confirmer' class='bouton boutonCreer'/></td>".
                            "</tr>".
                        "</table>".
                    "</div>".
                    ($isForModifier ? "<input type='HIDDEN' name='PK' value='".$e->getId()."'/>" : " ").
                "</form>";

            return $Form;
        }
        else return "";
    }
}