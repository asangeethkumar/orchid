<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardsCategory extends Model
{
     protected $fillable = [
        'cards_category_name',
        'cards_category_description'
    ];
}
