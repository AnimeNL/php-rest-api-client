<?php

namespace AnimeCon\Api\Client\Provider;

use AnimeCon\Api\Client\Context\AuthenticationContext;
use GuzzleHttp\Client;
use Psr\Cache\CacheItemPoolInterface;

class TokenProvider
{
    private const ACCESS_TOKEN = 'access_token';
    private Client $client;
    private CacheItemPoolInterface $cache;
    private AuthenticationContext $authenticationContext;

    public function __construct(
        Client $client,
        CacheItemPoolInterface $cache,
        AuthenticationContext $authenticationContext
    ) {
        $this->client = $client;
        $this->cache = $cache;
        $this->authenticationContext = $authenticationContext;
    }

    public function getToken(): string
    {
        $item = $this->cache->getItem(self::ACCESS_TOKEN);
        if ($item->isHit()) {
            return $item->get();
        }

        return $this->initTokens();
    }

    private function initTokens(): string
    {
        $params = $this->authenticationContext->getParams();
        $response = $this->client->post(
            $this->authenticationContext->getUri(),
            [
                'form_params' => $params,
                'headers'     => ['Accept' => '*/*'],
            ]
        );

        $tokens = json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        // Store access token
        $accessTokenCacheItem = $this->cache->getItem(self::ACCESS_TOKEN);
        $accessTokenCacheItem->set($tokens[self::ACCESS_TOKEN]);
        $accessTokenCacheItem->expiresAfter($tokens['expires_in'] - 1);
        $this->cache->save($accessTokenCacheItem);

        return $accessTokenCacheItem->get();
    }
}
