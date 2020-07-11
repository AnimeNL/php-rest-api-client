<?php

namespace AnimeCon\Api\Client\Handler;

use AnimeCon\Api\Client\Provider\TokenProvider;
use Psr\Http\Message\RequestInterface;

class AuthHandler
{
    private TokenProvider $tokenProvider;

    public function __construct(TokenProvider $tokenProvider)
    {
        $this->tokenProvider = $tokenProvider;
    }

    public function authenticate(): callable
    {
        return function (callable $handler) {
            return function (
                RequestInterface $request,
                array $options
            ) use ($handler) {
                $request = $request
                    ->withHeader('Authorization', 'Bearer ' . $this->tokenProvider->getToken());

                return $handler($request, $options);
            };
        };
    }
}
