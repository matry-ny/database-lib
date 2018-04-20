<?php

namespace dk\database;

use PDO;

/**
 * Trait DbConnectionTrait
 * @package dk\database
 */
trait DbConnectionTrait
{
    /**
     * @var PDO
     */
    private $connection;

    /**
     * DbConnectionTrait constructor.
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return PDO
     */
    function getDbConnection()
    {
        return $this->connection;
    }
}
