<?php

namespace Caldera\YourlsApiManager;

use Curl\Curl;

class YourlsApiManager
{
    /** @var string $apiUrl */
    protected $apiUrl;

    /** @var string $apiUsername */
    protected $apiUsername;

    /** @var string $apiPassword */
    protected $apiPassword;

    public function __construct(string $apiUrl, string $apiUsername, string $apiPassword)
    {
        $this->apiUrl = $apiUrl;
        $this->apiUsername = $apiUsername;
        $this->apiPassword = $apiPassword;
    }

    public function createPermalink(string $url, string $title): ?string
    {
        $data = [
            'url' => $url,
            'title' => $title,
            'format'   => 'json',
            'action'   => 'shorturl'
        ];

        $response = $this->postCurl($data);

        if (!isset($response->shorturl)) {
            return null;
        }

        $permalink = $response->shorturl;

        return $permalink;
    }

    public function getUrl(string $keyword): ?string
    {
        $data = [
            'shorturl' => $keyword,
            'format'   => 'json',
            'action'   => 'expand'
        ];

        $response = $this->postCurl($data);

        if (isset($response->errorCode) && $response->errorCode == 404) {
            return null;
        }

        $longUrl = $response->longurl;

        return $longUrl;
    }

    public function updatePermalink(string $keyword, string $url): bool
    {
        $data = [
            'url' => $url,
            'shorturl' => $keyword,
            'format'   => 'json',
            'action'   => 'update'
        ];

        $response = $this->postCurl($data);

        if (isset($response->statusCode) && $response->statusCode == 200) {
            return true;
        }

        return false;
    }

    protected function postCurl(array $data): ?\stdClass
    {
        $loginArray = [
            'username' => $this->apiUsername,
            'password' => $this->apiPassword
        ];

        $data = array_merge($data, $loginArray);

        $curl = new Curl();
        $curl->post(
            $this->apiUrl,
            $data
        );

        if ($curl->response) {
            return $curl->response;
        }

        return null;
    }
}
