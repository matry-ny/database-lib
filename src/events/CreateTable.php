<?php

namespace dk\database\events;

use dk\database\Command;
use dk\database\FieldType;

/**
 * Class CreateTable
 * @package dk\database\events
 */
class CreateTable extends Command
{
    /**
     * @param string $table
     * @return CreateTable
     */
    public function create($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @param FieldType[] $fields
     * @return static
     */
    public function fields(array $fields)
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @return string
     */
    public function build()
    {
        $fields = [];
        $primary = null;
        foreach ($this->fields as $field) {
            /** @var FieldType $field */
            $fields[] = $field->build();
            if ($field->isPrimaryKey() && empty($primary)) {
                $primary = $field->getName();
            }
        }

        if ($primary) {
            $fields[] = "PRIMARY KEY ({$primary})";
        }

        $fields = implode(', ', $fields);
        $sql = "CREATE TABLE {$this->table} ({$fields})";

        return $sql;
    }
}