<?php

namespace dk\database\conditions;

use dk\database\Condition;

/**
 * Class Equals
 * @package db\conditions
 */
class Equals extends Condition
{
    /**
     * @return string
     */
    public function getConditionString()
    {
        return "{$this->field} {$this->marker} '{$this->value}'";
    }
}