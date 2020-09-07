<?php

namespace AnimeCon\Api\Client\Test;

use AnimeCon\Api\Client\AnimeConClient;
use AnimeCon\Api\Client\Builder\ClientBuilder;
use AnimeCon\Api\Client\Context\AuthenticationContext;
use PHPUnit\Framework\TestCase;

class AnimeConClientTest extends TestCase
{
    private AnimeConClient $client;

    public function testGetEvents()
    {
        $events = $this->client->getEvents();
        self::assertIsArray($events);
    }

    public function testGetEventsForYear()
    {
        $events = $this->client->getEventsForYear(2017);
        self::assertIsArray($events);
    }

    public function setUp(): void
    {
        $authenticationContext = new AuthenticationContext(
            $_ENV['AUTH_URI'],
            $_ENV['CLIENT_ID'],
            $_ENV['CLIENT_SECRET'],
            $_ENV['USERNAME'],
            $_ENV['PASSWORD']
        );
        $authenticationContext = $authenticationContext->withScopes(['event']);
        $this->client = ClientBuilder::build($_ENV['API_URI'], $authenticationContext);
    }
}
