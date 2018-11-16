<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

putenv('APP_ENV='.$_SERVER['APP_ENV'] = $_ENV['APP_ENV'] = 'test');

require __DIR__.'/index.php';
