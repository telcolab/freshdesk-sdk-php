<?php
namespace TelcoLAB\Freshdesk\SDK\One\Tickets;

use Illuminate\Support\Collection;
use Laravie\Codex\Concerns\Request\Multipart;
use TelcoLAB\Freshdesk\SDK\Models\Conversation;
use TelcoLAB\Freshdesk\SDK\Request;
use TelcoLAB\Freshdesk\SDK\Traits\Json;

class Conversations extends Request
{
    use Json, Multipart;

    public function all(int $ticketId): Collection
    {
        return Conversation::responseCollection(
            $this->sendJson('GET', "tickets/{$ticketId}/conversations", $this->getApiHeaders(), [])
        );
    }

    public function note(int $ticketId, string $description, array $attachments = [], array $optional = []): Conversation
    {
        $payload = array_merge([
            'body' => $description,
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

        return Conversation::response(
            $this->send('POST', "tickets/{$ticketId}/notes", $headers, $payload)
        );
    }

    public function reply(int $ticketId, string $description, array $attachments = [], array $optional = []): Conversation
    {
        $payload = array_merge([
            'body' => $description,
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

        return Conversation::response(
            $this->send('POST', "tickets/{$ticketId}/reply", $headers, $payload)
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
