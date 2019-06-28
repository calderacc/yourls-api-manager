<?php declare(strict_types=1);

namespace Caldera\YourlsApiManager\Http;

use Caldera\YourlsApiManager\Factory\RequestDataFactory;
use Caldera\YourlsApiManager\Factory\ResponseFactory;
use Caldera\YourlsApiManager\Request\RequestInterface;
use Caldera\YourlsApiManager\Response\ResponseInterface;
use Curl\Curl;

class Http
{
    /** @var string $apiUrl */
    protected $apiUrl;

    /** @var string $apiUsername */
    protected $apiUsername;

    /** @var string $apiPassword */
    protected $apiPassword;

    /** @var Curl $curl */
    protected $curl;

    public function __construct(string $apiUrl, string $apiUsername, string $apiPassword)
    {
        $this->apiUrl = $apiUrl;
        $this->apiUsername = $apiUsername;
        $this->apiPassword = $apiPassword;

        $this->curl = new Curl();
    }

    public function setCurl(Curl $curl): Http
    {
        $this->curl = $curl;

        return $this;
    }

    public function credentials(): array
    {
        return [
            'username' => $this->apiUsername,
            'password' => $this->apiPassword,
        ];
    }

    public function post(RequestInterface $request): ResponseInterface
    {
        $curlResponse = $this->curl->post(
            $this->apiUrl,
            RequestDataFactory::createRequestData($request, $this)
        );

        $response = ResponseFactory::createResponse($curlResponse, get_class($request));

        return $response;
    }
}