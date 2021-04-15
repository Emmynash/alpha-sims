<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addsection extends Model
{
    protected $fillable = [
        'schoolid', 'sectionname'
    ];
}
