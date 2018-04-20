<?php

namespace dk\database\events;

use dk\database\Command;

/**
 * Class DropColumn
 * @package dk\database\events
 */
class DropColumn extends Command
{
    /**
     * @var string
     */
    private $column;

    /**
     * @param string $column
     * @return DropColumn
     */
    public function column($column)
    {
        $this->column = $column;
        return $this;
    }

    /**
     * @param string $table
     * @return DropColumn
     */
    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @return string
     */
    public function build()
    {
        return "ALTER TABLE {$this->table} DROP COLUMN {$this->column}";
    }
}