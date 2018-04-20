<?php

namespace dk\database;

/**
 * Class Command
 * @package dk\database
 */
abstract class Command
{
    use DbConnectionTrait;

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var null|string
     */
    protected $table = null;

    /**
     * @var
     */
    protected $whereDelimiter = 'AND';

    /**
     * @var array
     */
    protected $where = [];

    /*
     * @var str
     */
    protected $orderBy;

    /**
     * @var array
     */
    protected $andWhere = [];

    /**
     * @var array
     */
    protected $orWhere = [];

    /**
     * @var array
     */
    protected $join = [];

    /**
     * @var string
     */
    protected $limit;

    /**
     * @return string
     */
    abstract function build();

    /**
     * @param array $conditions
     * @param string $delimiter
     * @param string $variable
     * @return static
     */
    public function where(array $conditions, $delimiter = 'AND', $variable = 'where')
    {
        $this->whereDelimiter = $delimiter;

        if (is_array(current($conditions))) {
            foreach ($conditions as $condition) {
                $this->{$variable}[] = Condition::getCondition($condition);
            }
        } else {
            $this->{$variable}[] = Condition::getCondition($conditions);
        }

        return $this;
    }

    /**
     * @param array $conditions
     * @return Command
     */
    public function andWhere(array $conditions)
    {
        $this->where($conditions, 'AND', 'andWhere');
        return $this;
    }

    /**
     * @param array $conditions
     * @return Command
     */
    public function orWhere(array $conditions)
    {
        $this->where($conditions, 'OR', 'orWhere');
        return $this;
    }

    /**
     * @param string $table
     * @return Command
     */
    public function from($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @param string $field
     * @param int $order
     * @return Command
     */
    public function orderBy($field, $order = SORT_ASC)
    {
        $orderDirection = $order == SORT_ASC ? 'ASC' : 'DESC';
        $this->orderBy = " ORDER BY " . $field . " " . $orderDirection;
        return $this;
    }

    /**
     * @param int $amount
     * @return Command
     */
    public function limit($amount)
    {
        $this->limit = " LIMIT {$amount}";
        return $this;
    }

    /**
     * @return string
     */
    protected function conditions()
    {
        $conditions = '';

        if (empty($this->where) && empty($this->andWhere) && empty($this->orWhere)) {
            return $conditions;
        }

        $conditions .= implode(" {$this->whereDelimiter} ", $this->where);

        $andDelimiter = $conditions && $this->andWhere ? ' AND ' : '';
        $conditions .= $andDelimiter . implode(' AND ', $this->andWhere);

        $orDelimiter = $conditions && $this->orWhere ? ' OR ' : '';
        $conditions .= $orDelimiter . implode(' OR ', $this->orWhere);

        return " WHERE {$conditions}";
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function execute()
    {
        $result = $this->getDbConnection()->exec($this->build());
        if (false === $result) {
            $error = $this->getDbConnection()->errorInfo();
            $message = array_key_exists(2, $error) ? $error[2] : 'Undefinded DB error';

            throw new \Exception($message);
        }

        return $result;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    protected function isNotString($value)
    {
        $notStrings = ['NULL'];
        return is_numeric($value) || in_array($value, $notStrings);
    }
}