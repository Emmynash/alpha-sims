<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SubAssesmentModel extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getScore($subAssessmentId, $class_id, $student_id, $subject_id, $session)
    {

        $getScore = RecordMarks::where(['subassessment_id' => $subAssessmentId, 'class_id' => $class_id, 'subjectid'=>$subject_id, 'student_id'=>$student_id, 'school_id'=>Auth::user()->schoolid, 'session'=>$session])->first();

        return $getScore;
        
    }

}
