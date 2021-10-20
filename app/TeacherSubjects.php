<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherSubjects extends Model
{
    public function getSubjectName(){
        return $this->hasOne('App\Addsubject_sec', 'id', 'subject_id');
    }

    public function getClassName(){
        return $this->hasOne('App\Classlist_sec', 'id', 'classid');
    }

    public function getClassCount($id) {
        $getStudentCount = Addstudent_sec::where(['classid'=>$id, 'sessionstatus'=>0])->get();
        return $getStudentCount->count();
    }
}
