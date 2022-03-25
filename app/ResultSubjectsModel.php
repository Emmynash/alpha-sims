<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultSubjectsModel extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getAssessments($space_id)
    {
        return AssessmentResultModel::where(['space_id'=>$space_id])->get();
    }

    public function getAssessmentsTotal($space_id)
    {
        return AssessmentResultModel::where(['space_id'=>$space_id])->first();
    }
    public function getStudentRecord($subjectid, $schoolsession, $regNo){

        return AssessmentTableTotal::where(['subjectid'=> $subjectid, 'session' => $schoolsession, 'regno' => $regNo])->first();
    }
}
