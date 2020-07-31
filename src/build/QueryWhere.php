<?php

namespace zyimm\query\build;

use Illuminate\Database\Eloquent\Builder;
use zyimm\query\build\resolves\QueryBuilder;

/**
 * Class QueryWhere
 *
 * @package zyimm\query
 */
class QueryWhere
{

    /**
     * 查询构造器
     *
     * @param $params
     * @param $condition
     * @param $query
     */
    public function buildQueryWhere($params, $condition, &$query)
    {
        $where = (new QueryBuilder($condition, $params))->build();
        //自动执行闭包查询
        $this->executeQuery($where, $query);
    }

    /**
     * Execute closure query
     *
     * @param $where
     * @param $query Builder
     */
    private function executeQuery($where, &$query)
    {
        foreach ($where as  $extra) {
            if (stripos($extra[1],'.') !== false) {
                $operator = explode('.', $extra[1]);
                $extra[1] = reset($operator);
                $operator = array_pop($operator);
            } else {
                $operator = $extra[1];
                unset($extra[1]);
            }
            call_user_func_array([$query, $operator], $extra);
        }
    }
}
