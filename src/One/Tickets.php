<?php
namespace TelcoLAB\Freshdesk\SDK\One;

use Illuminate\Support\Collection;
use TelcoLAB\Freshdesk\SDK\Models\Ticket;
use TelcoLAB\Freshdesk\SDK\Request;
use TelcoLAB\Freshdesk\SDK\Traits\Json;

class Tickets extends Request
{
    use Json;

    public function all(): Collection
    {
        return Ticket::responseCollection(
            $this->sendJson('GET', 'tickets', $this->getApiHeaders(), [])
        );
    }

    public function show(int $id): Ticket
    {
        return Ticket::response(
            $this->sendJson('GET', "tickets/{$id}", $this->getApiHeaders(), [])
        );
    }

    public function create(string $name, string $email, string $subject, string $description, int $priority = 1, int $status = 2, array $optional = []): Ticket
    {
        $payload = array_merge([
            'name'        => $name,
            'email'       => $email,
            'subject'     => $subject,
            'description' => $description,
            'priority'    => $priority,
            'status'      => $status,
        ], $optional);

        return Ticket::response(
            $this->sendJson('POST', 'tickets/', $this->getApiHeaders(), $payload)
        );
    }

    public function update(int $id, int $priority, int $status, array $optional = []): Ticket
    {
        $payload = array_merge([
            'priority' => $priority,
            'status'   => $status,
        ], $optional);

        return Ticket::response(
            $this->sendJson('PUT', "tickets/{$id}", $this->getApiHeaders(), $payload)
        );
    }

    public function delete(int $id): void
    {
        $this->sendJson('DELETE', "tickets/{$id}", $this->getApiHeaders(), []);
    }

    public function restore(int $id): void
    {
        $this->sendJson('PUT', "tickets/{$id}/restore", $this->getApiHeaders());
    }
}
