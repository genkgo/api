PHP Genkgo v2 API Connector
============================================

[![Build Status](https://travis-ci.org/genkgo/api.png?branch=master)](https://travis-ci.org/genkgo/api)

## Usage

Add `genkgo/api` and implementations of `psr/http-client` and `psr/http-factory` to your dependencies and install them. 
You can have a look at [one of the examples](examples) or see the [docs](docs/index.md). The examples rely on 
[Guzzle](https://github.com/guzzle/guzzle) and [Guzzle PSR-7](https://github.com/guzzle/psr7) for the http implementations.

```php
<?php
require_once '../vendor/autoload.php';

use Genkgo\Api\Connection;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;

$config = require_once 'config.php';
$connection = new Connection(new Client(), new HttpFactory(), $config['url'], $config['token']);

$folder = $connection->command('organization', 'find', [
    'name' => 'Aanmeldingen'
]);
```

## Info

* [https://www.genkgo.com/](https://www.genkgo.com/)
