<?php

namespace dk\database\fields;

use dk\database\FieldType;

/**
 * Class Text
 * @package dk\database\fields
 */
class Text extends FieldType
{
    /**
     * @return string
     */
    public function build()
    {
        return "{$this->name} TEXT{$this->getDefault()}";
    }
}
