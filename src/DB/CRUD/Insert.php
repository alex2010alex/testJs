<?php

namespace Aliaksei\Test\DB\CRUD;

use Aliaksei\Test\Config;
use Aliaksei\Test\DB\Request;
use Aliaksei\Test\Localization\Message;

class Insert extends Request
{
    protected function prepareQuery(): string
    {
        return 'INSERT INTO ' . $this->targetTable . ' (' . implode(', ', array_keys($this->set)) . ') VALUES (' . implode(', ', array_keys($this->convertSqlParamsForQuery($this->set))) . ')';
    }

    public function execute()
    {
        return static::GetConnection()->prepare($this->prepareQuery())->execute($this->convertSqlParamsForQuery($this->set));
    }
}
