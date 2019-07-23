<?php declare(strict_types=1);

namespace Tests\YourlsApiManager;

use Caldera\YourlsApiManager\Http\Http;
use Caldera\YourlsApiManager\YourlsApiManager;
use Curl\Curl;
use PHPUnit\Framework\TestCase;

class UpdateShorturlTest extends TestCase
{
    public function testUpdateShorturl(): void
    {
        $curlResponse = new \stdClass();
        $curlResponse->shorturl = 'foobarbaz';
        $curlResponse->statusCode = 200;

        $expectedRequestData = [
            'username' => 'testusername',
            'password' => 'testpassword',
            'action' => 'update',
            'format' => 'json',
            'shorturl' => 'foobarbaz',
            'url' => 'https://criticalmass.one/'
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

        $response = $yourlsApiManager->updateShorturl('foobarbaz', 'https://criticalmass.one/');

        $this->assertTrue($response);
    }
}