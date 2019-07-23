<?php declare(strict_types=1);

namespace Tests\YourlsApiManager;

use Caldera\YourlsApiManager\Http\Http;
use Caldera\YourlsApiManager\YourlsApiManager;
use Curl\Curl;
use PHPUnit\Framework\TestCase;

class ExpandShorturlTest extends TestCase
{
    public function testExpandShorturl(): void
    {
        $curlResponse = new \stdClass();
        $curlResponse->shorturl = 'foobarbaz';
        $curlResponse->statusCode = 200;
        $curlResponse->longurl = 'https://criticalmass.one/';

        $expectedRequestData = [
            'username' => 'testusername',
            'password' => 'testpassword',
            'action' => 'expand',
            'format' => 'json',
            'shorturl' => 'foobarbaz',
        ];

        $curl = $this->createMock(Curl::class);
        $curl
            ->expects($this->once())
            ->method('post')
            ->with($this->equalTo('testurl'), $this->equalTo($expectedRequestData))
            ->will($this->returnValue($curlResponse));

        $http = new Http('testurl', 'testusername', 'testpassword');
        $http->setCurl($curl);

        $yourlsApiManager = new YourlsApiManager($http);

        $longurl = $yourlsApiManager->getShorturl('foobarbaz');

        $this->assertEquals('https://criticalmass.one/', $longurl);
    }
}
