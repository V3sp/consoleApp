<?php

//var_dump($argv);
require_once __DIR__ . '/vendor/autoload.php';

use App\Services\Console;

$console = new Console($argv);
$console->verify_services()->prepare_args();
$output = $console->makeRequest();

if ($console->is_sha1($output)) {
    echo $output;
    echo " \r\n";
} else {
    $message = json_decode($output);
    echo 'ups something goes wrong.';
    echo " \r\n";
    echo $message->message;
    echo " \r\n";
}
