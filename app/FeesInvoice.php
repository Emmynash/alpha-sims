<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesInvoice extends Model
{
    use HasFactory;

    public function getClassName()
    {
        return $this->hasOne('App\Classlist_sec', 'classid', 'id');
    }
}
