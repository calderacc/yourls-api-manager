<?php declare(strict_types=1);

namespace Tests\YourlsApiManager;

use Caldera\YourlsApiManager\Http\Http;
use Caldera\YourlsApiManager\Request\CreateShorturlRequest;
use Caldera\YourlsApiManager\Response\CreateShorturlResponse;
use Caldera\YourlsApiManager\YourlsApiManager;
use Curl\Curl;
use PHPUnit\Framework\TestCase;

class YourlsApiManagerTest extends TestCase
{
    public function testCreateShorturl(): void
    {
        $createShorturlRequest = new CreateShorturlRequest();
        $curlResponse = new \stdClass();
        $curlResponse->shorturl = 'foobarbaz';

        $expectedRequestData = [
            'username' => 'testusername',
            'password' => 'testpassword',
        ];

        $curl = $this->createMock(Curl::class);
        $curl
            ->expects($this->once())
            ->method('post')
            ->withConsecutive($this->equalTo('testurl'), $this->equalTo($expectedRequestData))
            ->will($this->returnValue($curlResponse));

        $http = new Http('testurl', 'testusername', 'testpassword');
        $http->setCurl($curl);

        $yourlsApiManager = new YourlsApiManager($http);

        $shorturl = $yourlsApiManager->createShorturl('https://criticalmass.one/', 'Critical Mass One');

        $this->assertEquals('foobarbaz', $shorturl);
    }
}