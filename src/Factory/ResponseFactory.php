<?php declare(strict_types=1);

namespace Caldera\YourlsApiManager\Factory;

use Caldera\YourlsApiManager\Response\ResponseInterface;

class ResponseFactory
{
    private function __construct()
    {

    }

    public static function createResponse(\stdClass $responseData, string $requestClassname): ResponseInterface
    {
        $responseClassname = str_replace('Request', 'Response', $requestClassname);

        $response = new $responseClassname($responseData);

        return $response;
    }
}