<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addstudent_sec extends Model
{
    public function getStudentName(){
        return $this->hasOne('App\User', 'id', 'usernamesystem');
    }

    public function getClassName(){
        return $this->hasOne('App\Classlist_sec', 'id', 'classid');
    }

    public function getSectionName(){
        return $this->hasOne('App\Addsection_sec', 'id', 'studentsection');
    }

    public function getClassCount($classid, $session, $sectionid)
    {
        return Addstudent_sec::where(['classid'=>$classid, 'schoolsession'=>$session, 'studentsection'=>$sectionid])->get();
    }
}
