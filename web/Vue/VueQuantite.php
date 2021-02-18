<?php
namespace vues;
use entite;
use sgbd;

class VueQuantite extends AbstractVueRelation
{

    public function getHTML4Entity(entite\DataBaseObject $e): string
    {
        if($e instanceof entite\quantite){
            $PK = $e->getNomBouteille() . "," . $e->getVolumeBouteille() . "," . $e->getMillesimeBouteille();
            return "<tr class='EntityDescription QuantiteDescription'><td>" . $e->getNomBouteille()       . "</td><td>"
                . $e->getVolumeBouteille()              . "</td><td>"
                . $e->getMillesimeBouteille()           . "</td><td>"
                . $e->getQteBouteille()                 . "</td>"
                . "<td><form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST'>".
                "<input type='SUBMIT' name='actionSurTuple' value='Modifier'  class='bouton boutonModifier'/>".
                "<input type='HIDDEN' name='PK'             value='".$e->getId()."'/>".
                "<input type='SUBMIT' name='actionSurTuple' value='Supprimer' class='bouton boutonSupprimer'/>".
                "</form></td></tr>";
        } else return "";
    }

    public function getAllEntities(array $Entities): string
    {
        $All = "<div class='fondTableau'><table class='AllEntities AllQuantite'>";
        $All .= "<tr><th>nom_bouteille</th><th>volume_bouteille</th><th>millesime_bouteille</th><th>qte_bouteille</th><th>Action</th></tr>";
        foreach($Entities as &$e){
            $All .= $this->getHTML4Entity($e);
        }
        $All .= "</table></div>";
        return $All;
    }

    public function getForm4Entity(entite\DataBaseObject $e, bool $isForModifier): string
    {
        if($e instanceof entite\quantite){
            if( $isForModifier )
            {
                $bdd = sgbd\FonctionsSGBD::getBDD();
                $statement = $bdd->prepare("Select * from bouteille WHERE nom_bouteille = ? AND ".
                    "volume_bouteille = ? AND millesime_bouteille = ?");
                $statement->execute(array($e->getNomBouteille(), $e->getVolumeBouteille(), $e->getMillesimeBouteille()));
                $obj = $statement->fetchObject(entite\Bouteille::class);
            }
            return
                "<form form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST'>".
                    "<div class='fondTableau'><table>".
                        "<tr>".
                            "<td>bouteille     </td>".
                            "<td> : " . AbstractVueRelation::getHTMLListFor(sgbd\FonctionsSGBD::getAllFromClassName(entite\Bouteille::class), 2, $isForModifier ? $obj->getIdBouteille() : -1) . "</td>".
                        "</tr>".
                        "<tr>".
                            "<td>qte bouteille </td>".
                            "<td> : <input type='number' min='1' name='qte_bouteille' value=\"".( $isForModifier ? $e->getQteBouteille() : "")."\" required /></td>".
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