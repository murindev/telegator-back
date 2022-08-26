<?php

namespace App\Services\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;

class HttpClient
{
    protected ?object $client = null;

    public function __constructor()
    {
        $this->initClient();
    }

    public function fetch(string $url)
    {
        $client   = $this->getClient();
        $response = $client->get($url);

        // todo check errors

        return $response->getStatusCode() == 200 ? $response->getBody()->getContents() : false;
    }

    private function getClient(): ?object
    {
        if (!$this->client) $this->initClient();
        return $this->client;
    }

    private function initClient()
    {
        $stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());
        $this->client = new Client(['handler' => $stack]);

        // todo add proxy lists
    }
}
