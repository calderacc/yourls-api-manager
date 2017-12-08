<?php

namespace Caldera\YourlsApiManager\Request;

abstract class AbstractRequest implements RequestInterface
{
    protected $requestData = [];

    public function __construct(string $username, string $password)
    {
        $this->requestData = [
            'username' => $username,
            'password' => $password,
        ];
    }

    public function __toString(): string
    {
        return http_build_query($this->requestData);
    }

    public function __toArray(): array
    {
        return $this->requestData;
    }
}