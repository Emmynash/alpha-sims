<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherAttendance extends Model
{
    protected $fillable = [
        'regnumber', 'schoolid', 'datetoday'
    ];
}
