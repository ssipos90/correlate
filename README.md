[![Build Status](https://travis-ci.org/ssipos90/correlate.svg?branch=master)](https://travis-ci.org/ssipos90/correlate)

## Installation

Via composer package management:
```bash
$ composer require ssipos90/correlate
```

## Usage

Not tested on Laravel, only Lumen.

Either 

* register the service provider:
    * Laravel: register the provider in your `config/app.php` file:
    ```php
     Ssipos\Correlate\CorrelateServiceProvider::class,
    ```
    * Lumen: add this in your `bootstrap/app.php` file: 
    ```php
    $app->register(Ssipos\Correlate\CorrelateServiceProvider::class);
    ```
* add the middleware to whatever routes you want or globally:
    * Laravel: add the middleware in your `app/Http/Kernel.php` file; 
    * Lumen: add the middleware in your `bootstrap/app.php` file.
    ```php
    Ssipos\Correlate\Correlate::class
    ```
## TODO

* Add guzzle support for adding the header on forwarding requests
