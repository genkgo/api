<?php
require_once __DIR__ . '/vendor/autoload.php';

use Genkgo\Api\Connection;
use GuzzleHttp\Client;

$config = require_once 'config.php';
$connection = new Connection(new Client(), $config['url'], $config['token']);

$site = 'example.com';
//$site = 'skits.nl';

//Retrieve photo album information
$args = array(
	'entryToken' => $config['token'],
	'part' => 'site',
	'command' => 'model',
	'model' => 'photoalbum',
	'action' => 'albums',
	'site' => $site,
	'limit' => 20,
	'offset' => 0
);
$result = $connection->command('Website', 'Photoalbum', $args)->getBody();
var_dump($result);

//Retrieve pictures from given album
$args = array(
	'entryToken' => $config['token'],
	'part' => 'site',
	'command' => 'model',
	'model' => 'photoalbum',
	'action' => 'pictures',
	'site' => $site,
	'albumId' => 2,
	'limit' => 100,
	'offset' => 0
);
$result = $connection->command('Website', 'Photoalbum', $args)->getBody();
var_dump($result);

//Retrieve certain picture
$args = array(
	'entryToken' => $config['token'],
	'part' => 'site',
	'command' => 'model',
	'model' => 'photoalbum',
	'action' => 'picture',
	'site' => $site,
	'albumId' => 2,
	'photoName' => '000dsc_0264.jpg'
);
$result = $connection->command('Website', 'Photoalbum', $args);
var_dump($result);

/*
Actually, I don't receive any picture information in this last example.
The parameters seems to be OK. Does anyone know what goes wrong?

$result->getBody() seems empty, I tried some other methods, but none of them seems to work.
*/
