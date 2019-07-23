<?php declare(strict_types=1);

namespace Tests\Http;

use Caldera\YourlsApiManager\Http\Http;
use Caldera\YourlsApiManager\Request\DeleteShorturlRequest;
use Curl\Curl;
use PHPUnit\Framework\TestCase;

class HttpTest extends TestCase
{
    public function testHttp(): void
    {
        $curl = $this->createMock(Curl::class);
        $http = new Http('testurl', 'testusername', 'testpassword');
        $http->setCurl($curl);

        $curl
            ->expects($this->once())
            ->method('post')
            ->with($this->equalTo('testurl'))
            ->will($this->returnValue(new \stdClass));

        $request = new DeleteShorturlRequest();

        $http->post($request);

    }
}