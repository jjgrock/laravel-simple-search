<?php

namespace ZestyBus\LaravelSimpleSearch;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use ZestyBus\LaravelSimpleSearch\Search\Query;

class LaravelSimpleSearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'laravel-simple-search');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
              __DIR__ . '/../config/config.php' => config_path('laravel-simple-search.php'),
            ], 'config');
        }

        $this->bootMacro();
    }

    protected function bootMacro()
    {
        $name = config('laravel-simple-search.method');

        Builder::macro($name, function(string $string = '', $columns = null) {
            return (new Query($this))->where($string, $columns);
        });
    }
}
