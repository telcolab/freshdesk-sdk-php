<?php
namespace TelcoLAB\Freshdesk\SDK\One;

use Illuminate\Support\Collection;
use TelcoLAB\Freshdesk\SDK\Models\Company;
use TelcoLAB\Freshdesk\SDK\Request;
use TelcoLAB\Freshdesk\SDK\Traits\Json;

class Companies extends Request
{
    use Json;

    public function all(): Collection
    {
        return Company::responseCollection(
            $this->sendJson('GET', 'companies', $this->getApiHeaders(), [])
        );
    }

    public function show(int $id): Company
    {
        return Company::response(
            $this->sendJson('GET', "companies/{$id}", $this->getApiHeaders(), [])
        );
    }

    public function create(string $name, array $optional = []): Company
    {
        $payload = array_merge([
            'name' => $name,
        ], $optional);

        return Company::response(
            $this->sendJson('POST', 'companies/', $this->getApiHeaders(), $payload)
        );
    }

    public function update(int $id, $name, array $optional = []): Company
    {
        $payload = array_merge([
            'name' => $name,
        ], $optional);

        return Company::response(
            $this->sendJson('PUT', "companies/{$id}", $this->getApiHeaders(), $payload)
        );
    }

    public function delete(int $id): void
    {
        $this->sendJson('DELETE', "companies/{$id}", $this->getApiHeaders(), []);
    }

    public function restore(int $id): void
    {
        $this->sendJson('PUT', "companies/{$id}/restore", $this->getApiHeaders());
    }
}
