<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotoList extends Model
{
    use HasFactory;

    public function getmotoscore($motoid, $studentid, $session, $term)
    {

        $addmotosec = AddMoto_sec::where(['moto_id'=>$motoid, 'student_id'=>$studentid, 'session'=>$session, 'term'=>$term])->first();

        if ($addmotosec == NULL) {
            return NAN;
        } else {
            return $addmotosec->moto_score;
        }
        

        
        
    }
}
