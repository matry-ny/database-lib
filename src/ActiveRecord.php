<?php

namespace dk\database;

use PDO;
use dk\database\exceptions\DbException;

/**
 * Class ActiveRecord
 * @package dk\database
 */
abstract class ActiveRecord extends Model
{
    use DbConnectionTrait;

    /**
     * @var string
     */
    private $primaryKey;

    /**
     * @var array
     */
    private $schema = [];

    /**
     * @var bool
     */
    private $isSelected = false;

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * ActiveRecord constructor.
     * @param PDO $connection
     * @throws DbException
     */
    public function __construct(PDO $connection)
    {
        parent::__construct($connection);

        $this->primaryKey = $this->primaryKey();
        $this->schema = $this->schema();
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    /**
     * @param array $data
     */
    public function load(array $data)
    {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->schema)) {
                $this->attributes[$key] = $value;
            }
        }
    }

    /**
     * @param array $conditions
     * @param PDO $connection
     * @return array
     * @throws DbException
     */
    public static function findAll(array $conditions = [], PDO $connection)
    {
        $query = self::find($connection);
        if ($conditions) {
            $query->where($conditions);
        }

        $models = [];
        foreach ($query->all() as $row) {
            $model = new static($connection);
            $model->load($row);

            $models[] = $model;
        }

        return $models;
    }

    /**
     * @param PDO $connection
     * @return events\Select
     * @throws DbException
     */
    public static function find(PDO $connection)
    {
        $table = (new static($connection))->tableName();

        /** @var \dk\database\events\Select $query */
        $query = (new Query())->getBuilder(Query::SELECT);
        $query->select(['*'])->from($table);

        return $query;
    }

    /**
     * @param $condition
     * @param PDO $connection
     * @return null|static
     * @throws DbException
     */
    public static function findOne($condition, PDO $connection)
    {
        $model = new static($connection);

        if (is_array($condition)) {
            $data = self::find($connection)->where($condition)->one();
        } else {
            $data = $model->getRow($condition);
        }

        if ($data) {
            $model->load($data);
            $model->isSelected = true;
            return $model;
        }

        return null;
    }

    /**
     * @param mixed $recordId
     * @return array
     */
    private function getRow($recordId)
    {
        /** @var \dk\database\events\Select $query */
        $query = $this->select(['*'])->from($this->tableName())->where(['=', $this->primaryKey, $recordId]);
        return $query->one();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function save()
    {
        if ($this->isNewRecord()) {
            $result = $this->create();
        } else {
            $result = $this->refresh();
        }

        return $result;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    private function create()
    {
        $result = $this->insert($this->tableName(), $this->attributes);

        if ($result) {
            $data = $this->getRow($this->lastInsertId());
            $this->load($data);

            return true;
        }

        return false;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    private function refresh()
    {
        return (bool)$this->update(
            $this->tableName(),
            $this->attributes,
            ['=', $this->primaryKey, $this->attributes[$this->primaryKey]]
        );
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function clear()
    {
        $result = $this->delete($this->tableName(), ['=', $this->primaryKey, $this->attributes[$this->primaryKey]]);

        if ($result) {
            $this->attributes = [];
            return true;
        }

        return false;
    }

    /**
     * @return bool
     * @throws DbException
     */
    public function isNewRecord()
    {
        return false === $this->hasPrimaryKey() || false === $this->hasDuplicatedId();
    }

    /**
     * @return bool
     */
    private function hasPrimaryKey()
    {
        return array_key_exists($this->primaryKey, $this->attributes);
    }

    /**
     * @return bool
     * @throws DbException
     */
    private function hasDuplicatedId()
    {
        return $this->isSelected || (bool)self::findOne($this->attributes[$this->primaryKey], $this->getDbConnection());
    }

    /**
     * @return string
     */
    abstract public function tableName();

    /**
     * @return array|mixed|null
     * @throws DbException
     */
    private function primaryKey()
    {
        $sql = "SHOW KEYS FROM {$this->tableName()} WHERE Key_name = 'PRIMARY'";
        $statement = $this->getDbConnection()->prepare($sql);
        $statement->execute();

        $primaryKey = isset($statement->fetch(PDO::FETCH_ASSOC)['Column_name']) ?
            $statement->fetch(PDO::FETCH_ASSOC)['Column_name'] : null;

        if (empty($primaryKey)) {
            throw new DbException("Table '{$this->tableName()}' must have primary key");
        }

        return $primaryKey;
    }

    /**
     * @return array
     */
    private function schema()
    {
        $sql = "SHOW COLUMNS FROM {$this->tableName()}";
        $statement = $this->getDbConnection()->prepare($sql);
        $statement->execute();

        $schema = [];
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $column) {
            $schema[] = $column['Field'];
        }

        return $schema;
    }
}