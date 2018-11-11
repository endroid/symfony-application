<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

use App\Kernel;

Kernel::bootstrapEnv();

passthru('bin/console doctrine:database:create --if-not-exists -q');
passthru('bin/console doctrine:migrations:migrate -n -q');
