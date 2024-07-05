<?php

namespace Aliaksei\Test\DB;

use Aliaksei\Test\Config;

class Connection
{
    protected static ?\PDO $Connection = null;

    public static function GetConnection(): \PDO
    {
        if (is_null(static::$Connection)) {
            static::Connect();
        }

        return static::$Connection;
    }

    private static function Connect()
    {
        $dbConfig = Config::Get('db');

        $opt = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ];

        static::$Connection = new \PDO($dbConfig['dsn'], $dbConfig['user'], $dbConfig['passwd'], $opt);
    }
}