<?php

namespace dk\database\conditions;

use dk\database\Condition;

class In extends Condition
{
    /**
     * @return string
     */
    public function getConditionString()
    {
        $options = "'" . implode("', '", $this->value) . "'";
        return "{$this->field} {$this->marker} ({$options})";
    }
}