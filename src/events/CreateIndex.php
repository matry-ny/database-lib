<?php

namespace dk\database\events;

use dk\database\Command;

/**
 * Class CreateIndex
 * @package dk\database\events
 */
class CreateIndex extends Command
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $column;

    /**
     * @var bool
     */
    private $isUnique = false;

    /**
     * @param string $key
     * @return CreateIndex
     */
    public function key($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @param string $column
     * @return CreateIndex
     */
    public function column($column)
    {
        $this->column = $column;
        return $this;
    }

    /**
     * @param bool $isUnique
     * @return CreateIndex
     */
    public function unique($isUnique = true)
    {
        $this->isUnique = $isUnique;
        return $this;
    }

    /**
     * @param string $table
     * @return CreateIndex
     */
    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @return string
     */
    public function getUnique()
    {
        return $this->isUnique ? " UNIQUE" : '';
    }

    /**
     * @return string
     */
    public function build()
    {
        return "CREATE{$this->getUnique()} INDEX `{$this->key}` ON {$this->table}({$this->column})";
    }
}