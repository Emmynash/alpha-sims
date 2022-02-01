<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentResultModel extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getSubjectScores($assessment_id)
    {
        return AssessmentScoreResultModel::where('assessment_id', $assessment_id)->first();
    }

    public function getSubjectScoresTotal($space_id)
    {
        return AssessmentResultModel::where('space_id', $space_id)->first();
    }
}
