<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventParticipants extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'role_id',
        'event_invitation_id'
    ]; 
}
