<?php
namespace TelcoLAB\Freshdesk\SDK\Models;

class Conversation extends Model
{
    public function map($item): array
    {
        return [
            'attachments'   => $item->attribute('attachments'),
            'body'          => $item->attribute('body'),
            'body_text'     => $item->attribute('body_text'),
            'id'            => $item->attribute('id'),
            'incoming'      => $item->attribute('incoming'),
            'to_emails'     => $item->attribute('to_emails'),
            'private'       => $item->attribute('private'),
            'source'        => $item->attribute('source'),
            'support_email' => $item->attribute('support_email'),
            'ticket_id'     => $item->attribute('ticket_id'),
            'user_id'       => $item->attribute('user_id'),
            'created_at'    => $item->attribute('created_at'),
            'updated_at'    => $item->attribute('updated_at'),
        ];
    }
}
