<?php


class DataBaseObjectIterator implements Iterator, Countable
{
    private int $currentId;
    private ReflectionClass $class;

    private int $count; // stockage dans un objets pour eviter un nb de requetes trop grand a la base de donnée
    // une methode pour refresh ce nb seras implémenter.

    public function __construct( string $class )
    {
        $this->currentId = 0;
        $this->class     = new ReflectionClass($class);

        $this->count = -1;
    }

    /**
     * @inheritDoc
     */
    public function current(): ?DataBaseObject
    {
        $bdd = FonctionsUtiles::getBDD();
        $reponse = $bdd->query("SELECT * FROM " . $this->class->name . " where id_" . $this->class->name . " = $this->currentId");

        $object = $reponse->fetchObject($this->class->getName());

        if( $object === false ) return null;

        return $object;
    }

    /**
     * @inheritDoc
     */
    public function next(): void
    {
        $this->currentId++;
    }

    /**
     * @inheritDoc
     */
    public function key(): int
    {
        return $this->currentId;
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return $this->currentId < $this->count() && $this->currentId > 0;
    }

    /**
     * @inheritDoc
     */
    public function rewind(): void
    {
        $this->currentId = 1;
    }

    public function count()
    {
        if( $this->count < 0 ) $this->majNbInstance();

        return $this->count;
    }

    public function majNbInstance(): void
    {
        $this->count = FonctionsUtiles::getNbInstanceOf($this->class->getName());
    }
}