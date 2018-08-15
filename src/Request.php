<?php
namespace TelcoLAB\Freshdesk\SDK;

use Laravie\Codex\Request as BaseRequest;

class Request extends BaseRequest
{
    public function getApiHeaders(): array
    {
        return [
            'Authorization' => "Basic {$this->client->getBasicAuthToken()}",
        ];
    }
}
