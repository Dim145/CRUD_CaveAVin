<?php


abstract class AbstractVueRelation
{
    public static function getDebutHTML(string $titre) : string {
        return
            "<html lang=\"fr\">
                    <head>
                        <title>$titre</title>
                        <link href='../style/style.css' rel='stylesheet' type='text/css'/>
                    </head>
                    <body>
                        <center>";
    }

    public static function getFinHTML() : string {
        return
            "    <footer>
                        <marquee scrolldelay=\"25\" width=\"80%\" direction=\"LEFT\">
                            Boireau Florian | Dubois Dimitri | Mittelstaedt Arthur
                        </marquee>
                        <div class='droite'>
                            ULHN
                        </div>
                    </footer>
                <center>
            </body>
        </html>";
    }

    /**
     * Renvoi une liste déroulante en HTML selon un tableau de DataBaseObject.
     * @param DataBaseObject[] $objects Le tableau d'objets a afficher.
     * @param int $nbColumsDisplay Le nombre de colonnes a afficher. 1 par défaut.
     * @param int $currentIdSelected valeur selectionnée par default. -1 = aucune valeur de selectionnée
     * @return string
     */
    public static function getHTMLListFor( array $objects, int $nbColumsDisplay = 1, int $currentIdSelected = -1 ): string
    {
        if (count($objects) < 1   ) return "";
        if( $nbColumsDisplay < 1  ) $nbColumsDisplay = 1;

        $tabColumsName = $objects[0]->getColumsName(false);

        if ( $nbColumsDisplay > count($tabColumsName)-1 ) $nbColumsDisplay = count($tabColumsName)-1;

        $sRet = "<select name=\"".$tabColumsName[0]."\">\n";

        foreach ( $objects as $obj )
        {
            $tabValues = $obj->getColumsValues();

            $sRet .= "\t<option value=\"" . $tabValues[$tabColumsName[0]] . "\"" . ($tabValues[$tabColumsName[0]] == $currentIdSelected ? "selected" : " ") . ">";

            for ($cpt = 0; $cpt < $nbColumsDisplay; $cpt++ )
                $sRet .= $tabValues[$tabColumsName[$cpt+1]] . ", ";

            $sRet = substr($sRet, 0, strlen($sRet)-2) . "</option>\n";
        }

        return $sRet . "\n</select>";
    }

    public abstract function getHTML4Entity(DataBaseObject $e) : string;

    public abstract function getAllEntities(array $Entities) : string;

    public abstract function getForm4Entity(DataBaseObject $e, bool $isForModifier) : string;
}