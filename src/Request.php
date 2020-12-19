<?php

namespace AdjvoAuthBouncer;

use GuzzleHttp\Client;

class Request
{
    /**
     * @var array
     */
    private $body;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $uri;

    /**
     * @param string $method
     * @param string $uri
     * @param array|null $body
     * @param array|null $headers
     * @return void
     */
    public function __construct(string $method, string $uri, ?array $body = null, ?array $headers = null)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->body = $body;
        $this->headers = $headers;
    }

    /**
     * @return Response
     */
    public function send(): Response
    {
        $response = (new Client())->request(
            $this->method,
            $this->uri,
            $this->makeContent()
        );

        return new Response($response);
    }

    /**
     * @return array
     */
    private function makeContent(): array
    {
        return [
            'headers' => $this->headers,
            'body'    => json_encode($this->body),
        ];
    }
}
