<?php

namespace Caldera\YourlsApiManager\Request;

class UpdateShorturlRequest extends AbstractRequest
{
    public function __construct(string $username, string $password)
    {
        parent::__construct($username, $password);

        $this->requestData = array_merge($this->requestData, [
            'action' => 'update',
            'format'  => 'json',
        ]);
    }

    public function setUrl(string $url): UpdateShorturlRequest
    {
        $this->requestData['url'] = $url;

        return $this;
    }

    public function setTitle(string $title): UpdateShorturlRequest
    {
        $this->requestData['title'] = $title;

        return $this;
    }

    public function setKeyword(string $keyword): UpdateShorturlRequest
    {
        $this->requestData['shorturl'] = $keyword;

        return $this;
    }
}