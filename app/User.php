<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'middlename', 'lastname', 'email', 'c', 'phonenumber', 'useridsystem', 'password', 'schoolid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function addstudents($stdId){
        return $this->hasOne('App\Addstudent_sec', 'usernamesystem');
    }

    public function getClassList(){
        return $this->hasMany('App\Classlist', 'schoolid', 'schoolid');
    }

    public function getHouseList(){
        return $this->hasMany('App\Addhouses', 'schoolid', 'schoolid');
    }

    public function getSectionList(){
        return $this->hasMany('App\Addsection', 'schoolid', 'schoolid');
    }

    public function getClubList(){
        return $this->hasMany('App\AddClub', 'schoolid', 'schoolid');
    }
    
    public function schoolDetails(){
        return $this->hasOne(Addpost::class, 'schoolid', 'schoolid');
    }
}
