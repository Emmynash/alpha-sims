<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSubjectPris extends Model
{
    use HasFactory;

    public function getClassCount($classid)
    {
        $classlist = Addstudent::where('classid', $classid)->get();

        return $classlist->count();
    }
}
