<?php

namespace dk\database;

use InvalidArgumentException;

/**
 * Class Query
 * @package dk\database
 */
class Query
{
    const CREATE_TABLE = 'create_table';
    const DROP_TABLE = 'drop_table';
    const ADD_COLUMN = 'add_column';
    const DROP_COLUMN = 'drop_column';
    const ADD_FOREIGN_KEY = 'add_foreign_key';
    const DROP_FOREIGN_KEY = 'drop_foreign_key';
    const CREATE_INDEX = 'create_index';
    const DROP_INDEX = 'drop_index';
    const INSERT = 'insert';
    const SELECT = 'select';
    const UPDATE = 'update';
    const DELETE = 'delete';

    /**
     * @var array
     */
    private $classesMap = [
        self::CREATE_TABLE => 'dk\database\events\CreateTable',
        self::DROP_TABLE => 'dk\database\events\DropTable',
        self::ADD_COLUMN => 'dk\database\events\AddColumn',
        self::DROP_COLUMN => 'dk\database\events\DropColumn',
        self::ADD_FOREIGN_KEY => 'dk\database\events\AddForeignKey',
        self::DROP_FOREIGN_KEY => 'dk\database\events\DropForeignKey',
        self::CREATE_INDEX => 'dk\database\events\CreateIndex',
        self::DROP_INDEX => 'dk\database\events\DropIndex',
        self::INSERT => 'dk\database\events\Insert',
        self::SELECT => 'dk\database\events\Select',
        self::UPDATE => 'dk\database\events\Update',
        self::DELETE => 'dk\database\events\Delete'
    ];

    /**
     * @param string $command
     * @throws InvalidArgumentException
     * @return Command
     */
    public function getBuilder($command)
    {
        if (array_key_exists($command, $this->classesMap)) {
            $commandClass = $this->classesMap[$command];
            return new $commandClass();
        }

        throw new InvalidArgumentException("Command '{$command}' is not allowed");
    }
}
