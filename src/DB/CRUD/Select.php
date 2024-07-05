<?php

namespace Aliaksei\Test\DB\CRUD;

use Aliaksei\Test\Config;
use Aliaksei\Test\DB\Request;
use Aliaksei\Test\Localization\Message;

class Select extends Request
{
    protected array $select = [];

    public function select(array $select): self
    {
        $this->select = $select;
        $this->state = 'select';

        return $this;
    }

    protected function prepareQuery(): string
    {
        $select = empty($this->select) ? '*': implode(', ', $this->select);

        return 'SELECT ' . $select . ' FROM ' . $this->targetTable . ' WHERE ' . $this->converWhereClause();
    }

    public function execute()
    {
        $request = static::GetConnection()->query($this->prepareQuery());

        return $request->fetchAll();
    }

    protected function convertSqlParamsForQuery(array $params): array
    {
        foreach ($params as &$param) {
            if (!is_numeric($param)) {
                $param = '"' . $param . '"';
            }
        }

        return $params;
    }
}
