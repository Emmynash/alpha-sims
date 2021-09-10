<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Addpost extends Model
{
    protected $fillable = [
        'schoolId', 'schoolname', 'schoolemail', 'mobilenumber', 'schoolLogo', 'schoolwebsite', 'dateestablished', 'schooladdress', 'schoolprincipalsignature', 'status', 'periodfrom', 'periodto'
    ];

    public function getClassList($schoolid) {

        $schooltype = Addpost::find($schoolid);

        if ($schooltype->schooltype == "Primary") {
            $classlist_sec = Classlist_sec::where('schoolid', $schoolid)->get();
            return $classlist_sec;
        } else {
            $classlist_sec = Classlist_sec::where(['schoolid'=> $schoolid, 'status'=>1])->get();
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

            $classlist_sec = Classlist_sec::where('id', $classid)->first();
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

    public function getTotalBalTerm($schooid)
    {
        $getTotal = Addpost::find($schooid);
        $termAmount = AmountBalTableTerm::where(['term'=>$getTotal->term, 'session'=>$getTotal->schoolsession, 'school_id'=>$schooid])->first();
        return $termAmount;
        
    }

    public function getGradeDetails($schoolid, $classtype)
    {
        $grades = Addgrades_sec::where(['schoolid'=>$schoolid, 'type'=>$classtype])->get();

        return $grades;
    }

    public function getPaymentDetails()
    {
        return $this->hasOne('App\PaymentDetails', 'schoolid', 'id');
    }

    public function getGrade($studentaverage, $classtype)
    {
        $gradeFInal = "";

        $studentgradeprocess = Addgrades_sec::where(['schoolid'=> Auth::user()->schoolid, 'type'=>$classtype])->get();

        for ($i=0; $i < count($studentgradeprocess); $i++) {
            if ($studentaverage >= $studentgradeprocess[$i]['marksfrom'] && $studentaverage<= $studentgradeprocess[$i]['marksto']) {
                $gradeFInal = $studentgradeprocess[$i]['gpaname'];
            }
        }

        return $gradeFInal;
        
    }

    public function getSubjectList($regno, $session, $classid, $sectionid, $term)
    {
        $getSubjectList = CLassSubjects::where(['classid'=> $classid, 'sectionid'=>$sectionid, 'subjecttype'=>2])->pluck('subjectid')->toArray();
        $getStudentElective = ElectiveAdd::where(['regno'=>$regno, 'classid'=>$classid, 'sectionid'=>$sectionid])->pluck('subjectid')->toArray(); // get all student's elective subjects

        $subject = array();

        $subjectSum = array_merge($getSubjectList, $getStudentElective);

        for ($i=0; $i < count($subjectSum); $i++) { 

          $addmarksCheck = Addmark_sec::where(['subjectid' => $subjectSum[$i], 'term' => $term, 'session'=>$session, 'regno'=>$regno])->get();

            // if (count($addmarksCheck) > 0) {

            //     if ((int)$addmarksCheck[0]->totalmarks > 0) {
                    $getSingleSubject = Addsubject_sec::find($subjectSum[$i]);
                    array_push($subject, $getSingleSubject);
            //     }
            // }
        }

        return $subjects = collect($subject);
    }

    public function getSubjectMark($regno, $subjectid, $session){

        $schooldata = Addpost::find(Auth::user()->schoolid);

        $subject = Addmark_sec::where(['regno'=>$regno, 'subjectid'=>$subjectid, 'session'=>$session, 'term'=>$schooldata->term])->first();

        return $subject;

        
    }

    public function getClassAverageMarkSubject($subjectid, $term, $session)
    {
        $averagemark = ClassAverageMark::where(['subjectid'=> $subjectid, 'term'=>$term, 'session'=>$session])->first();

        return $averagemark;
    }

    public function getTeacherName($subjectid)
    {
        $getTeacherId = TeacherSubjects::where('subject_id', $subjectid)->first();
        if ($getTeacherId == NULL) {
            return "NAN";
        } else {
            $username = User::find($getTeacherId->user_id);
            $firstname = ucfirst($username->firstname);
            $lastname = ucfirst(str_split($username->lastname)[0]);

            return $lastname.". ".$firstname;
        }
    }

    public function getResultSummary($subjectid, $session, $term, $regno)
    {
        $subject = Addmark_sec::where(['regno'=>$regno, 'subjectid'=>$subjectid, "term"=>$term, 'session'=>$session])->first();

        return $subject;
    }

    public function getAverageScore($subjectid, $session, $regno)
    {
        $subject = Addmark_sec::where(['regno'=>$regno, 'subjectid'=>$subjectid, 'session'=>$session])->sum(DB::raw('totalmarks'));

        return $subject/3;
    }

    public function getPoints($scores)
    {

        $getPoints = Addgrades_sec::where(['schoolid'=> Auth::user()->schoolid, 'type'=>2])->get();

        for ($i=0; $i < $getPoints->count(); $i++) { 
            if ($scores >= $getPoints[$i]['marksfrom'] && $scores <= $getPoints[$i]['marksto']) {
                return $getPoints[$i]['point'];
            }
        }
    }

    public function getResultAverage($regNo, $classid, $term, $schoolsession)
    {

       return ResultAverage::where(["regno"=>$regNo, "schoolid"=>Auth::user()->schoolid, "classid"=>$classid, "term"=>$term, "session"=>$schoolsession])->first();
    }

    public function getStudentComment($regNo, $classid, $term, $schoolsession)
    {
        return CommentsModel::where(['reg_no'=>$regNo, 'classid'=>$classid, 'term'=>$term, 'session'=>$schoolsession])->first();
    }

    public function getPromoAverage($regNo, $classid, $term, $schoolsession)
    {
        $promoAverage = PromotionAverage_sec::where(['regno'=>$regNo, 'session'=>$schoolsession, 'term'=>$term])->first();

        return $promoAverage;
    }


}
