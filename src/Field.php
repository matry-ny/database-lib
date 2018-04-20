<?php

namespace dk\database;

use dk\database\fields\Decimal;
use dk\database\fields\Integer;
use dk\database\fields\Text;
use dk\database\fields\TimeStamp;
use dk\database\fields\Varchar;
use InvalidArgumentException;

/**
 * Class Field
 * @package dk\database
 */
class Field
{
    const INTEGER = 'int';
    const VARCHAR = 'varchar';
    const TIMESTAMP = 'timestamp';
    const TEXT = 'text';
    const DECIMAL = 'decimal';

    /**
     * @param $type
     * @return FieldType|Integer|TimeStamp|Varchar|Text|Decimal
     */
    public function getBuilder($type)
    {
        switch ($type) {
            case self::INTEGER:
                return new Integer();
            case self::VARCHAR:
                return new Varchar();
            case self::TIMESTAMP:
                return new TimeStamp();
            case self::TEXT:
                return new Text();
            case self::DECIMAL:
                return new Decimal();
            default:
                throw new InvalidArgumentException("Field type '{$type}' is not allowed");
        }
    }
}