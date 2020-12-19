<?php

namespace AdjvoAuthBouncer\Test\Unit;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use AdjvoAuthBouncer\Response;

class ResponseTest extends TestCase
{
    /**
     * @test
     */
    public function it_gets_response()
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];

        $body = [
            'data'             => [
                'active'    => true,
                'client_id' => 'GjVTMaxAvAypwoe6Y0LpqfXa1N8cn7Lwn6jGqw3bAGzD0FFwUxS4i5ilqjRx',
                'username'  => 'user1@example.com',
                'scope'     => ['user'],
                'exp'       => 1568793168,
                'iat'       => 1568793108,
                'jti'       => '53974272c77a4f678368a3081c97014979859e480ccea97f4a486df7e9551597288dafa7db1514db',
            ],
            'endpoint'         => '/token/introspect',
            'http_status_code' => 20,
            'method'           => 'POST',
            'success'          => true,
        ];

        $guzzleResponse = new GuzzleResponse(200, $headers, json_encode($body));

        $response = new Response($guzzleResponse);

        $data = $response->getData();
        $endpoint = $response->getEndpoint();
        $httpStatusCode = $response->getHttpStatusCode();
        $method = $response->getMethod();
        $success = $response->getSuccess();

        $this->assertEquals($data, $body['data']);
        $this->assertEquals($endpoint, $body['endpoint']);
        $this->assertEquals($httpStatusCode, $body['http_status_code']);
        $this->assertEquals($method, $body['method']);
        $this->assertEquals($success, $body['success']);
    }
}
