<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Addpost extends Model
{
    protected $fillable = [
        'schoolId', 'schoolname', 'schoolemail', 'mobilenumber', 'schoolLogo', 'schoolwebsite', 'dateestablished', 'schooladdress', 'schoolprincipalsignature', 'status', 'periodfrom', 'periodto'
    ];

    public function getClassList($schoolid) {

        $schooltype = Addpost::find($schoolid);

        if ($schooltype->schooltype == "Primary") {
            $classlist_sec = Classlist::where('schoolid', $schoolid)->get();
            return $classlist_sec;
        } else {
            $classlist_sec = Classlist_sec::where('schoolid', $schoolid)->get();
            return $classlist_sec;
        }
        
    }

    public function getSectionList($schoolid) {
        $sectionlist_sec = Addsection_sec::where('schoolid', $schoolid)->get();
        return $sectionlist_sec;
    }

    public function gethouseList($schoolid) {
        $houselist_sec = Addhouse_sec::where('schoolid', $schoolid)->get();
        return $houselist_sec;
    }

    public function getclubList($schoolid) {
        $clublist_sec = Addclub_sec::where('schoolid', $schoolid)->get();
        return $clublist_sec;
    }

    public function getPaymentCategory()
    {
        return $this->hasMany('App\PaymentCategory', 'school_id');
    }

    public function getAmountCategory()
    {
        return $this->hasMany('App\AmountTable', 'school_id');
    }

    public function getClassName($classid)
    {

        $schoolDetails = Addpost::find(Auth::user()->schoolid);

        if ($schoolDetails->schooltype == "Primary") {

            $classlist_sec = Classlist::where('id', $classid)->first();
            return $classlist_sec;

        } else {
            $classlist_sec = Classlist_sec::where('id', $classid)->first();
            return $classlist_sec;
        }
        
    }

    public function getCategoryName($catid)
    {
        $category = PaymentCategory::where('id', $catid)->first();
        return $category;
    }

    public function getMoneyRequests()
    {
        return $this->hasMany('App\RequestModelAccount', 'schoolid')->orderBy("created_at", "desc");
    }

    public function getItemsInventody()
    {
        return $this->hasMany('App\InventoryModel', 'schoolid');
    }

    public function getAvailableItems($schoolid)
    {
        $availableItems = InventoryModel::where([['quantity', '>=', 1], 'schoolid'=>$schoolid])->get();

        return count($availableItems);
    }

    public function getTotalBal()
    {
        return $this->hasOne('App\AmountBalTableTotal', 'school_id', 'id');
        
    }

    public function getTotalBalTerm()
    {
        return $this->hasOne('App\AmountBalTableTerm', 'school_id', 'id');
        
    }

    public function getGradeDetails($schoolid)
    {
        $grades = Addgrades_sec::where(['schoolid'=>$schoolid, 'type'=>2])->get();

        return $grades;
    }

    public function getPaymentDetails()
    {
        return $this->hasOne('App\PaymentDetails', 'schoolid', 'id');
    }


}
