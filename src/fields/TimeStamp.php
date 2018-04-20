<?php

namespace dk\database\fields;

use dk\database\FieldType;

/**
 * Class TimeStamp
 * @package dk\database\fields
 */
class TimeStamp extends FieldType
{
    /**
     * @return string
     */
    public function build()
    {
        $field = "{$this->name} TIMESTAMP{$this->getDefault()}";
        return $field;
    }
}
