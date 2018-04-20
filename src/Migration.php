<?php

namespace dk\database;

/**
 * Class Migration
 * @package dk\database
 */
class Migration extends Model
{
    /**
     * @param string $name
     * @param array $fields
     * @return int
     * @throws \Exception
     */
    public function createTable($name, array $fields)
    {
        /** @var \dk\database\events\CreateTable $query */
        $query = (new Query())->getBuilder(Query::CREATE_TABLE);
        return $query->create($name)->fields($fields)->execute();
    }

    /**
     * @param string $name
     * @return int
     * @throws \Exception
     */
    public function dropTable($name)
    {
        /** @var \dk\database\events\DropTable $query */
        $query = (new Query())->getBuilder(Query::DROP_TABLE);
        return $query->drop($name)->execute();
    }

    /**
     * @param string $table
     * @param FieldType $column
     * @param null $after
     * @return int
     * @throws \Exception
     */
    public function addColumn($table, FieldType $column, $after = null)
    {
        /** @var \dk\database\events\AddColumn $query */
        $query = (new Query())->getBuilder(Query::ADD_COLUMN);
        return $query->table($table)->column($column)->after($after)->execute();
    }

    /**
     * @param string $table
     * @param string $column
     * @return int
     * @throws \Exception
     */
    public function dropColumn($table, $column)
    {
        /** @var \dk\database\events\DropColumn $query */
        $query = (new Query())->getBuilder(Query::DROP_COLUMN);
        return $query->table($table)->column($column)->execute();
    }

    /**
     * @param string $name
     * @param string $table
     * @param string $column
     * @param string $refTable
     * @param string $refColumn
     * @param string|null $onUpdate
     * @param string|null $onDelete
     * @return int
     * @throws \Exception
     */
    public function addForeignKey($name, $table, $column, $refTable, $refColumn, $onUpdate = null, $onDelete = null)
    {
        /** @var \dk\database\events\AddForeignKey $query */
        $query = (new Query())->getBuilder(Query::ADD_FOREIGN_KEY);
        return $query
            ->key($name)
            ->table($table)
            ->column($column)
            ->targetTable($refTable)
            ->targetColumn($refColumn)
            ->onUpdate($onUpdate)
            ->onDelete($onDelete)
            ->execute();
    }

    /**
     * @param string $name
     * @param string $table
     * @return int
     * @throws \Exception
     */
    public function dropForeignKey($name, $table)
    {
        /** @var \dk\database\events\DropForeignKey $query */
        $query = (new Query())->getBuilder(Query::DROP_FOREIGN_KEY);
        return $query->key($name)->table($table)->execute();
    }

    /**
     * @param string $name
     * @param string $table
     * @param string $column
     * @param bool $isUnique
     * @return int
     * @throws \Exception
     */
    public function createIndex($name, $table, $column, $isUnique = false)
    {
        /** @var \dk\database\events\CreateIndex $query */
        $query = (new Query())->getBuilder(Query::CREATE_INDEX);
        return $query->key($name)->table($table)->column($column)->unique($isUnique)->execute();
    }

    /**
     * @param string $name
     * @param string $table
     * @return int
     * @throws \Exception
     */
    public function dropIndex($name, $table)
    {
        /** @var \dk\database\events\DropIndex $query */
        $query = (new Query())->getBuilder(Query::DROP_INDEX);
        return $query->key($name)->table($table)->execute();
    }

    /**
     * @param string $name
     * @param int $length
     * @return FieldType|\dk\database\fields\Integer
     */
    public function integer($name, $length)
    {
        return (new Field())->getBuilder(Field::INTEGER)->name($name)->length($length);
    }

    /**
     * @param string $name
     * @param int $length
     * @return FieldType|\dk\database\fields\Varchar
     */
    public function varchar($name, $length)
    {
        return (new Field())->getBuilder(Field::VARCHAR)->name($name)->length($length);
    }

    /**
     * @param string $name
     * @return FieldType|\dk\database\fields\TimeStamp
     */
    public function timestamp($name)
    {
        return (new Field())->getBuilder(Field::TIMESTAMP)->name($name);
    }

    /**
     * @param string $name
     * @return FieldType|\dk\database\fields\Text
     */
    public function text($name)
    {
        return (new Field())->getBuilder(Field::TEXT)->name($name);
    }

    /**
     * @param $name
     * @param int $decimalSigns
     * @return FieldType|\dk\database\fields\Decimal
     */
    public function decimal($name, $decimalSigns = 2)
    {
        return (new Field())->getBuilder(Field::DECIMAL)->name($name)->length($decimalSigns);
    }
}