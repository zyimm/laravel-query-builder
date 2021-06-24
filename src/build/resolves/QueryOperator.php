<?php


namespace zyimm\query\build\resolves;


class QueryOperator
{
    const LIKE = 'like';

    const FULL_LIKE = 'full_like';

    const IN = 'in';

    const NOT_IN = 'not_in';

    const EQ = '=';

    const NEQ = '<>';

    const LQ = '<';

    const RQ = '>';

    const ELQ = '<=';

    const ERQ = '>=';

    const BETWEEN = 'between';

    const NOT_BETWEEN= 'not_between';


    /**
     * @var string[] 支持的运算符
     */
    public static $operator = [
        self::LIKE,
        self::FULL_LIKE,
        self::IN,
        self::NOT_IN,
        self::EQ,
        self::NEQ,
        self::LQ,
        self::RQ,
        self::ELQ,
        self::ERQ,
        self::BETWEEN,
        self::NOT_BETWEEN
    ];

    /**
     * @var string[] 支持匹配
     */
    public static $like = [
        self::LIKE,
        self::FULL_LIKE,
    ];
}