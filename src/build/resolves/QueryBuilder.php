<?php

namespace zyimm\query\build\resolves;


use Illuminate\Support\Str;

/**
 * Class QueryBuilder
 *
 * @package zyimm\query\resolves
 */
class QueryBuilder
{
    public $condition = [];

    public $params = [];

    public $where = [];

    public $aliasCount = [];

    private $alias, $field, $operator;

    /**
     * QueryBuilder constructor.
     *
     * @param  array  $condition
     * @param  array  $params
     */
    public function __construct(array $condition, array $params)
    {
        $this->condition = $condition;
        $this->params    = $params;
    }

    /**
     * can handleMap
     *
     * @return string[][]
     */
    public function handleMap(): array
    {
        return [
            'general'   => [
                QueryOperator::LIKE,
                QueryOperator::FULL_LIKE,
                QueryOperator::EQ,
                QueryOperator::NEQ,
                QueryOperator::LQ,
                QueryOperator::RQ,
                QueryOperator::ELQ,
                QueryOperator::ERQ,
            ],
            'inBetween' => [
                QueryOperator::IN,
                QueryOperator::NOT_IN,
                QueryOperator::BETWEEN,
                QueryOperator::NOT_BETWEEN
            ]
        ];
    }


    /**
     * handle
     *
     * @return bool
     */
    public function handle(): bool
    {
        $map = $this->handleMap();
        foreach ($map as $key => $handle) {
            if (in_array($this->operator, $handle)) {
                call_user_func([$this, $key]);
                return true;
            }
        }
        return false;
    }

    /**
     * build
     *
     * @return array
     */
    public function build(): array
    {
        // foreach operator
        foreach ($this->condition as $operator => $fields) {
            // check
            if (!in_array(strtolower($operator), QueryOperator::$operator, true)) {
                continue;
            }
            // iteration fields
            foreach ($fields as $field) {
                if (!isset($this->params[$field])) {
                    continue;
                }
                $this->operator = strtolower($operator);
                // defineAliasField
                $this->defineAliasField($field)->handle();
            }
        }
        return $this->where;
    }

    /**
     * defineAliasField
     *
     * @param  string  $field
     * @return $this
     */
    private function defineAliasField(string $field = ''): QueryBuilder
    {
        if (stripos($field, '.')) {
            list ($this->alias, $this->field) = explode('.', $field);
            $this->alias .= '.';
            array_push($this->aliasCount, $this->alias);
        } else {
            $this->alias = '';
        }
        $this->field = $field;
        return $this;
    }

    /**
     * inBetween
     *
     * @return $this
     */
    public function inBetween(): QueryBuilder
    {
        $val = $this->returnArray($this->params[$this->field]);
        // set $this->where
        $this->where[$this->alias.$this->field.$this->operator] = [
            $this->alias.$this->field,
            Str::camel('where_'.$this->operator),
            $val
        ];
        return $this;
    }

    /**
     * general
     *
     * @return $this
     */
    public function general(): QueryBuilder
    {
        $val = $this->handleField();
        if (in_array($this->operator, QueryOperator::$like)) {
            $this->operator = QueryOperator::LIKE;
        }
        $this->where[$this->alias.$this->field.$this->operator] = [
            $this->alias.$this->field,
            $this->operator.'.where',
            $val
        ];
        return $this;
    }

    /**
     * handleField
     *
     * @return mixed|string
     */
    private function handleField()
    {
        switch ($this->operator) {
            case 'like':
                $value = $this->params[$this->field].'%';
                break;
            case 'full_like':
                $value = '%'.$this->params[$this->field].'%';
                break;
            default:
                $value = $this->params[$this->field];
                break;
        }
        return $value;
    }

    /**
     * return array
     *
     * @param $param
     * @return array
     */
    private function returnArray($param): array
    {
        if (!is_array($param)) {
            foreach ([',', '.'] as $type) {
                if (stripos($param, $type)) {
                    $param = explode($type, $param);
                    break;
                }
            }
        }
        return is_array($param) ? $param : [$param];
    }
}
