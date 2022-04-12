<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addsection_sec extends Model
{
    //
    public function getClassCount($classid, $session, $sectionid)
    {
        return Addstudent_sec::where(['classid' => $classid, 'schoolsession' => $session, 'studentsection' => $sectionid])->get();
    }
    public function getStudentGender($regNo)
    {
        return Addstudent_sec::find($regNo);
    }
}
