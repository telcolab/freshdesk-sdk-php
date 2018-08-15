<?php
namespace TelcoLAB\Freshdesk\SDK\Traits;

use Laravie\Codex\Concerns\Request\Json as BaseJson;
use Laravie\Codex\Contracts\Endpoint as EndpointContract;
use Laravie\Codex\Contracts\Response as ResponseContract;

trait Json
{
    use BaseJson;

    protected function sendJsonWithoutValidate(string $method, $path, array $headers = [], $body = []): ResponseContract
    {
        $body = $this->sanitizeFrom($body);

        $endpoint = ($path instanceof EndpointContract)
        ? $this->getApiEndpoint($path->getPath())->addQuery($path->getQuery())
        : $this->getApiEndpoint($path);

        return $this->client->send($method, $endpoint, $headers, $body)
            ->setSanitizer($this->getSanitizer());
    }

}
