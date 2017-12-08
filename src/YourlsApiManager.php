<?php

namespace Caldera\YourlsApiManager;

use Caldera\YourlsApiManager\Request\CreateShorturlRequest;
use Caldera\YourlsApiManager\Request\RequestInterface;
use Caldera\YourlsApiManager\Request\UpdateShorturlRequest;
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

    public function createPermalink(string $url, string $title): ?string
    {
        /** @var CreateShorturlRequest $request */
        $request = $this->createRequest(CreateShorturlRequest::class);

        $request
            ->setUrl($url)
            ->setTitle($title)
        ;

        $response = $this->post($request);

        if (!isset($response->shorturl)) {
            return null;
        }

        $permalink = $response->shorturl;

        return $permalink;
    }

    public function getUrl(string $keyword): ?string
    {
        $data = [
            'shorturl' => $keyword,
            'format'   => 'json',
            'action'   => 'expand'
        ];

        $response = $this->postCurl($data);

        if (isset($response->errorCode) && $response->errorCode == 404) {
            return null;
        }

        $longUrl = $response->longurl;

        return $longUrl;
    }

    public function updatePermalink(string $keyword, string $url, string $title = null): bool
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
        
        $response = $this->post($request);

        if (isset($response->statusCode) && $response->statusCode == 200) {
            return true;
        }

        return false;
    }

    protected function post(RequestInterface $request): \stdClass
    {
        $curl = new Curl();
        $curl->post(
            $this->apiUrl,
            $request->__toArray()
        );

        var_dump($curl->response);
        if ($curl->response) {
            return $curl->response;
        }

        return null;
    }

    protected function createRequest(string $requestClassname): RequestInterface
    {
        return new $requestClassname($this->apiUsername, $this->apiPassword);
    }
}
