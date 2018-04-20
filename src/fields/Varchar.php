<?php

namespace dk\database\fields;

use dk\database\FieldType;

/**
 * Class Varchar
 * @package dk\database\fields
 */
class Varchar extends FieldType
{
    /**
     * @return string
     */
    public function build()
    {
        return "{$this->name} VARCHAR({$this->length}){$this->getNotNull()}{$this->getDefault()}";
    }
}
