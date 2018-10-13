<?php

use Symfony\Component\Dotenv\Dotenv;

ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__.'/../../vendor/autoload.php';

$dotEnv = new DotEnv();
$dotEnv->load(__DIR__.'/../../.env');
$dotEnv->populate(['APP_ENV' => 'test', 'APP_DEBUG' => true]);

passthru('bin/console doctrine:database:create --if-not-exists --env=test -n -q');
passthru('bin/console doctrine:migrations:migrate -n --env=test -q');
