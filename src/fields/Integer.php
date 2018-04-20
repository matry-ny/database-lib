<?php

namespace dk\database\fields;

use dk\database\FieldType;

/**
 * Class Integer
 * @package dk\database\fields
 */
class Integer extends FieldType
{
    /**
     * @return string
     */
    public function build()
    {
        $field = "{$this->name} INT({$this->length})";
        if ($this->autoincrement) {
            $field .= ' auto_increment';
        }
        $field .= $this->getDefault();

        return $field;
    }
}
