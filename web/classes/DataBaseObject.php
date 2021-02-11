<?php

/**
 * Class DataBaseObject
 * Objet abstrait qui permettra de condenser le code dans le but d'afficher un DataBaseObject
 * et non plus un objet précis
 */
abstract class DataBaseObject
{
    private ?ReflectionClass $reflexion = null;

    public abstract function getColumsName( bool $includeSubObjects ): array; // abstract = Important pour filtrer les nom de colums selon la class si besoin
    public abstract function setObjects(): void;
    public abstract function __toString(): string;
    public abstract function toStringPageForm(bool $isForModifier = false): string;

    public function getReflexion(): ReflectionClass
    {
        if( $this->reflexion == null ) $this->reflexion = new ReflectionClass($this);

        return $this->reflexion;
    }

    /**
     * Permet d'initialisé les attributs dans le cas de la création vierge d'une objet.
     * @throws ReflectionException
     */
    public function initAllVariables(): void
    {
        $allAtribute = $this->getReflexion()->getProperties(ReflectionProperty::IS_PRIVATE);

        foreach ( $allAtribute as $attribute )
        {
            $isPrivate = false;
            if ($attribute->isPrivate())
            {
                $attribute->setAccessible(true);
                $isPrivate = true;
            }

            $attribute->setValue($this, $attribute->getType()->allowsNull() ? null : 0);

            if ($isPrivate) $attribute->setAccessible(false);
        }
    }

    public function getNbColums(): int
    {
        return count($this->getColumsName(false));
    }

    public function getColumsValues(): array
    {
        $comlumsName = $this->getColumsName(false);

        $colums = array();

        foreach ( $comlumsName as $colName )
        {
            $attribute = $this->getReflexion()->getProperty($colName);

            $isPrivate = false;
            if ($attribute->isPrivate())
            {
                $attribute->setAccessible(true);
                $isPrivate = true;
            }

            $colums[$attribute->getName()] = $attribute->getValue($this);

            if ($isPrivate) $attribute->setAccessible(false);
        }

        return $colums;
    }

    public function saveInDB()  : void
    {
        $bdd = FonctionsUtiles::getBDD();
        $ref = $this->getReflexion();

        $tabName  = $this->getColumsName(false);
        $tabValue = $this->getColumsValues();

        $statement = $bdd->query("SELECT * FROM " . $ref->getName() . " WHERE $tabName[0] = " . $tabValue[$tabName[0]] );

        if( $statement->fetch() && $tabValue[$tabName[0]] > 0 ) // n'est pas un nouveaux
        {
            $str = "UPDATE " . $ref->getName() . " SET ";

            foreach ($tabValue as $key => $value )
                $str .= $key . " = " . (is_string($value) ? "'$value'" : $value ) . ", ";
            $str = substr($str, 0, strlen($str)-2) . " WHERE " . $tabName[0] . " = " . $tabValue[$tabName[0]];

            $bdd->exec($str);
        }
        else // est un nouveau
        {
            $str = "INSERT INTO " . $ref->getName() . " (";
            foreach ( $tabName as $nameCol )
                if( !str_contains($nameCol, "id_" . strtolower($ref->getName())) )
                    $str .= $nameCol . ", ";
            $str = substr($str, 0, strlen($str)-2) . ") VALUES (";

            foreach ($tabValue as $key => $value )
                if( !str_contains($key, "id_" . strtolower($ref->getName())) )
                    $str .= (is_string($value) ? "'$value'" : $value ) . ", ";
            $str = substr($str, 0, strlen($str)-2) . ")";

            $bdd->exec($str);
        }
    }
}