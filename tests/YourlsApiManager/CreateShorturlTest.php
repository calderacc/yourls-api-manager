<?php declare(strict_types=1);

namespace Tests\YourlsApiManager;

use Caldera\YourlsApiManager\Http\Http;
use Caldera\YourlsApiManager\YourlsApiManager;
use Curl\Curl;
use PHPUnit\Framework\TestCase;

class CreateShorturlTest extends TestCase
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
}
