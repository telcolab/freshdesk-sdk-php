<?php
namespace TelcoLAB\Freshdesk\SDK\Models;

class Contact extends Model
{
    public function map($item): array
    {
        return [
            'active'             => $item->attribute('active'),
            'address'            => $item->attribute('address'),
            'avatar'             => $item->attribute('avatar'),
            'view_all_tickets'   => $item->attribute('view_all_tickets'),
            'custom_fields'      => $item->attribute('custom_fields'),
            'deleted'            => $item->attribute('deleted'),
            'description'        => $item->attribute('description'),
            'email'              => $item->attribute('email'),
            'id'                 => $item->attribute('id'),
            'job_title'          => $item->attribute('job_title'),
            'language'           => $item->attribute('language'),
            'mobile'             => $item->attribute('mobile'),
            'name'               => $item->attribute('name'),
            'other_emails'       => $item->attribute('other_emails'),
            'phone'              => $item->attribute('phone'),
            'tags'               => $item->attribute('tags'),
            'time_zone'          => $item->attribute('time_zone'),
            'twitter_id'         => $item->attribute('twitter_id'),
            'unique_external_id' => $item->attribute('unique_external_id'),
            'other_companies'    => $item->attribute('other_companies'),
            'created_at'         => $item->attribute('created_at'),
            'updated_at'         => $item->attribute('updated_at'),
        ];
    }
}
