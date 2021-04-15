<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addteachers extends Model
{
    protected $fillable = [
        'schoolid', 'classid', 'classname', 'section', 'session', 'shift', 'systemid', 'firstname', 'middlename', 'lastname', 'gender', 'religion', 'bloodgroup', 'dob', 'presetaddress', 'permanentaddress', 'passport', 'track'
    ];

    public function teachersAttendance(){
        return $this->hasMany('App\TeacherAttendance', 'regnumber');
    }
}
