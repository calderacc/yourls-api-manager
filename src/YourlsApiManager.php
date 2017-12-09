<?php

namespace Caldera\YourlsApiManager;

use Caldera\YourlsApiManager\Request\CreateShorturlRequest;
use Caldera\YourlsApiManager\Request\DeleteShorturlRequest;
use Caldera\YourlsApiManager\Request\ExpandShorturlRequest;
use Caldera\YourlsApiManager\Request\UpdateShorturlRequest;
use Caldera\YourlsApiManager\Response\CreateShorturlResponse;
use Caldera\YourlsApiManager\Response\DeleteShorturlResponse;
use Caldera\YourlsApiManager\Response\ExpandShorturlResponse;
use Caldera\YourlsApiManager\Response\UpdateShorturlResponse;

class YourlsApiManager extends AbstractYourlsApiManager
{
    public function createShorturl(string $url, string $title): ?string
    {
        /** @var CreateShorturlRequest $request */
        $request = $this->createRequest(CreateShorturlRequest::class);

        $request
            ->setUrl($url)
            ->setTitle($title)
        ;

        /** @var CreateShorturlResponse $response */
        $response = $this->postRequest($request);

        return $response->getKeyword();
    }

    public function getShorturl(string $keyword): ?string
    {
        /** @var ExpandShorturlRequest $request */
        $request = $this->createRequest(ExpandShorturlRequest::class);

        $request->setKeyword($keyword);

        /** @var ExpandShorturlResponse $response */
        $response = $this->postRequest($request);

        return $response->getLongurl();
    }

    public function deleteShorturl(string $keyword): bool
    {
        /** @var DeleteShorturlRequest $request */
        $request = $this->createRequest(DeleteShorturlRequest::class);

        $request->setKeyword($keyword);

        /** @var DeleteShorturlResponse $response */
        $response = $this->postRequest($request);

        return $response->isSuccess();
    }

    public function updateShorturl(string $keyword, string $url, string $title = null): bool
    {
        /** @var UpdateShorturlRequest $request */
        $request = $this->createRequest(UpdateShorturlRequest::class);

        $request
            ->setKeyword($keyword)
            ->setUrl($url)
        ;

        if ($title) {
            $request->setTitle($title);
        }

        /** @var UpdateShorturlResponse $response */
        $response = $this->postRequest($request);

        return $response->isSuccess();
    }
}
