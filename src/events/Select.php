<?php

namespace dk\database\events;

use PDO;
use dk\database\Command;
use dk\database\DbConnectionTrait;
use dk\database\SelectIterator;

/**
 * Class Select
 * @package dk\database\events
 */
class Select extends Command
{
    use DbConnectionTrait;

    /**
     * @var SelectIterator
     */
    private $selectIterator;

    /**
     * Select constructor.
     * @param PDO $connection
     * @param $iteratorClass
     */
    public function __construct(PDO $connection, $iteratorClass)
    {
        parent::__construct($connection);
        $this->selectIterator = $iteratorClass;
    }

    /**
     * @param array $fields
     * @return Select
     */
    public function select(array $fields)
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @return string
     */
    function build()
    {
        $fields = implode(', ', $this->fields);
        $conditions = $this->conditions();
        return "SELECT {$fields} FROM {$this->table}{$conditions}{$this->orderBy}{$this->limit}";
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->execute()->fetchAll(PDO::FETCH_ASSOC);
    }

    public function each($stack = 100)
    {
        $iteratorClass = $this->selectIterator;
        return new $iteratorClass($this->build(), $stack);
    }

    /**
     * @return array
     */
    public function column()
    {
        return $this->execute()->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * @return array
     */
    public function one()
    {
        return $this->execute()->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @return bool
     */
    public function exists()
    {
        return $this->execute()->rowCount() > 0;
    }

    /**
     * @return \PDOStatement
     */
    public function execute()
    {
        $query = $this->getDbConnection()->query($this->build(), PDO::FETCH_ASSOC);
        $query->execute();

        return $query;
    }
}
