<?php
require_once '../vendor/autoload.php';

use Genkgo\Api\Connection;
use GuzzleHttp\Client;

$config = require_once 'config.php';
$connection = new Connection(new Client(), $config['url'], $config['token']);

$result = $connection->command('organization', 'login', [
    'uid' => 'test',
    'password' => 'test'
]);

var_dump($result);