<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Addsubject_sec extends Model
{
    public function getSubjectMark($regno, $subjectid, $session){

        $subject = Addmark_sec::where(['regno'=>$regno, 'subjectid'=>$subjectid, 'session'=>$session])->first();

        return $subject;

        
    }

    public function getClassAverageMarkSubject($subjectid, $term, $session)
    {
        $averagemark = ClassAverageMark::where(['subjectid'=> $subjectid, 'term'=>$term, 'session'=>$session])->first();

        return $averagemark;
    }

    public function getTeacherName($subjectid)
    {
        $getTeacherId = TeacherSubjects::where('subject_id', $subjectid)->first();
        if ($getTeacherId == NULL) {
            return "NAN";
        } else {
            $username = User::find($getTeacherId->user_id);
            return $username->firstname;
        }
    }

    public function getResultSummary($subjectid, $session, $term, $regno)
    {
        $subject = Addmark_sec::where(['regno'=>$regno, 'subjectid'=>$subjectid, "term"=>$term, 'session'=>$session])->first();

        return $subject;
    }

    public function getAverageScore($subjectid, $session, $regno)
    {
        $subject = Addmark_sec::where(['regno'=>$regno, 'subjectid'=>$subjectid, 'session'=>$session])->sum(DB::raw('totalmarks'));

        return $subject/3;
    }

}
