<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    //
     protected $fillable = [
         'event_name',
         'event_description',
         'event_type_id',
         'event_start_time',
         'event_response_by_time',
         'event_created_by'
    ];
}
