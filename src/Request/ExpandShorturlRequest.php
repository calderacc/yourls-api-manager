<?php declare(strict_types=1);

namespace Caldera\YourlsApiManager\Request;

/**
 * Class ExpandShorturlRequest
 *
 * This action requires the plugin yourls-api-edit-url
 *
 * @see https://github.com/timcrockford/yourls-api-edit-url
 *
 * @package Caldera\YourlsApiManager\Request
 */
class ExpandShorturlRequest extends AbstractRequest
{
    public function __construct()
    {
        $this->requestData = array_merge($this->requestData, [
            'action' => 'expand',
            'format'  => 'json',
        ]);
    }

    public function setKeyword(string $keyword): ExpandShorturlRequest
    {
        $this->requestData['shorturl'] = $keyword;

        return $this;
    }
}