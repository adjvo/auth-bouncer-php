<?php

namespace AdjvoAuthBouncer;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

class Response
{
    /**
     * @var array
     */
    private $response;

    /**
     * @param $response
     */
    public function __construct(GuzzleResponse $response)
    {
        $this->response = json_decode($response->getBody(), true);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->response['data'];
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->response['endpoint'];
    }

    /**
     * @return string
     */
    public function getHttpStatusCode(): string
    {
        return $this->response['http_status_code'];
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->response['method'];
    }

    /**
     * @return bool
     */
    public function getSuccess(): bool
    {
        return $this->response['success'];
    }
}
