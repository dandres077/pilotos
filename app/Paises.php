<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paises extends Model
{
    protected $fillable = [
        'nombre', 
        'status', 
        'user_create', 
        'user_update'
    ];
}
