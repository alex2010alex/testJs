<?php

namespace Aliaksei\Test\DB;

use Aliaksei\Test\Config;
use Aliaksei\Test\Localization\Message;

class Request extends Connection
{
    protected array $where = [1 => 1];

    protected string $targetTable = '';

    protected int $limit = -1;

    protected string $logicalCondition = 'and';

    protected string $compareType = 'eq';

    protected string $state;

    protected array $set = [];

    protected const SYMBOL_TABLE = [
        'eq' => '=',
        'and' => ' AND ',
        'like' => ' LIKE ' 
    ];

    public function where(string $name, string $value): self
    {
        $this->where[$name] = $value;

        return $this;
    }

    public function and(): self
    {
        $this->logicalCondition = 'and';

        return $this;
    }

    public function or(): self
    {
        $this->logicalCondition = 'or';

        return $this;
    }

    public function eq(): self
    {
        $this->compareType = 'eq';

        return $this;
    }

    public function like(): self
    {
        $this->compareType = 'like';

        return $this;
    }

    public function from(string $form): self
    {
        $this->targetTable = $form;

        return $this;
    }

    public function limit(string $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function set(array $params): self
    {
        $this->set = $params;

        return $this;
    }

    public function to(string $to): self
    {
        $this->targetTable = $to;

        return $this;
    }

    protected function convertSqlParamsForQuery(array $params): array
    {
        $result = [];

        foreach ($params as $name => $param) {
            $result[':' . $name] = $param;
        }
        return $result;
    }

    protected function mergeNameNValue(array $params, string $glue = 'eq'): array
    {
        $result = [];

        foreach ($params as $name => $param) {
            $result[] = $name . self::SYMBOL_TABLE[$glue] . $param;
        }

        return $result;
    }

    protected function converWhereClause(): string
    {
        return implode(
            self::SYMBOL_TABLE[$this->logicalCondition], 
            $this->mergeNameNValue(
                $this->convertSqlParamsForQuery($this->where, $this->compareType)
            )
        );
    }
}
