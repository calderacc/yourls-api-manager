<?php declare(strict_types=1);

namespace Tests\YourlsApiManager;

use Caldera\YourlsApiManager\Http\Http;
use Caldera\YourlsApiManager\Request\CreateShorturlRequest;
use Caldera\YourlsApiManager\YourlsApiManager;
use Curl\Curl;
use PHPUnit\Framework\TestCase;

class YourlsApiManagerTest extends TestCase
{
    public function testCreateShorturl(): void
    {
        $curlResponse = new \stdClass();
        $curlResponse->shorturl = 'foobarbaz';

        $expectedRequestData = [
            'username' => 'testusername',
            'password' => 'testpassword',
            'action' => 'shorturl',
            'format' => 'json',
            'url' => 'https://criticalmass.one/',
            'title' => 'Critical Mass One',
        ];

        $curl = $this->createMock(Curl::class);
        $curl
            ->expects($this->once())
            ->method('post')
            ->with($this->equalTo('testurl'), $this->equalTo($expectedRequestData), false)
            ->will($this->returnValue($curlResponse));

        $http = new Http('testurl', 'testusername', 'testpassword');
        $http->setCurl($curl);

        $yourlsApiManager = new YourlsApiManager($http);

        $shorturl = $yourlsApiManager->createShorturl('https://criticalmass.one/', 'Critical Mass One');

        $this->assertEquals('foobarbaz', $shorturl);
    }

    public function testDeleteShorturl(): void
    {
        $curlResponse = new \stdClass();
        $curlResponse->shorturl = 'foobarbaz';
        $curlResponse->statusCode = 200;

        $expectedRequestData = [
            'username' => 'testusername',
            'password' => 'testpassword',
            'action' => 'delete',
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

        $response = $yourlsApiManager->deleteShorturl('foobarbaz');

        $this->assertTrue($response);
    }

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