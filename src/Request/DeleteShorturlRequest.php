<?php

namespace Caldera\YourlsApiManager\Request;

/**
 * Class DeleteShorturlRequest
 *
 * This action requires the plugin yourls-api-delete
 *
 * @see https://github.com/claytondaley/yourls-api-delete
 *
 * @package Caldera\YourlsApiManager\Request
 */
class DeleteShorturlRequest extends AbstractRequest
{
    public function __construct(string $username, string $password)
    {
        parent::__construct($username, $password);

        $this->requestData = array_merge($this->requestData, [
            'action' => 'delete',
            'format'  => 'json',
        ]);
    }

    public function setKeyword(string $keyword): DeleteShorturlRequest
    {
        $this->requestData['shorturl'] = $keyword;

        return $this;
    }
}
