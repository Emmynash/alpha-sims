<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addmark_sec extends Model
{
    //
    
    protected $fillable = ['regno','schoolid', 'classid','subjectid', 'exams','ca1', 'ca2','ca3', 'totalmarks','grades', 'term','session', 'shift', 'section'];


}
