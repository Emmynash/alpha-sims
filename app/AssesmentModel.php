<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssesmentModel extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getSubassessments()
    {
        return $this->hasMany(SubAssesmentModel::class, 'catid', 'id');
    }

    public function getAssessment($assessmentId)
    {
        $subAssessment = SubAssesmentModel::where('catid', $assessmentId)->get();

        return count($subAssessment);
    }

    public function getAssessmentForScore($assessmentId)
    {
        $subAssessment = SubAssesmentModel::where('catid', $assessmentId)->get();

        return $subAssessment;
    }
}
