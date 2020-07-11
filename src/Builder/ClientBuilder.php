<?php

namespace AnimeCon\Api\Client\Builder;

use AnimeCon\Api\Client\AnimeConClient;
use AnimeCon\Api\Client\Context\AuthenticationContext;
use AnimeCon\Api\Client\Handler\AuthHandler;
use AnimeCon\Api\Client\Provider\TokenProvider;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class ClientBuilder
{
    public static function build(
        string $baseUri,
        AuthenticationContext $authenticationContext,
        CacheItemPoolInterface $cache = null
    ): AnimeConClient {
        $cache ??= new FilesystemAdapter('animecon', 0, '/tmp');
        $authClient = new Client();
        $tokenProvider = new TokenProvider($authClient, $cache, $authenticationContext);
        $authHandler = new AuthHandler($tokenProvider);
        $stack = HandlerStack::create();
        $stack->push($authHandler->authenticate());
        $guzzle = new Client(['handler' => $stack, 'base_uri' => $baseUri]);

        return new AnimeConClient($guzzle);
    }
}
