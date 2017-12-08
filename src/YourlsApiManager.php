<?php

namespace Caldera\YourlsApiManager;

use Caldera\YourlsApiManager\Request\CreateShorturlRequest;
use Caldera\YourlsApiManager\Request\DeleteShorturlRequest;
use Caldera\YourlsApiManager\Request\ExpandShorturlRequest;
use Caldera\YourlsApiManager\Request\RequestInterface;
use Caldera\YourlsApiManager\Request\UpdateShorturlRequest;
use Caldera\YourlsApiManager\Response\CreateShorturlResponse;
use Caldera\YourlsApiManager\Response\DeleteShorturlResponse;
use Caldera\YourlsApiManager\Response\ExpandShorturlResponse;
use Caldera\YourlsApiManager\Response\ResponseInterface;
use Caldera\YourlsApiManager\Response\UpdateShorturlResponse;
use Curl\Curl;

class YourlsApiManager
{
    /** @var string $apiUrl */
    protected $apiUrl;

    /** @var string $apiUsername */
    protected $apiUsername;

    /** @var string $apiPassword */
    protected $apiPassword;

    public function __construct(string $apiUrl, string $apiUsername, string $apiPassword)
    {
        $this->apiUrl = $apiUrl;
        $this->apiUsername = $apiUsername;
        $this->apiPassword = $apiPassword;
    }

    public function createShorturl(string $url, string $title): ?string
    {
        /** @var CreateShorturlRequest $request */
        $request = $this->createRequest(CreateShorturlRequest::class);

        $request
            ->setUrl($url)
            ->setTitle($title)
        ;

        /** @var CreateShorturlResponse $response */
        $response = $this->post($request);

        return $response->getKeyword();
    }

    public function getShorturl(string $keyword): ?string
    {
        /** @var ExpandShorturlRequest $request */
        $request = $this->createRequest(ExpandShorturlRequest::class);

        $request->setKeyword($keyword);

        /** @var ExpandShorturlResponse $response */
        $response = $this->post($request);

        return $response->getLongurl();
    }

    public function deleteShorturl(string $keyword): bool
    {
        /** @var DeleteShorturlRequest $request */
        $request = $this->createRequest(DeleteShorturlRequest::class);

        $request->setKeyword($keyword);

        /** @var DeleteShorturlResponse $response */
        $response = $this->post($request);

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
        $response = $this->post($request);

        return $response->isSuccess();
    }

    protected function post(RequestInterface $request): ResponseInterface
    {
        $curl = new Curl();
        $curl->post(
            $this->apiUrl,
            $request->__toArray()
        );
        
        return $this->createResponse($curl->response, get_class($request));
    }

    protected function createRequest(string $requestClassname): RequestInterface
    {
        return new $requestClassname($this->apiUsername, $this->apiPassword);
    }

    protected function createResponse(\stdClass $responseData, string $requestClassname): ResponseInterface
    {
        $responseClassname = str_replace('Request', 'Response', $requestClassname);

        $response = new $responseClassname($responseData);

        return $response;
    }
}
