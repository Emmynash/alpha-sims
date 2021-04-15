<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormTeachers extends Model
{
    use HasFactory;

    public function getClassName(){
        return $this->hasOne('App\Classlist_sec', 'id', 'class_id');
    }

    public function getSectionName(){
        return $this->hasOne('App\Addsection_sec', 'id', 'form_id');
    }

    public function getClassCount($id) {
        $getStudentCount = Addstudent_sec::where(['classid'=>$id, 'sessionstatus'=>0])->get();
        return $getStudentCount->count();
    }

    public function getSubjectList($classid){


        $allsubjects = Addsubject_sec::where('classid', $classid)->get();

        return $allsubjects;
    }
}
