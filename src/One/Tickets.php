<?php
namespace TelcoLAB\Freshdesk\SDK\One;

use Illuminate\Support\Collection;
use Laravie\Codex\Concerns\Request\Multipart;
use TelcoLAB\Freshdesk\SDK\Models\Ticket;
use TelcoLAB\Freshdesk\SDK\Query;
use TelcoLAB\Freshdesk\SDK\Request;
use TelcoLAB\Freshdesk\SDK\Traits\Json;

class Tickets extends Request
{
    use Json, Multipart;

    public function all(Query $query = null): Collection
    {
        return Ticket::responseCollection(
            $this->sendJson('GET', 'tickets', $this->getApiHeaders(), $this->buildHttpQuery($query))
        );
    }

    public function fields(string $field = null): Collection
    {
        $queries = [];

        if (!is_null($field)) {
            $queries = [
                'type' => $field,
            ];
        }

        return Collection::make(
            $this->sendJson('GET', 'ticket_fields', $this->getApiHeaders(), $queries)
                ->getContent()
        );
    }

    public function search($query)
    {
        return Ticket::responseCollection(
            $this->sendJson('GET', 'search/tickets', $this->getApiHeaders(), ['query' => $this->wrapQuery($query)]),
            function ($content) {
                return $content['results'];
            }
        );
    }

    public function show(int $id, Query $query = null): Ticket
    {
        return Ticket::response(
            $this->sendJson('GET', "tickets/{$id}", $this->getApiHeaders(), $this->buildHttpQuery($query))
        );
    }

    public function create(string $name, string $email, string $subject, string $description, int $priority = 1, int $status = 2, array $attachments = [], array $optional = []): Ticket
    {
        $payload = array_merge([
            'name'        => $name,
            'email'       => $email,
            'subject'     => $subject,
            'description' => $description,
            'priority'    => $priority,
            'status'      => $status,
        ], $optional);

        if ($attachments) {
            list($headers, $payload) = $this->prepareMultipartRequestPayloads(
                $this->getApiHeaders(),
                $payload,
                $this->prepareAttachments($attachments)
            );
        } else {
            $headers = array_merge($this->getApiHeaders(), [
                'Content-Type' => 'application/json',
            ]);
        }

        return Ticket::response(
            $this->send('POST', 'tickets/', $headers, $payload)
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
