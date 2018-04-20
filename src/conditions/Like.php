<?php

namespace dk\database\conditions;

use dk\database\Condition;

/**
 * Class Like
 * @package db\conditions
 */
class Like extends Condition
{
    /**
     * @return string
     */
    public function getConditionString()
    {
        return "{$this->field} {$this->marker} '{$this->value}'";
    }
}