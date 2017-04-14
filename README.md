# Kumulos PHP API Package

Simplified class based package for the Kumulos API.

## Usage

Create a Kumulos object and then simply call the method on the object itself.

```php
<?php

use TiMacDonald\Kumulos\Kumulos;

...

$kumulos = new Kumulos($key, $secret);

$userId = $kumulos->createUser([
    'name' => 'Tim MacDonald',
    'twitter' => '@timacdonald87',
    'github' => 'timacdonald'
]);

...

```