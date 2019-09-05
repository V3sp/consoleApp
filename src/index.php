<?php

//var_dump($argv);
require_once __DIR__ . '/vendor/autoload.php';

use App\Services\Console;

$console = new Console($argv);
$output = $console->verify_services()->prepare_args()->makeRequest();
$console->makeOutput($output);

