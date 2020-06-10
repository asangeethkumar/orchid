<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    //
    protected $fillable = [
        'event_type_name',
        'event_type_description'
    ];
}
