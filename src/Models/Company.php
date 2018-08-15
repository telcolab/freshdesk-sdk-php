<?php
namespace TelcoLAB\Freshdesk\SDK\Models;

class Company extends Model
{
    public function map($item): array
    {
        return [
            'custom_fields' => $item->attribute('custom_fields'),
            'description'   => $item->attribute('description'),
            'domains'       => $item->attribute('domains'),
            'id'            => $item->attribute('id'),
            'name'          => $item->attribute('name'),
            'note'          => $item->attribute('note'),
            'health_score'  => $item->attribute('health_score'),
            'account_tier'  => $item->attribute('account_tier'),
            'renewal_date'  => $item->attribute('renewal_date'),
            'industry'      => $item->attribute('industry'),
            'created_at'    => $item->attribute('created_at'),
            'updated_at'    => $item->attribute('updated_at'),
        ];
    }
}
