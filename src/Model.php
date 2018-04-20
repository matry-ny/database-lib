<?php

namespace dk\database;

/**
 * Class Model
 * @package dk\database
 */
abstract class Model
{
    use DbConnectionTrait;

    /**
     * @param array $fields
     * @return \dk\database\events\Select
     */
    public function select(array $fields)
    {
        /** @var \dk\database\events\Select $query */
        $query = (new Query())->getBuilder(Query::SELECT);
        return $query->select($fields);
    }

    /**
     * @param string $table
     * @param array $fields
     * @return int
     * @throws \Exception
     */
    public function insert($table, array $fields)
    {
        /** @var \dk\database\events\Insert $query */
        $query = (new Query())->getBuilder(Query::INSERT);
        return $query->insert($fields)->into($table)->execute();
    }

    /**
     * @param string $table
     * @param array $fields
     * @param array $conditions
     * @return int
     * @throws \Exception
     */
    public function update($table, array $fields, array $conditions)
    {
        /** @var \dk\database\events\Update $query */
        $query = (new Query())->getBuilder(Query::UPDATE);
        return $query->update($table)->set($fields)->where($conditions)->execute();
    }

    /**
     * @param string $table
     * @param array $conditions
     * @param null $limit
     * @return int
     * @throws \Exception
     */
    public function delete($table, array $conditions = [], $limit = null)
    {
        /** @var \dk\database\events\Delete $query */
        $query = (new Query())->getBuilder(Query::DELETE);
        $query->delete()->from($table)->where($conditions);
        if ($limit) {
            $query->limit($limit);
        }

        return $query->execute();
    }

    /**
     * @return string
     */
    public function lastInsertId()
    {
        return $this->getDbConnection()->lastInsertId();
    }
}
