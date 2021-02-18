<?php


class VueCategorie extends AbstractVueRelation
{

    public function getHTML4Entity(DataBaseObject $e): string
    {
        if($e instanceof categorie)
        {
            $PK = $e->getIdCategorie();

            return "<tr class='EntityDescription CategorieDescription'><td>" . $e->getRobeBouteille() . "</td><td>" .
                $e->getSucrageBouteille() . "</td><td>" . $e->getTypeBouteille() . "</td>".
                "<td><form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST'>".
                "<input type='SUBMIT' name='actionSurTuple' value='Modifier'  class='bouton boutonModifier'/>".
                "<input type='HIDDEN' name='PK'          value='".$e->getId()."'/>".
                "<input type='SUBMIT' name='actionSurTuple' value='Supprimer' class='bouton boutonSupprimer'/>".
                "</form></td></tr>";
        }
        else return "";
    }

    public function getAllEntities(array $Entities): string
    {
        $All  = "<div class='fondTableau'><table class='AllEntities AllCategorie'>";
        $All .= "<tr><th>robe_bouteille</th><th>sucrage_bouteille</th><th>type_bouteille</th><th>Action</th></tr>";

        foreach($Entities as $e)
            $All .= $this->getHTML4Entity($e);

        $All .= "</table></div>";

        return $All;
    }

    public function getForm4Entity(DataBaseObject $e, bool $isForModifier): string
    {
        if($e instanceof categorie)
        {
            $valueRobe = null;
            $valueSucrage = null;
            $valueType = null;

            if($isForModifier)
            {
                $valueRobe = $e->getRobeBouteille();
                $valueSucrage = $e->getSucrageBouteille();
                $valueType = $e->getTypeBouteille();
            }

            $selectRobe    = self::getSelectForAttribute("robe_bouteille"   , "--Selectionnez une robe"  , categorie::robes   , $isForModifier, $valueRobe   );
            $selectSucrage = self::getSelectForAttribute("sucrage_bouteille", "--Selectionnez un sucrage", categorie::sucrages, $isForModifier, $valueSucrage);
            $selectType    = self::getSelectForAttribute("type_bouteille"   , "--Selectionnez un type"   , categorie::types   , $isForModifier, $valueType   );

            return "<form form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST'>".
                    "<div class='fondTableau'><table>".
                        "<tr>".
                            "<td>robe_bouteille    </td>".
                            "<td>"." : " . $selectRobe . "</td>".
                        "</tr>".
                        "<tr>".
                            "<td>sucrage_bouteille </td>".
                            "<td>"." : " . $selectSucrage . "</td>".
                        "</tr>".
                        "<tr>".
                            "<td>type_bouteille    </td>".
                            "<td>"." : " . $selectType . "</td>".
                        "</tr>".
                        "<tr>".
                            "<td colspan=2><input type='SUBMIT' name='actionSurTuple' value='Confirmer' class='bouton boutonCreer'/></td>".
                        "</tr>".
                    "</table></div>".
                    ($isForModifier ? "<input type='HIDDEN' name='PK' value='".$e->getId()."'/>" : " ").
                "</form>";
        }
        else return "";
    }
}