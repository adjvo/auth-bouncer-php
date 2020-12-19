<?php

namespace AdjvoAuthBouncer\Test\Unit;

use AdjvoAuthBouncer\Request;

class RequestTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_request(): void
    {
        $request = new Request('POST', 'http://local.auth.api.marc.com');

        $this->assertObjectProperty($request, 'method', 'POST');
        $this->assertObjectProperty($request, 'uri', 'http://local.auth.api.marc.com');
    }

    /**
     * @test
     */
    public function it_creates_request_with_body(): void
    {
        $request = new Request('POST', 'http://local.auth.api.marc.com', [
            'name' => 'John',
        ]);

        $this->assertObjectProperty($request, 'method', 'POST');
        $this->assertObjectProperty($request, 'uri', 'http://local.auth.api.marc.com');
        $this->assertObjectProperty($request,
            'body',
            [
                'name' => 'John',
            ]);
    }

    /**
     * @test
     */
    public function it_creates_request_with_content(): void
    {
        $body = [
            'name' => 'John',
        ];

        $headers = [
            'Authorization' => 'Basic '.base64_encode('johndoe:secret'),
            'User-Agent'    => 'Whatever',
        ];

        $request = new Request('POST', 'http://local.auth.api.marc.com', $body, $headers);

        $this->assertObjectProperty($request, 'method', 'POST');
        $this->assertObjectProperty($request, 'uri', 'http://local.auth.api.marc.com');
        $this->assertObjectProperty($request, 'body', $body);
        $this->assertObjectProperty($request, 'headers', $headers);

        $this->assertObjectMethod($request,
            'makeContent',
            [
                'headers' => $headers,
                'body'    => json_encode($body),
            ]);
    }

    /**
     * @test
     */
    public function it_creates_request_with_headers(): void
    {
        $request = new Request('POST', 'http://local.auth.api.marc.com', null, [
            'Authorization' => 'Basic '.base64_encode('johndoe:secret'),
            'User-Agent'    => 'Whatever',
        ]);

        $this->assertObjectProperty($request, 'method', 'POST');
        $this->assertObjectProperty($request, 'uri', 'http://local.auth.api.marc.com');
        $this->assertObjectProperty($request,
            'headers',
            [
                'Authorization' => 'Basic '.base64_encode('johndoe:secret'),
                'User-Agent'    => 'Whatever',
            ]);
    }
}
