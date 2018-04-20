<?php

namespace dk\database\events;

use dk\database\Command;

/**
 * Class Insert
 * @package dk\database
 */
class Insert extends Command
{
    /**
     * @param array $fields
     * @return Insert
     */
    public function insert(array $fields)
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @param string $table
     * @return Insert
     */
    public function into($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @return string
     */
    public function build()
    {
        $values = [];
        $fields = implode(array_keys($this->fields), ',');
        foreach ($this->fields as $value){
            $value = is_null($value) ? 'NULL' : $value;
            $values[] = $this->isNotString($value) ? $value : "'{$value}'";
        }
        $valuesString = implode($values, ',');

        return "INSERT INTO {$this->table} ({$fields}) VALUES ({$valuesString})";
    }

}