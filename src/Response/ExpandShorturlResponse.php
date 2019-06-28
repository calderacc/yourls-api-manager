<?php declare(strict_types=1);

namespace Caldera\YourlsApiManager\Response;

class ExpandShorturlResponse extends AbstractResponse
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
        return $this->responseData['keyword'];
    }

    public function getLongurl(): ?string
    {
        return $this->responseData['longurl'];
    }
}