<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addhouses extends Model
{
    protected $fillable = [
        'schoolid', 'housename'
    ];
}
