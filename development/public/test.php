<?php

use Symfony\Component\Dotenv\Dotenv;

ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__.'/../vendor/autoload.php';

$dotEnv = new Dotenv();
$dotEnv->load(__DIR__.'/../.env');
$dotEnv->populate(['APP_ENV' => 'test', 'APP_DEBUG' => true]);

require __DIR__.'/index.php';
