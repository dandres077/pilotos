<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    protected $fillable = [
        'marca_id',
        'nombre', 
        'status', 
        'user_create', 
        'user_update'
    ];
}
