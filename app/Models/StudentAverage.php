<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAverage extends Model
{
    use HasFactory;
    protected $fillable = [
        'term', 'classid', 'regNo', 'session', 'average', 'section', 'examsTotal'
    ];
}
