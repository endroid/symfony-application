<?php

use Symfony\Component\Dotenv\Dotenv;

require __DIR__.'/../vendor/autoload.php';

$dotEnv = new DotEnv();
$dotEnv->load(__DIR__.'/../.env');
$dotEnv->populate(['APP_ENV' => 'test']);

require __DIR__.'/index.php';