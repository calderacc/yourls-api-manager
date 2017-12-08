<?php

namespace Caldera\YourlsApiManager\Request;

class CreateShorturlRequest extends AbstractRequest
{
    public function __construct(string $username, string $password)
    {
        parent::__construct($username, $password);

        $this->requestData = array_merge($this->requestData, [
            'action' => 'shorturl',
            'format'  => 'json',
        ]);
    }

    public function setUrl(string $url): CreateShorturlRequest
    {
        $this->requestData['url'] = $url;

        return $this;
    }

    public function setTitle(string $title): CreateShorturlRequest
    {
        $this->requestData['title'] = $title;

        return $this;
    }
}