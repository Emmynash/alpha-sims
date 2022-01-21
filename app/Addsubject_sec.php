<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Addsubject_sec extends Model
{
    public function getSubjectMark($regno, $subjectid, $session, $assesment_id, $subassessment_id){

        $subject = RecordMarks::where(['student_id'=>$regno, 'subjectid'=>$subjectid, 'session'=>$session, 'assesment_id'=>$assesment_id, 'subassessment_id'=>$subassessment_id])->first();

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
            return ucfirst($username->firstname);
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

    public function getPoints($scores)
    {

        $getPoints = Addgrades_sec::where(['schoolid'=> Auth::user()->schoolid, 'type'=>2])->get();

        for ($i=0; $i < $getPoints->count(); $i++) { 
            if ($scores >= $getPoints[$i]['marksfrom'] && $scores <= $getPoints[$i]['marksto']) {
                return $getPoints[$i]['point'];
            }
        }
    }

    public function getSubjectList($regno)
    {
        return $getSubjects = Addsubject_sec::all();
    }

    public function getSubjectTotal($regno, $session, $term, $subjectid)
    {
        return AssessmentTableTotal::where(['regno'=>$regno, 'session'=>$session, 'term'=>$term, 'subjectid'=>$subjectid])->first();
    }

}
