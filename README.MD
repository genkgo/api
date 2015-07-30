PHP package to connect to the Genkgo v1 API
============================================

## Using

Add genkgo/api to your dependencies and install them.

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

* [https://github.com/genkgo/api-docs](https://github.com/genkgo/api-docs)
* [https://www.genkgo.com/](https://www.genkgo.com/)
