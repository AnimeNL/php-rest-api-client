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
        $response = $this->guzzle->get('activities.json');

        return json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }

    public function getEventsForYear(string $year, array $filters = []): array
    {
        $filters = array_merge([
            ['year' => $year],
            $filters
        ]);

        $response = $this->guzzle->get('activities.json', ['query' => $filters]);

        return json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }

    public function getTimeslots(array $filters): array
    {
        $response = $this->guzzle->get('timeslots.json', ['query' => $filters]);

        return json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }

    public function getActivityTypes(): array
    {
        $response = $this->guzzle->get('activity-types.json');

        return json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }

    public function getFloors(): array
    {
        $response = $this->guzzle->get('floors.json');

        return json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }
}
