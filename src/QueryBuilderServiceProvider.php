<?php


namespace zyimm\query;


use Illuminate\Support\ServiceProvider;
use zyimm\query\build\QueryWhere;

class QueryBuilderServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //...
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //bind QueryWhere
        $this->app->bind('QueryWhere', QueryWhere::class);
    }

}
