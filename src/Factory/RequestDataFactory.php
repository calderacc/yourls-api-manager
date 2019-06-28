<?php declare(strict_types=1);

namespace Caldera\YourlsApiManager\Factory;

use Caldera\YourlsApiManager\Http\Http;
use Caldera\YourlsApiManager\Request\RequestInterface;

class RequestDataFactory
{
    private function __construct()
    {

    }

    public static function createRequestData(RequestInterface $request, Http $http): array
    {
        $requestData = $request->__toArray();

        $requestData = array_merge($requestData, $http->credentials());

        return $requestData;
    }
}
