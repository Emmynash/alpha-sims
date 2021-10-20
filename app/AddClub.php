<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddClub extends Model
{
    protected $fillable = [
        'schoolid', 'clubname'
    ];
}
