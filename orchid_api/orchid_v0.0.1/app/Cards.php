<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cards extends Model
{
    protected $fillable = [
         'cards_category_id',
         'cards_name',
         'cards_description',
         'cards_location_url',
         'is_active',
         'is_user_uploaded',
         'user_id_if_user_uploaded'
    ];
}
