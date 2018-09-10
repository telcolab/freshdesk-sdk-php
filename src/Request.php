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

    final protected function buildHttpQuery( ? Query $query) : array
    {
        return $query instanceof Query ? $query->toArray() : [];
    }

    final protected function wrapQuery($query): string
    {
        return '"' . $query . '"';
    }
}
