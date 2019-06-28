<?php declare(strict_types=1);

namespace Tests\Factory;

use Caldera\YourlsApiManager\Factory\RequestDataFactory;
use Caldera\YourlsApiManager\Http\Http;
use Caldera\YourlsApiManager\Request\CreateShorturlRequest;
use Caldera\YourlsApiManager\Request\DeleteShorturlRequest;
use Caldera\YourlsApiManager\Request\ExpandShorturlRequest;
use Caldera\YourlsApiManager\Request\UpdateShorturlRequest;
use PHPUnit\Framework\TestCase;

class RequestDataFactoryTest extends TestCase
{
    public function testEmptyRequestData(): void
    {
        $http = $this->createMock(Http::class);

        $this->assertEquals([
            'action' => 'shorturl',
            'format' => 'json',
        ], RequestDataFactory::createRequestData(new CreateShorturlRequest(), $http));

        $this->assertEquals([
            'action' => 'delete',
            'format' => 'json',
        ], RequestDataFactory::createRequestData(new DeleteShorturlRequest(), $http));

        $this->assertEquals([
            'action' => 'expand',
            'format' => 'json',
        ], RequestDataFactory::createRequestData(new ExpandShorturlRequest(), $http));

        $this->assertEquals([
            'action' => 'update',
            'format' => 'json',
        ], RequestDataFactory::createRequestData(new UpdateShorturlRequest(), $http));
    }
}