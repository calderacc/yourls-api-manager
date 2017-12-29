<?php

namespace Caldera\YourlsApiManager;

use Caldera\YourlsApiManager\Request as Request;
use Caldera\YourlsApiManager\Response as Response;

class YourlsApiManager extends AbstractYourlsApiManager
{
    public function createShorturl(string $url, string $title): ?string
    {
        /** @var Request\CreateShorturlRequest $request */
        $request = $this->createRequest(Request\CreateShorturlRequest::class);

        $request
            ->setUrl($url)
            ->setTitle($title)
        ;

        /** @var Response\CreateShorturlResponse $response */
        $response = $this->postRequest($request);

        return $response->getShorturl();
    }

    public function getShorturl(string $keyword): ?string
    {
        /** @var Request\ExpandShorturlRequest $request */
        $request = $this->createRequest(Request\ExpandShorturlRequest::class);

        $request->setKeyword($keyword);

        /** @var Response\ExpandShorturlResponse $response */
        $response = $this->postRequest($request);

        return $response->getLongurl();
    }

    public function deleteShorturl(string $keyword): bool
    {
        /** @var Request\DeleteShorturlRequest $request */
        $request = $this->createRequest(Request\DeleteShorturlRequest::class);

        $request->setKeyword($keyword);

        /** @var Response\DeleteShorturlResponse $response */
        $response = $this->postRequest($request);

        return $response->isSuccess();
    }

    public function updateShorturl(string $keyword, string $url, string $title = null): bool
    {
        /** @var Request\UpdateShorturlRequest $request */
        $request = $this->createRequest(Request\UpdateShorturlRequest::class);

        $request
            ->setKeyword($keyword)
            ->setUrl($url)
        ;

        if ($title) {
            $request->setTitle($title);
        }

        /** @var Response\UpdateShorturlResponse $response */
        $response = $this->postRequest($request);

        return $response->isSuccess();
    }
}
