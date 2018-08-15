<?php
namespace TelcoLAB\Freshdesk\SDK\One\Tickets;

use Illuminate\Support\Collection;
use TelcoLAB\Freshdesk\SDK\Models\Conversation;
use TelcoLAB\Freshdesk\SDK\Request;
use TelcoLAB\Freshdesk\SDK\Traits\Json;

class Conversations extends Request
{
    use Json;

    public function all(int $ticketId): Collection
    {
        return Conversation::responseCollection(
            $this->sendJson('GET', "tickets/{$ticketId}/conversations", $this->getApiHeaders(), [])
        );
    }

    public function note(int $ticketId, string $description, array $optional = []): Conversation
    {
        $payload = array_merge([
            'body' => $description,
        ], $optional);

        return Conversation::response(
            $this->sendJson('POST', "tickets/{$ticketId}/note", $this->getApiHeaders(), $payload)
        );
    }

    public function reply(int $ticketId, string $description, array $optional = []): Conversation
    {
        $payload = array_merge([
            'body' => $description,
        ], $optional);

        return Conversation::response(
            $this->sendJson('POST', "tickets/{$ticketId}/reply", $this->getApiHeaders(), $payload)
        );
    }

    public function update(int $id, string $description, array $optional = []): Conversation
    {
        $payload = array_merge([
            'body' => $description,
        ], $optional);

        return Conversation::response(
            $this->sendJson('PUT', "conversations/{$id}", $this->getApiHeaders(), $payload)
        );
    }

    public function delete(int $id): void
    {
        $this->sendJson('DELETE', "conversations/{$id}", $this->getApiHeaders());
    }
}
