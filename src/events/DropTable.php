<?php

namespace dk\database\events;

use dk\database\Command;

/**
 * Class DropTable
 * @package dk\database\events
 */
class DropTable extends Command
{
    /**
     * @param string $table
     * @return DropTable
     */
    public function drop($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @return string
     */
    public function build()
    {
        return "DROP TABLE {$this->table}";
    }
}