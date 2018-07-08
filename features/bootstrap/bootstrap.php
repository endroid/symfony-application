<?php

use Symfony\Component\Dotenv\Dotenv;

$dotEnv = new DotEnv();
$dotEnv->load(__DIR__.'/../../application/.env');
$dotEnv->populate(['APP_ENV' => 'test', 'APP_DEBUG' => true]);

passthru('bin/console cache:clear --env=test -q');
passthru('bin/console doctrine:database:create --if-not-exists --env=test -n -q');
passthru('bin/console doctrine:migrations:migrate --env=test -n -q');
