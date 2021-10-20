<?php

namespace App;

use App\Addstudent_sec;
use Illuminate\Support\Facades\Auth;

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

    public function getArmCount($id)
    {
        $getSections = Addsection_sec::where('schoolid', Auth::user()->schoolid)->pluck('id')->toArray();

        $sectioncountarray = array();


        for ($i=0; $i < count($getSections); $i++) { 
            
            $getStudentCount = Addstudent_sec::join('addsection_secs', 'addsection_secs.id','=','addstudent_secs.studentsection')
                            ->select('addstudent_secs.*', 'addsection_secs.sectionname')
                            ->where(['addstudent_secs.schoolid'=>Auth::user()->schoolid, 'addstudent_secs.classid'=>$id, 'addstudent_secs.studentsection'=>$getSections[$i]])->get();

            $addsection = Addsection_sec::find($getSections[$i]);

            $arrayToPush = array(
                "sectioncount" => $getStudentCount->count(),
                "sectionname"=> $addsection->sectionname

            );

            array_push($sectioncountarray, (object)$arrayToPush);

        }

        return collect($sectioncountarray);
    }
}
