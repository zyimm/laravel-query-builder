<?php


namespace zyimm\query\build\resolves;


class QueryOperator
{
    const like = 'like';

    const full_like = 'full_like';

    const in = 'in';

    const not_in = 'not_in';

    const eq = '=';

    const neq = '<>';

    const lq = '<';

    const rq = '>';

    const elq = '<=';

    const erq = '>=';

    const between = 'between';

    const not_between = 'not_between';


    // 运算符匹配数组
    public static $operator = [
        self::like,
        self::full_like,
        self::in,
        self::not_in,
        self::eq,
        self::neq,
        self::lq,
        self::rq,
        self::elq,
        self::erq,
        self::between,
        self::not_between
    ];

    public static $like = [
        self::like,
        self::full_like
    ];
}