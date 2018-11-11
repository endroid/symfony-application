<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

use App\Kernel;

require __DIR__.'/../vendor/autoload.php';

Kernel::bootstrapEnv('test');

require __DIR__.'/index.php';
