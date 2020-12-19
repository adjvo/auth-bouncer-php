<?php

namespace AdjvoAuthBouncer\Test\Unit;

use AdjvoAuthBouncer\Bouncer;

class BouncerTest extends TestCase
{
    /**
     * @test
     */
    public function it_configure_credentials(): void
    {
        $domain = 'http://local.auth.api.marc.com';
        $clientId = 'johndoe';
        $secret = 'secret';

        $bouncer = new Bouncer($domain, $clientId, $secret);

        $this->assertObjectProperty($bouncer, 'domain', 'http://local.auth.api.marc.com');
        $this->assertObjectProperty($bouncer, 'clientId', 'johndoe');
        $this->assertObjectProperty($bouncer, 'secret', 'secret');
    }

    /**
     * @test
     */
    public function it_configure_headers(): void
    {
        $domain = 'http://local.auth.api.marc.com';
        $clientId = 'johndoe';
        $secret = 'secret';

        $bouncer = new Bouncer($domain, $clientId, $secret);

        $this->assertObjectProperty($bouncer,
            'headers',
            [
                'Authorization' => 'Bearer ',
                'Content-Type'  => 'application/json',
            ]
        );

        $this->assertObjectPropertySize($bouncer, 'headers', 2);
    }
}
