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
}
