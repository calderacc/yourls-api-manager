<?php declare(strict_types=1);

namespace Caldera\YourlsApiManager\Response;

class AbstractResponse implements ResponseInterface
{
    protected $responseData = [];

    public function __construct(\stdClass $responseData)
    {
        $this->responseData = (array) $responseData;
    }

    public function isSuccess(): bool
    {
        return $this->getStatusCode() === 200;
    }

    public function getStatus(): ?string
    {
        return $this->responseData['status'];
    }

    public function getStatusCode(): int
    {
        return $this->responseData['statusCode'];
    }

    public function getMessage(): string
    {
        return $this->responseData['message'];
    }
}
