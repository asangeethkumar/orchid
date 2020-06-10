<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardsEventsMapping extends Model
{
    protected $fillable = [
        'event_id',
        'cards_id',
        'recipient_id',
        'recipient_email',
        'send_card_date',
        'recipient_social_media_id'
    ];
}
