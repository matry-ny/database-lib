<?php

namespace dk\database;

use InvalidArgumentException;
use dk\database\conditions\Equals;
use dk\database\conditions\In;
use dk\database\conditions\Like;

/**
 * Interface ConditionInterface
 * @package dk\database
 */
abstract class Condition
{
    const EQUALS = ['=', '!=', '>', '>=', '<', '<='];
    const IN = ['in', 'not in'];
    const LIKE = ['like', 'not like'];

    /**
     * @var string
     */
    protected $field;

    /**
     * @var string
     */
    protected $marker;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * Equals constructor.
     * @param string $field
     * @param string $marker
     * @param mixed $value
     */
    public function __construct($field, $marker, $value)
    {
        $this->field = $field;
        $this->marker = $marker;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public abstract function getConditionString();

    /**
     * @param array $condition
     * @return string
     */
    public static function getCondition(array $condition)
    {
        $marker = $condition[0];
        if (in_array($marker, self::EQUALS)) {
            return (new Equals($condition[1], $marker, $condition[2]))->getConditionString();
        } elseif (in_array($marker, self::IN)) {
            return (new In($condition[1], $marker, $condition[2]))->getConditionString();
        } elseif (in_array($marker, self::LIKE)) {
            return (new Like($condition[1], $marker, $condition[2]))->getConditionString();
        }

        throw new InvalidArgumentException("Condition '{$marker}' is not allowed");
    }
}