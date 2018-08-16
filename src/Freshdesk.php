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

    protected $apiEndpoint;

    protected $defaultVersion = 'v1';

    protected $supportedVersions = [
        'v1' => 'One',
    ];

    public function __construct(HttpClient $http, string $domain, string $key)
    {
        $this->http        = $http;
        $this->apiEndpoint = $domain;
        $this->key         = $key;
    }

    public static function make(string $domain, string $key)
    {
        return new static(Discovery::client(), $domain, $key);
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
