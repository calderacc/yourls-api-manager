<?php

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
}