<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddMoto_sec extends Model
{
    use HasFactory;
    // protected $guarded = [];
    protected $fillable = ['moto_id','moto_score', 'student_id', 'schoolid', 'session', 'term'];
}
