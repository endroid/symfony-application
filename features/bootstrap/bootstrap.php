<?php

use Symfony\Component\Dotenv\Dotenv;

// The check is to ensure we don't use .env in production
if (!isset($_SERVER['APP_ENV'])) {
    if (!class_exists(Dotenv::class)) {
        throw new \RuntimeException('APP_ENV environment variable is not defined. You need to define environment variables for configuration or add "symfony/dotenv" as a Composer dependency to load variables from a .env file.');
    }
    (new Dotenv())->load(__DIR__.'/../../application/.env.test');
}

passthru('php "'.__DIR__.'/../../application/bin/console" cache:clear --env=test --no-warmup -q');
passthru('php "'.__DIR__.'/../../application/bin/console" doctrine:database:create --env=test --if-not-exists -n -q');
passthru('php "'.__DIR__.'/../../application/bin/console" doctrine:schema:update --env=test --force -n -q');
passthru('php "'.__DIR__.'/../../application/bin/console" fos:elastica:populate --env=test -n -q');
