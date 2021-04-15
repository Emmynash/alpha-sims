<?php

namespace App;

use App\Addstudent_sec;

use Illuminate\Database\Eloquent\Model;

class Classlist_sec extends Model
{
    public function fetchFormMasters($id) {
        return $id;
    }

    public function getClassCount($id) {
        $getStudentCount = Addstudent_sec::where(['classid'=>$id, 'sessionstatus'=>0])->get();
        return $getStudentCount->count();
    }
}
