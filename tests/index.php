<?php
require '../vendor/autoload.php';

/**
1.目前支持条件操作符
    '=',
    '<>',
    '>',
    '>=',
    '<',
    '<=',
    'like',
    'full_like',
    'in',
    'not_in',
    'between',
    'not_between'
**/
use Illuminate\Support\Facades\DB;
use zyimm\query\build\QueryWhere;
/**
 * @var QueryWhere $build
 */
$build = app('QueryWhere');

//提交过来数据
$data = [
    'log_id' => 20,
    'user_id'=> 'zyimm',
    'user_name' => "zyimm,12"
];

//配置数据库字段查询操作
$condition =[
    '=' => [
        'log_id'
    ],
    'not_in' => [
        'user_id'
    ],
    'between' => [
        'user_name'
    ],
    'full_like' => [
        'user_id'
    ],
    '<>' => [
        'user_id'
    ],
    '>' => [
        'user_id'
    ]
];
DB::enableQueryLog();
//model
\App\Models\Log::query()
    ->where(function ($query) use ($build, $data, $condition){
        $build->buildQueryWhere($data ,$condition, $query);
    })->get();
dd(DB::getQueryLog());
