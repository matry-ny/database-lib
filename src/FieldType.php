<?php

namespace dk\database;

/**
 * Class FieldType
 * @package dk\database
 */
abstract class FieldType
{
    /**
     * @var int
     */
    protected $length;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $primaryKey = false;

    /**
     * @var mixed
     */
    protected $default;

    /**
     * @var bool
     */
    protected $autoincrement = false;

    /**
     * @var bool
     */
    protected $notNull = false;

    /**
     * @param int $length
     * @return static
     */
    public function length($length)
    {
        $this->length = $length;
        return $this;
    }

    /**
     * @param string $name
     * @return static
     */
    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param bool $primaryKey
     * @return static
     */
    public function primaryKey($primaryKey = true)
    {
        $this->primaryKey = $primaryKey;
        return $this;
    }

    /**
     * @param mixed $value
     * @return static
     */
    public function defaultValue($value)
    {
        if ($value instanceof Expression) {
            $this->default = $value->getValue();
        } else {
            $this->default = "'{$value->getValue()}'";
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->default ? " DEFAULT {$this->default}" : '';
    }

    /**
     * @param bool $autoIncrement
     * @return static
     */
    public function autoIncrement($autoIncrement = true)
    {
        $this->autoincrement = $autoIncrement;
        return $this;
    }

    /**
     * @param bool $notNull
     * @return static
     */
    public function notNull($notNull = true)
    {
        $this->notNull = $notNull;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * @return string
     */
    public function getNotNull()
    {
        return $this->notNull ? ' NOT NULL' : '';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    abstract public function build();
}