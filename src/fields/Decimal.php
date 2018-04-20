<?php

namespace dk\database\fields;

use dk\database\FieldType;

/**
 * Class Decimal
 * @package dk\database\fields
 */
class Decimal extends FieldType
{
    /**
     * @return string
     */
    public function build()
    {
        return "{$this->name} DECIMAL({$this->length}){$this->getDefault()}";
    }
}
