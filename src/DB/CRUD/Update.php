<?php

namespace Aliaksei\Test\DB\CRUD;

use Aliaksei\Test\Config;
use Aliaksei\Test\DB\Request;
use Aliaksei\Test\Localization\Message;

class Update extends Request
{
    protected function prepareQuery(): string
    {
        $result = '';

        $whereCondition = implode(
            self::SYMBOL_TABLE[$this->logicalCondition], 
            $this->mergeNameNValue(
                $this->convertSqlParamsForQuery($this->where, $this->compareType)
            )
        );

        return 'UPDATE ' . $this->targetTable . ' SET ' . implode(', ', static::mergeNameNValue($this->convertSqlParamsForQuery($this->set))) . ' WHERE ' . $this->converWhereClause();
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

    public function execute()
    {
        return static::GetConnection()->prepare($this->prepareQuery())->execute();
    }
}