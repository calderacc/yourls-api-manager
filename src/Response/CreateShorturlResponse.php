<?php declare(strict_types=1);

namespace Caldera\YourlsApiManager\Response;

class CreateShorturlResponse extends AbstractResponse
{
    public function getShorturl(): ?string
    {
        return $this->responseData['shorturl'];
    }

    public function getTitle(): ?string
    {
        return $this->responseData['title'];
    }

    public function getKeyword(): ?string
    {
        return $this->responseData['url']->keyword;
    }
}