<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addstudent extends Model
{
    protected $fillable = [
        'classid', 'classname', 'schoolid', 'usernamesystem', 'renumberschoolnew', 'studentsection', 'schoolsession', 'gender', 'studenthouse', 'studentreligion', 'bloodgroup', 'studentclub', 'studentshift', 'firstnamenew', 'middlenamenew', 'lastnamenew', 'studentfathername', 'studentfathernumber', 'studentmothersname', 'studentmothersnumber', 'studentpresenthomeaddress', 'studentpermanenthomeaddress', 'studentpassport', 'sessionstatus'
    ];

    public function getStudentName()
    {
        return $this->hasOne('App\User', 'id', 'usernamesystem');
    }

    public function getClassName()
    {
        return $this->hasOne('App\Classlist', 'id', 'classid');
    }

    public function getSection()
    {
        return $this->hasOne('App\Addsection', 'id', 'classid');
    }
}
