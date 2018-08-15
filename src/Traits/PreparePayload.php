<?php
namespace TelcoLAB\Freshdesk\SDK\Traits;

trait PreparePayload
{
    protected function prepareRequestPayloads(array $headers = [], $body = []): array
    {
        $headers = $this->prepareRequestHeaders($headers);

        if ($body instanceof StreamInterface) {
            return [$headers, $body];
        }

        if (isset($headers['Content-Type']) && $headers['Content-Type'] == 'application/json') {
            $body = !empty($body) ? json_encode($body) : null;
        } elseif (is_array($body)) {
            $body = http_build_query($body, null, '&');
        }

        return [$headers, $body];
    }
}
