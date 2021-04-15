<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addstudent extends Model
{
    protected $fillable = [
        'classid', 'classname', 'schoolid', 'usernamesystem', 'renumberschoolnew', 'studentsection', 'schoolsession', 'gender', 'studenthouse', 'studentreligion', 'bloodgroup', 'studentclub', 'studentshift', 'firstnamenew', 'middlenamenew', 'lastnamenew', 'studentfathername', 'studentfathernumber', 'studentmothersname', 'studentmothersnumber', 'studentpresenthomeaddress', 'studentpermanenthomeaddress', 'studentpassport', 'sessionstatus'
    ];
}
