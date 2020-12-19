<?php

require __DIR__.'/../vendor/autoload.php';

use AdjvoAuthBouncer\AdjvoAuthBouncerException;
use AdjvoAuthBouncer\Bouncer;

$clientId = 'xxx1234';
$clientSecret = 'xxx1234';
$domain = 'http://authdomain.marc.com';

$bouncer = new Bouncer($domain, $clientId, $clientSecret);

$token = 'xxx.yyy.zzz';

try
{
    $response = $bouncer->introspect($token);

    var_dump(
        $response->getData(),
        $response->getHttpStatusCode(),
        $response->getEndpoint(),
        $response->getMethod(),
        $response->getSuccess()
    );
}
catch (AdjvoAuthBouncerException $exception)
{
    $message = $exception->getMessage();

    echo $message;
}


