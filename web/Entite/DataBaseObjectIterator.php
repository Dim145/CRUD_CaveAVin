<?php
namespace entite;

use PDOStatement;
use ReflectionClass;
use sgbd;

class DataBaseObjectIterator implements \Iterator, \Countable
{
    private ?DataBaseObject  $current;
    private ReflectionClass $class;
    private string $orderBy;

    private int $count; // stockage dans un objets pour eviter un nb de requetes trop grand a la base de donnée
    // une methode pour refresh ce nb seras implémenter.

    private PDOStatement $statement;

    public function __construct( string $class, string $orderBy)
    {
        $this->class = new ReflectionClass($class);
        $this->orderBy = $orderBy;
        $this->count = -1;

        if( array_search($orderBy, $this->class->newInstance()->getColumsName(false)) === false )
            $this->orderBy = "";
    }

    /**
     * @return DataBaseObject
     * @inheritDoc
     */
    public function current(): DataBaseObject
    {
        return $this->current;
    }

    /**
     * @inheritDoc
     */
    public function next(): void
    {
        $tmp = $this->statement->fetchObject($this->class->getName());

        if( $tmp === false ) $this->current = null;
        else {
            $tmp->setObjects();
            $this->current = $tmp;
        }
    }

    /**
     * @inheritDoc
     */
    public function key(): int
    {
        return $this->current->getColumsValues()[$this->current->getColumsValues()[0]]; // 1 = id
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return $this->current != null;
    }

    /**
     * @inheritDoc
     */
    public function rewind(): void
    {
        $bdd = sgbd\FonctionsSGBD::getBDD();
        $tableName = $this->class->getShortName();

        if($this->orderBy == "")
            $this->statement = $bdd->query("SELECT * FROM $tableName");
        else
            $this->statement = $bdd->query("SELECT * FROM $tableName ORDER BY $this->orderBy");

        $this->next();
    }

    public function count()
    {
        if( $this->count < 0 ) $this->majNbInstance();

        return $this->count;
    }

    public function majNbInstance(): void
    {
        $this->count = sgbd\FonctionsSGBD::getNbInstanceOf($this->class->getName());
    }
}