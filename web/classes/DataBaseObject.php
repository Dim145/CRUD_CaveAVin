<?php

/**
 * Class DataBaseObject
 * Objet abstrait qui permettra de condenser le code dans le but d'afficher un DataBaseObject
 * et non plus un objet précis
 */
abstract class DataBaseObject
{
    private ?ReflectionClass $reflexion = null;

    public abstract function getColumsName(): array; // abstract = Important pour filtrer les nom de colums selon la class si besoin

    public abstract function saveInDB(): void;
    public abstract function setObjects(): void;
    public abstract function __toString(): string;

    protected function getReflexion(): ReflectionClass
    {
        if( $this->reflexion == null ) $this->reflexion = new ReflectionClass(objectOrClass: $this);

        return $this->reflexion;
    }

    public function getNbColums(): int
    {
        return count($this->getColumsName());
    }

    public function getColumsValues(): array
    {
        $comlumsName = $this->getColumsName();

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
}