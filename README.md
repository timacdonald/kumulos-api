# Kumulos PHP API SDK Package

This package is a modern PHP SDK for the [Kumulos API](https://docs.kumulos.com/build/api/).

## Installation

You can install using [composer](https://getcomposer.org/) from [Packagist](https://packagist.org/packages/timacdonald/kumulos).

```
composer require timacdonald/kumulos
```

Althought it is not recommended, because this package does not contain any dependencies, you can simply download and include the files in your project.

## Usage

Create a Kumulos API object and then simply call the methods you've created in your API on the API object.

```php
<?php

use TiMacDonald\Kumulos\Api;

...

/**
 * Create our api object instance.
 */
$api = new Api($key, $secret);

/**
 * Call an API method on the object, passing in an associative array of values.
 */
$api->createUser([
    'name' => 'Tim MacDonald',
    'twitter' => '@timacdonald87',
    'github' => 'timacdonald',
    'website' => 'timacdonald.me'
]);

/**
 * Check if it failed.
 */
if ($api->failed()) {
    // deal with failure, perhaps with an exception
    throw new Exception($api->message(), $api->statusCode());
}

/**
 * Retrieve the response payload.
 */
$userId = $api->response()->payload();

```

### Normalized Status Codes

Kumulos responds with custom status codes, but if you would like to normalize these status codes to the [standard HTTP response codes](http://bit.ly/2ovBMPg), you can simply call the following methods:

```php
<?php

// Check if it failed
if ($api->failed()) {
    // deal with failure, perhaps with an exception
    throw new Exception($api->normalizedMessage(), $api->normalizedStatusCode());
}

```

## License

This package is under the MIT License. See [LICENSE](https://github.com/timacdonald/kumulos-api/blob/master/License.txt) file for details.