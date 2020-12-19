<?php

namespace AdjvoAuthBouncer;

use Exception;

class Bouncer
{
    private const UNAUTHORIZED = 401;

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $domain;

    /**
     * @var array
     */
    private $headers = [
        'Content-Type' => 'application/json',
    ];

    /**
     * @var string
     */
    private $secret;

    /**
     * @var string
     */
    private $tokenPath = __DIR__.'/../data/token';

    /**
     * @param string $domain
     * @param string $clientId
     * @param string $secret
     * @return void
     */
    public function __construct(string $domain, string $clientId, string $secret)
    {
        $this->domain = $domain;
        $this->clientId = $clientId;
        $this->secret = $secret;

        $token = $this->getCachedToken();

        $this->setAuthorizationHeader($token);
    }

    /**
     * @param string $token
     * @throws AdjvoAuthBouncerException
     * @return Response
     */
    public function introspect(string $token): Response
    {
        $body = [
            'token' => $token,
        ];

        $uri = $this->buildUri('token/introspect');

        $request = new Request('POST', $uri, $body, $this->headers);

        try
        {
            return $request->send();
        }
        catch (Exception $exception)
        {
            if ($exception->getCode() == self::UNAUTHORIZED)
            {
                $this->authenticate();

                return $this->introspect($token);
            }

            throw new AdjvoAuthBouncerException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @return void
     */
    private function authenticate(): void
    {
        $token = $this->issueAccessToken($this->clientId, $this->secret);

        $this->setAuthorizationHeader($token);
    }

    /**
     * @param string $uri
     * @return string
     */
    private function buildUri(string $uri): string
    {
        return $this->domain.'/'.$uri;
    }

    /**
     * @return string|null
     */
    private function getCachedToken(): ?string
    {
        if (! file_exists($this->tokenPath))
        {
            return null;
        }

        return file_get_contents($this->tokenPath);
    }

    /**
     * @param string $clientId
     * @param string $secret
     * @throws AdjvoAuthBouncerException
     * @return string
     */
    private function issueAccessToken(string $clientId, string $secret): string
    {
        $body = [
            'grant_type'    => 'client_credentials',
            'client_id'     => $clientId,
            'client_secret' => $secret,
        ];

        $uri = $this->buildUri('token');

        $request = new Request('POST', $uri, $body, $this->headers);

        try
        {
            $payload = $request->send();

            $data = $payload->getData();

            $this->storeTokenToCache($data['access_token']);

            return $data['access_token'];
        }
        catch (Exception $exception)
        {
            throw new AdjvoAuthBouncerException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @param string|null $token
     * @return void
     */
    private function setAuthorizationHeader(?string $token = null): void
    {
        $this->headers['Authorization'] = 'Bearer '.$token;
    }

    /**
     * @param string $token
     * @return void
     */
    private function storeTokenToCache(string $token): void
    {
        file_put_contents($this->tokenPath, $token);
    }
}
