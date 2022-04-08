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

    public function getStudentsArray($classid, $section)
    {
        return Addstudent_sec::where(['classid' => $classid, 'studentsection' => $section])->pluck('id');
    }

    public function getClassCount($classid, $session, $sectionid)
    {
        return Addstudent_sec::where(['classid'=>$classid, 'schoolsession'=>$session, 'studentsection'=>$sectionid])->get();
    }

    public function getStudentElective($regno, $classid, $sectionid)
    {
        $electives = ElectiveAdd::join('addsubject_secs', 'addsubject_secs.id','=','elective_adds.subjectid')
        ->where(['elective_adds.regno'=>$regno, 'elective_adds.classid'=>$classid, 'elective_adds.sectionid'=>$sectionid])
        ->select('elective_adds.*', 'addsubject_secs.subjectname', 'addsubject_secs.id as subjectid')->get();

        return $electives;
    }
}
