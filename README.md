# Kumulos PHP API Package

Simplified class based package for the Kumulos API.

## Usage

Create a Kumulos object and then simply call the method on the object itself.

```php
<?php

$api = new TiMacDonald\Kumulos\Api($key, $secret);

$response = $api->createUser([
    'name' => 'Tim MacDonald',
    'twitter' => '@timacdonald87',
    'github' => 'timacdonald'
]);

if ($response->failed()) {
    // deal with failure
}

$userId = $response->payload();

```