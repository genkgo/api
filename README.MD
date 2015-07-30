PHP package to connect to the Genkgo v1 API
============================================

[![Build Status](https://travis-ci.org/genkgo/api.png?branch=master)](https://travis-ci.org/genkgo/api)

## Usage

Add genkgo/api to your dependencies and install them. You can have a look at [one of the
examples](examples) or see the [docs](docs/index.md).

```php
<?php
require_once '../vendor/autoload.php';

use Genkgo\Api\Connection;
use GuzzleHttp\Client;

$config = require_once 'config.php';
$connection = new Connection(new Client(), $config['url'], $config['token']);

$folder = $connection->command('organization', 'find', [
    'name' => 'Aanmeldingen'
]);
```

## Info

* [https://www.genkgo.com/](https://www.genkgo.com/)
