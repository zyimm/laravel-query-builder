## laravel-query-builder

> laravel-query-builder 是laravel框架根据已有配置来执行查询条件构造器服务包|Query condition builder service package of laravel framework

## Install
```
composer require zyimm/laravelquery-builder

```

## Require
```javascript
    {
      "require": {
          "php": ">=7.0",
          "fideloper/proxy": "^4.0",
          "laravel/framework": ">=5.5"
        }  
    }   
```
## Usage
```php
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
```
生成SQL查询记录如下截图:
![生成SQL查询记录](http://115.159.5.87/images/laravel-query-builder.jpg)
提示:  
'in','not_in','between','not_between'标识符支持数组和字符串,字符串可选 ','和'.'作为分隔符。

## issue

能力有限！欢迎提出issue,共同学习进步。
