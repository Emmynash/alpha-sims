<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassAverage extends Model
{
    use HasFactory;
    protected $fillable = [
        'term', 'classid', 'sectionId', 'session', 'average'
    ];
}
