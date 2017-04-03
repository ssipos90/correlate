<?php

namespace Ssipos\Correlate;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->middleware([
            Correlate::class,
        ]);
    }
}

