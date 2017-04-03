<?php

namespace Ssipos\Correlate;

use Illuminate\Support\ServiceProvider;

class CorrelateServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->middleware([
            Correlate::class,
        ]);
    }
}

