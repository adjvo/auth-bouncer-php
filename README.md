# MarC Bouncer

`canfone/marc-bouncer` is a PHP client designed to be used when checking access token in the MarC Auth Server.


# Requirements

* PHP 7.1
* PHP 7.2
* PHP 7.3


# Installation

```bash
composer require canfone/marc-bouncer
```


# Documentation

To use the `bouncer`, you need to instantiate it with `domain`, `username` and `password` from the auth server.

```php
$bouncer = new Bouncer($domain, $clientId, $secret);

try
{
    $response = $bouncer->introspect($token);
    
    $response->getData();
    $response->getHttpStatusCode();
    $response->getEndpoint();
    $response->getMethod();
    $response->getSuccess();
}
catch (MarcBouncerException $exception)
{
    // do something if error occurs.
}
```

# Testing

The library uses [PHPUnit](https://phpunit.de/) for unit tests.

```bash
vendor/bin/phpunit tests
```

# License

This package is released under the MIT License. See the bundled LICENSE file for details.
