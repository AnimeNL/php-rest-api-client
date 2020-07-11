<?php

namespace AnimeCon\Api\Client;

use GuzzleHttp\Client;

class AnimeConClient
{
    private Client $guzzle;

    public function __construct(Client $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public function getEvents(): array
    {
        $response = $this->guzzle->get('/activities.json');

        return json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }
}
