<?php declare(strict_types=1);

namespace Caldera\YourlsApiManager\Request;

abstract class AbstractRequest implements RequestInterface
{
    protected $requestData = [];

    public function __toString(): string
    {
        return http_build_query($this->requestData);
    }

    public function __toArray(): array
    {
        return $this->requestData;
    }
}