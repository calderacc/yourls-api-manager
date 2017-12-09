<?php

namespace Caldera\YourlsApiManager;

use Caldera\YourlsApiManager\Request\RequestInterface;
use Caldera\YourlsApiManager\Response\ResponseInterface;
use Curl\Curl;

abstract class AbstractYourlsApiManager
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

    protected function postRequest(RequestInterface $request): ResponseInterface
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
