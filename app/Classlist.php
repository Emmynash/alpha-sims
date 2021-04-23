<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classlist extends Model
{
    protected $fillable = [
        'schoolid', 'classnamee'
    ];

    public function getClassCount($classid)
    {
        $getClassCount = Addstudent::where('classid', $classid)->get();
        
        return $getClassCount->count();
    }
}
