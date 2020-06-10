<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForgotPassword extends Model
{
    protected $fillable = [
         'user_id',
         'otp'
    ];
}
