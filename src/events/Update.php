<?php

namespace dk\database\events;

use dk\database\Command;

/**
 * Class Update
 * @package dk\database\events
 */
class Update extends Command
{
    /**
     * @param string $table
     * @return Update
     */
    public function update($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @param array $fields
     * @return Update
     */
    public function set(array $fields)
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @return string
     */
    public function build()
    {
        $sql = "UPDATE {$this->table} SET ";
        $fields = [];
        foreach ($this->fields as $fieldName => $value){
            $value = is_null($value) ? 'NULL' : $value;
            $preparedValue = $this->isNotString($value) ? $value : "'{$value}'";
            $fields[] = "{$fieldName} = {$preparedValue}";
        }
        $sql .= implode(',', $fields) . $this->conditions() . $this->limit;

        return $sql;
    }
}