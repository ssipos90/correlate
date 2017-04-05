<?php

namespace Ssipos\Correlate;

use Illuminate\Support\ServiceProvider;

class CorrelateServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(\Monolog\Logger::class, function () {
            return $this->app->make('log');
        });
        $this->app->middleware([
            Correlate::class,
        ]);
    }
}

