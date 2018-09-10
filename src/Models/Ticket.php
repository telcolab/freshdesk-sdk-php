<?php
namespace TelcoLAB\Freshdesk\SDK\Models;

use Illuminate\Support\Carbon;

class Ticket extends Model
{
    public function map($item): array
    {
        return [
            'cc_emails'        => $item->attribute('cc_emails'),
            'fwd_emails'       => $item->attribute('fwd_emails'),
            'reply_cc_emails'  => $item->attribute('reply_cc_emails'),
            'email_config_id'  => $item->attribute('email_config_id'),
            'fr_escalated'     => $item->attribute('fr_escalated'),
            'group_id'         => $item->attribute('group_id'),
            'priority'         => $item->attribute('priority'),
            'requester_id'     => $item->attribute('requester_id'),
            'responder_id'     => $item->attribute('responder_id'),
            'source'           => $item->attribute('source'),
            'spam'             => $item->attribute('spam'),
            'status'           => $item->attribute('status'),
            'subject'          => $item->attribute('subject'),
            'company_id'       => $item->attribute('company_id'),
            'id'               => $item->attribute('id'),
            'type'             => $item->attribute('type'),
            'to_emails'        => $item->attribute('to_emails'),
            'product_id'       => $item->attribute('product_id'),
            'created_at'       => Carbon::parse($item->attribute('created_at')),
            'updated_at'       => Carbon::parse($item->attribute('updated_at')),
            'due_by'           => Carbon::parse($item->attribute('due_by')),
            'fr_due_by'        => Carbon::parse($item->attribute('fr_due_by')),
            'is_escalated'     => $item->attribute('is_escalated'),
            'association_type' => $item->attribute('association_type'),
            'description_text' => $item->attribute('description_text'),
            'description'      => $item->attribute('description'),
            'custom_fields'    => $item->attribute('custom_fields'),
            'tags'             => $item->attribute('tags'),
            'attachments'      => $item->attribute('attachments'),
            'stats'            => $item->attribute('stats'),
            'requester'        => $item->attribute('requester'),
            'conversations'    => $item->attribute('conversations'),
            'company'          => $item->attribute('company'),
        ];
    }
}
