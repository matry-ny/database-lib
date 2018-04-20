<?php

namespace dk\database\events;

use dk\database\Command;

/**
 * Class Delete
 * @package dk\database\events
 */
class Delete extends Command
{
    /**
     * @return Delete
     */
    public function delete()
    {
        return $this;
    }


    /**
     * @return string
     */
    public function build()
    {
        $conditions = $this->conditions();
        $sql = "DELETE FROM {$this->table}{$conditions}{$this->limit}";

         return $sql;
    }
}