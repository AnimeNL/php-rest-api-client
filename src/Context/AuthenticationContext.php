<?php

namespace AnimeCon\Api\Client\Context;

class AuthenticationContext
{
    private string $grantType = 'password';
    private string $clientId;
    private string $clientSecret;
    private string $username;
    private string $password;
    private string $uri;
    private array $scopes = [];

    public function __construct(
        string $uri,
        string $clientId,
        string $clientSecret,
        string $username,
        string $password
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->username = $username;
        $this->password = $password;
        $this->uri = $uri;
    }

    public function withScopes(array $scopes): self
    {
        $instance = clone $this;
        $instance->scopes = $scopes;

        return $instance;
    }

    public function setScopes(array $scopes): void
    {
        $this->scopes = $scopes;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getParams(): array
    {
        return [
            'grant_type'    => $this->grantType,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'username'      => $this->username,
            'password'      => $this->password,
            'scopes'        => implode(', ', $this->scopes),
        ];
    }
}
