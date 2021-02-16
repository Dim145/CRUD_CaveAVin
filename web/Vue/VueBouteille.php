<?php


class VueBouteille extends AbstractVueRelation
{

    public function getHTML4Entity(DataBaseObject $e): string
    {
        if(($e instanceof bouteille)) {
            $PK = $e.getId();
            return "<tr class='EntityDescription BouteilleDescription'><td>" . $e->getNomBouteille() . "</td><td>" .
                $e->getMillesimeBouteille() . "</td><td>" .
                $e->getPrixBouteille() . "</td><td>" .
                $e->getVolumeBouteille() . "</td><td>" .
                $e->getAppellation()->get_nom_appellation() . "</td><td>" .
                $e->getCategorie()->get_robe_bouteille() . "</td>".
                "<td><a href='?action=ModifierEntite&PK=".$PK."'>Modifier</a>".
                "<a href='?action=SupprimerEntite&PK=".$PK."'>Supprimer</a> </td></tr>";
        } else return "";
    }

    public function getAllEntities(array $Entities): string
    {
        $All = "<table class='AllEntities AllBouteille'>";
        $All .= "<tr><th>nom_bouteille</th><th>millesime_bouteille</th><th>volume_bouteille</th><th>prix_bouteille</th><th>nom_appellation</th><th>robe_bouteille</th><th>Action</th></tr>";
        foreach($Entities as &$e){
            $All .= $this->getHTML4Entity($e);
        }
        $All .= "</table>";
        return $All;
    }

    public function getForm4Entity(DataBaseObject $e, bool $isForModifier): string
    {
        if(($e instanceof bouteille)) {
            $get = $isForModifier ? "?action=ModifierEntite" : "?action=InsererEntite";
            return "<form class='EntityForm BouteilleForm' action='".$_SERVER['PHP_SELF'] . $get . "' method='GET'><table><tr><td>nom_bouteille         </td><td>"." : "."<input type='text' name='nom_bouteille'         value=\"" . (isForModifier ? $this->nom_bouteille : "") . "\" required/></td></tr>" .
                "<tr><td>volume_bouteille      </td><td>"." : "."<input type='text' name='volume_bouteille'      value=\"" . ($isForModifier ? $this->volume_bouteille : "") . "\" required pattern='^(37.5|75|150|300|500|600|900|1200|1500|1800)$'
                                                                          title='Doit être égale a 37.5,  75, 150, 300, 500, 600, 900, 1200, 1500 ou 1800'/></td></tr>" .
                "<tr><td>millesime_bouteille   </td><td>"." : "."<input type='text' name='millesime_bouteille'   value=\"" . ($isForModifier ? $this->millesime_bouteille : "") . "\" required pattern='^((100)|([0-1]?[0-9]?[0-9]?[0-9]?)|([2][0][0-9][0-9]?))$'
                                                                          title='Doit être entre 0 et 2099 non compris'/></td></tr>" .
                "<tr><td>prix_bouteille        </td><td>"." : "."<input type='text' name='prix_bouteille'        value=\"" . ($isForModifier ? $this->prix_bouteille : "") . "\" required pattern='^\d+(.\d{1,2})?$'
                                                                          title='Doit être composé de chiffre et eventuellement de 2 chiffres apres le point'/></td></tr>" .
                "<tr><td>Appellation           </td><td>"." : ". FonctionsUtiles::getHTMLListFor(FonctionsUtiles::getAllFromClassName(Appellation::class), 2, $isForModifier ? $this->id_appellation : -1)."</td></tr>".
                "<tr><td>Categorie             </td><td>"." : ". FonctionsUtiles::getHTMLListFor(FonctionsUtiles::getAllFromClassName(Categorie::class), 3, $isForModifier ? $this->id_categorie : -1)  ."</td></tr></table></form>";
        } else return "";
    }
}