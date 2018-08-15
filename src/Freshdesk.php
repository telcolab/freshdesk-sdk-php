<?php
namespace TelcoLAB\Freshdesk\SDK;

use Http\Client\HttpClient;
use Laravie\Codex\Client;
use Laravie\Codex\Contracts\Response as ResponseContract;
use Laravie\Codex\Discovery;
use Psr\Http\Message\ResponseInterface;
use TelcoLAB\Freshdesk\SDK\Traits\PreparePayload;

class Freshdesk extends Client
{
    use PreparePayload;

    protected $apiEndpoint = 'https://pakarbiz.freshdesk.com/api/v2/';

    protected $defaultVersion = 'v1';

    protected $supportedVersions = [
        'v1' => 'One',
    ];

    public function __construct(HttpClient $http, string $key)
    {
        $this->http = $http;
        $this->key  = $key;
    }

    public static function make(string $key)
    {
        return new static(Discovery::client(), $key);
    }

    protected function responseWith(ResponseInterface $response): ResponseContract
    {
        return new Response($response);
    }

    protected function getResourceNamespace(): string
    {
        return __NAMESPACE__;
    }

    public function getBasicAuthToken()
    {
        return base64_encode("{$this->key}:X");
    }
}
