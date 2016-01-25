<?php
require_once '../vendor/autoload.php';

use Genkgo\Api\Connection;
use GuzzleHttp\Client;

$config = require_once 'config.php';
$connection = new Connection(new Client(), $config['url'], $config['token']);

$folder = $connection->command('organization', 'find', [
    'name' => 'Aanmeldingen'
])->getBody();

$newEntry = $connection->command('organization', 'create', [
    'id' => $folder->id,
    'name' => 'Weergave Naam',
    'objectclass' => 'associationMember'
])->getBody();

$result = $connection->command('organization', 'modify', [
    'id' => $newEntry->id,
    'properties' => [
        'givenname' => 'Voornaam',
        'middlename' => 'Tussenvoegsel',
        'surname' => 'Achternaam',
        'gender' => 'male',
        'birthdate' => '2000-01-01',
        'initials' => 'V.',
        'title_pre' => 'drs.',
        'title_post' => 'MSc',
        'mail' => 'test@genkgo.nl',
        'secondarymail' => 'test@genkgo.nl',
        'telephonenumber' => '+31 6 1000 1000',
        'homephone' => '+31 6 1000 1000',
        'mobile' => '+31 6 1000 1000',
        'url' => 'https://www.genkgo.com',
        'htmlmail' => true,
        'smsmail' => true,
        'street' => 'Straat',
        'postalcode' => '1000AA',
        'city' => 'Amsterdam',
        'country' => 'Nederland',
        'state' => 'Noord-Holland',
        'billingaccount' => 'NL91ABNA0417164300',
    ]
]);

var_dump($result);exit;
