<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventParticipantsRole extends Model
{
    protected $fillable = [
        'role_name',
        'role_description',
        'is_active'
    ];    
}
