<?php

namespace dk\database\events;

use dk\database\Command;

/**
 * Class AddForeignKey
 * @package dk\database\events
 */
class AddForeignKey extends Command
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
     * @var string
     */
    private $targetTable;

    /**
     * @var string
     */
    private $targetColumn;

    /**
     * @var string
     */
    private $onUpdate;

    /**
     * @var string
     */
    private $onDelete;

    /**
     * @param string $key
     * @return AddForeignKey
     */
    public function key($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @param string $column
     * @return AddForeignKey
     */
    public function column($column)
    {
        $this->column = $column;
        return $this;
    }

    /**
     * @param string $table
     * @return AddForeignKey
     */
    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @param string $targetTable
     * @return AddForeignKey
     */
    public function targetTable($targetTable)
    {
        $this->targetTable = $targetTable;
        return $this;
    }

    /**
     * @param string $targetColumn
     * @return AddForeignKey
     */
    public function targetColumn($targetColumn)
    {
        $this->targetColumn = $targetColumn;
        return $this;
    }

    /**
     * @param string $onUpdate
     * @return AddForeignKey
     */
    public function onUpdate($onUpdate)
    {
        $this->onUpdate = $onUpdate;
        return $this;
    }

    /**
     * @param string $onDelete
     * @return AddForeignKey
     */
    public function onDelete($onDelete)
    {
        $this->onDelete = $onDelete;
        return $this;
    }

    /**
     * @return string
     */
    public function build()
    {
        $query = vsprintf('ALTER TABLE %s ADD CONSTRAINT `%s` FOREIGN KEY (%s) REFERENCES %s(%s)', [
            $this->table,
            $this->key,
            $this->column,
            $this->targetTable,
            $this->targetColumn
        ]);
        if ($this->onUpdate) {
            $query .= " ON UPDATE {$this->onUpdate}";
        }
        if ($this->onDelete) {
            $query .= " ON DELETE {$this->onDelete}";
        }

        return $query;
    }
}