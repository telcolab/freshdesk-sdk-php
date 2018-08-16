<?php
namespace TelcoLAB\Freshdesk\SDK\One;

use Illuminate\Support\Collection;
use TelcoLAB\Freshdesk\SDK\Exceptions\BadRequestException;
use TelcoLAB\Freshdesk\SDK\Models\Contact;
use TelcoLAB\Freshdesk\SDK\Request;
use TelcoLAB\Freshdesk\SDK\Traits\Json;

class Contacts extends Request
{
    use Json;

    public function all(): Collection
    {
        return Contact::responseCollection(
            $this->sendJson('GET', 'contacts', $this->getApiHeaders(), [])
        );
    }

    public function show(int $id): Contact
    {
        return Contact::response(
            $this->sendJson('GET', "contacts/{$id}", $this->getApiHeaders(), [])
        );
    }

    public function create(string $name, string $email, array $optional = []): Contact
    {
        $payload = array_merge([
            'name'  => $name,
            'email' => $email,
        ], $optional);

        return Contact::response(
            $this->sendJson('POST', 'contacts/', $this->getApiHeaders(), $payload)
        );
    }

    public function update(int $id, $name, $email, array $optional = []): Contact
    {
        $payload = array_merge([
            'name'  => $name,
            'email' => $email,
        ], $optional);

        return Contact::response(
            $this->sendJson('PUT', "contacts/{$id}", $this->getApiHeaders(), $payload)
        );
    }

    public function delete(int $id): void
    {
        $this->sendJson('DELETE', "contacts/{$id}", $this->getApiHeaders(), []);
    }

    public function forceDelete(int $id, bool $force = false): void
    {
        $this->sendJsonWithoutValidate('DELETE', $this->buildEndpointQuery("contacts/{$id}/hard_delete", ['force' => 'true']), $this->getApiHeaders(), [])
            ->validateWith(function ($statusCode, $response) {
                if ($statusCode === 400) {
                    throw new BadRequestException($response, 'Contact has not been soft deleted. Set force to `true` if want to force delete without soft delete the contact first.');
                }
            })->validate();
    }

    public function restore(int $id): void
    {
        $this->sendJson('PUT', "contacts/{$id}/restore", $this->getApiHeaders());
    }

    public function buildEndpointQuery(string $path, array $query = [])
    {
        return static::to('', $path, $query);
    }
}
