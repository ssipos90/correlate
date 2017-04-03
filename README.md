[![Build Status](https://travis-ci.org/ssipos90/correlate.svg?branch=master)](https://travis-ci.org/ssipos90/correlate)

## Usage

Either 

* register the service provider:
    * Laravel: register the provider in your `config/app.php` file:
    ```php
     Ssipos\Correlate\CorrelateServiceProvider::class,
    ```
    * Lumen: add this in your `bootstrap/app.php` file: 
    ```php
    $app->register(App\Providers\AppServiceProvider::class);
    ```
* add the middleware to whatever routes you want or globally:
    * Laravel: add the middleware in your `app/Http/Kernel.php` file; 
    * Lumen: add the middleware in your `bootstrap/app.php` file.
    ```php
    Ssipos\Correlate\Correlate::class
    ```
