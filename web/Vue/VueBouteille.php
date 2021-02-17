<?php


class VueBouteille extends AbstractVueRelation
{

    public function getHTML4Entity(DataBaseObject $e): string
    {
        if($e instanceof bouteille) {
            return "<tr class='EntityDescription BouteilleDescription'><td>" . $e->getNomBouteille() . "</td><td>" .
                $e->getMillesimeBouteille() . "</td><td>" .
                $e->getPrixBouteille() . "</td><td>" .
                $e->getVolumeBouteille() . " Cl</td><td>" .
                $e->getAppellation()->getNomAppellation() . "</td><td>" .
                $e->getCategorie()->getRobeBouteille() . "</td>".
                "<td><form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST'>".
                "<input type='SUBMIT' name='actionSurTuple' value='Modifier'  class='bouton boutonModifier'/>".
                "<input type='HIDDEN' name='PK'          value='".$e->getId()."'/>".
                "<input type='SUBMIT' name='actionSurTuple' value='Supprimer' class='bouton boutonSupprimer'/>".
                "</form></td></tr>";
        } else return "";
    }

    public function getAllEntities(array $Entities): string
    {
        $All = "<div class='fondTableau'><table class='AllEntities AllBouteille'>";
        $All .= "<tr><th>nom_bouteille</th><th>millesime_bouteille</th><th>prix_bouteille</th><th>volume_bouteille</th><th>nom_appellation</th><th>robe_bouteille</th><th>Action</th></tr>";
        foreach($Entities as &$e){
            $All .= $this->getHTML4Entity($e);
        }
        $All .= "</table></div>";
        return $All;
    }

    public function getForm4Entity(DataBaseObject $e, bool $isForModifier): string
    {
        if($e instanceof bouteille) {
            $value = $isForModifier ? $e->getVolumeBouteille() : null;
            $selectVolume = self::getSelectForAttribute("volume_bouteille", "--Selectionnez un volume", bouteille::volumes, $isForModifier, $value);
            return "<form action=".$_SERVER['PHP_SELF']."?table=".$_GET['table']." method='POST'>".
                        "<div class='fondTableau'><table>".
                            "<tr>".
                                "<td>nom_bouteille         </td>".
                                "<td>"." : "."<input type='text' name='nom_bouteille'         value=\"" . ($isForModifier ? $e->getNomBouteille() : "") . "\" required/></td>".
                            "</tr>".
                            "<tr>".
                                "<td>volume_bouteille   (Cl)</td>".
                                // "<td>"." : "."<input type='text' name='volume_bouteille'      value=\"" . ($isForModifier ? $e->getVolumeBouteille() : "") . "\" required pattern='^(37.5|75|150|300|500|600|900|1200|1500|1800)$' title='Doit être égale a 37.5,  75, 150, 300, 500, 600, 900, 1200, 1500 ou 1800'/></td>".
                                "<td>"." : ". $selectVolume."</td>".
                            "</tr>".
                            "<tr>".
                                "<td>millesime_bouteille   </td>".
                                "<td>"." : "."<input type='number' name='millesime_bouteille'   value=\"" . ($isForModifier ? $e->getMillesimeBouteille() : "") . "\" required min='1' max='2099' step='1' title='Doit être entre 1 et 2099 compris'/></td></tr>" .
                            "<tr><td>prix_bouteille        </td><td>"." : "."<input type='number' name='prix_bouteille'        value=\"" . ($isForModifier ? $e->getPrixBouteille() : "") . "\" required pattern='^\d+(.\d{1,2})?$'
                                                                                  title='Doit être composé de chiffre et eventuellement de 2 chiffres apres le point'/></td></tr>" .
                            "<tr><td>Appellation           </td><td>"." : ". AbstractVueRelation::getHTMLListFor(FonctionsSGBD::getAllFromClassName(Appellation::class), 2, $isForModifier ? $e->getIdAppellation() : -1)."</td></tr>".
                            "<tr><td>Categorie             </td><td>"." : ". AbstractVueRelation::getHTMLListFor(FonctionsSGBD::getAllFromClassName(Categorie::class), 3, $isForModifier ? $e->getIdCategorie() : -1)  ."</td></tr>".
                            "<tr><td colspan=2><input type='SUBMIT' name='actionSurTuple' value='Confirmer' class='bouton boutonCreer'/></td></tr>".
                        "</table></div>".
                        ($isForModifier ? "<input type='HIDDEN' name='PK' value='".$e->getId()."'/>" : " ").
                    "</form>";
        } else return "";
    }
}