<?php


class VueQuantite extends AbstractVueRelation
{

    public function getHTML4Entity(DataBaseObject $e): string
    {
        if($e instanceof quantite){
            $PK = $e->getNomBouteille() . "," . $e->getVolumeBouteille() . "," . $e->getMillesimeBouteille();
            return "<tr class='EntityDescription QuantiteDescription'><td>" . $e->getNomBouteille()       . "</td><td>"
                . $e->getVolumeBouteille()              . "</td><td>"
                . $e->getMillesimeBouteille()           . "</td><td>"
                . $e->getQteBouteille()                 . "</td>"
                . "<td><a href='?action=ModifierEntite&PK=".$PK."'>Modifier</a>".
                    "<a href='?action=SupprimerEntite&PK=".$PK."'>Supprimer</a> </td></tr>";
        } else return "";
    }

    public function getAllEntities(array $Entities): string
    {
        $All = "<table class='AllEntities AllQuantite'>";
        $All .= "<tr><th>nom_bouteille</th><th>volume_bouteille</th><th>millesime_bouteille</th><th>qte_bouteille</th><th>Action</th></tr>";
        foreach($Entities as &$e){
            $All .= $this->getHTML4Entity($e);
        }
        $All .= "</table>";
        return $All;
    }

    public function getForm4Entity(DataBaseObject $e, bool $isForModifier): string
    {
        if($e instanceof quantite){
            if( $isForModifier )
            {
                $bdd = FonctionsUtiles::getBDD();
                $statement = $bdd->prepare("Select * from bouteille WHERE nom_bouteille = ? AND ".
                    "volume_bouteille = ? AND millesime_bouteille = ?");
                $statement->execute(array($this->nom_bouteille, $this->volume_bouteille, $this->millesime_bouteille));
                $obj = $statement->fetchObject(Bouteille::class);
            }
            $get = $isForModifier ? "?action=ModifierEntite" : "?action=InsererEntite";
            return "<form class='EntityForm QuantiteForm' action='".$_SERVER['PHP_SELF']. $get . "' method='GET'><table><tr><td>bouteille     </td><td> : " . FonctionsUtiles::getHTMLListFor(FonctionsUtiles::getAllFromClassName(Bouteille::class), 2, $isForModifier ? $obj->getIdBouteille() : -1) . "</td></tr>".
                "<tr><td>qte bouteille </td><td> : <input type='number' name='qte_bouteille' value=\"".( $isForModifier ? $e->getQteBouteille() : "")."\" required /></td></tr></table></form>";
        } else return "";
    }
}