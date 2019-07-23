<?php declare(strict_types=1);

namespace Caldera\YourlsApiManager;

use Caldera\YourlsApiManager\Http\Http;

class YourlsApiManager
{
    /** @var Http $http */
    protected $http;

    public function __construct(Http $http)
    {
        $this->http = $http;
    }

    public function createShorturl(string $url, string $title): ?string
    {
        $request = new Request\CreateShorturlRequest();

        $request
            ->setUrl($url)
            ->setTitle($title);

        $response = $this->http->post($request);

        return $response->getShorturl();
    }

    public function getShorturl(string $keyword): ?string
    {
        $request = new Request\ExpandShorturlRequest();

        $request->setKeyword($keyword);

        $response = $this->http->postRequest($request);

        return $response->getLongurl();
    }

    public function deleteShorturl(string $keyword): bool
    {
        $request = new Request\DeleteShorturlRequest();

        $request->setKeyword($keyword);

        $response = $this->http->post($request);

        return $response->isSuccess();
    }

    public function updateShorturl(string $keyword, string $url, string $title = null): bool
    {
        $request = new Request\UpdateShorturlRequest();

        $request
            ->setKeyword($keyword)
            ->setUrl($url);

        if ($title) {
            $request->setTitle($title);
        }

        $response = $this->http->post($request);

        return $response->isSuccess();
    }
}
