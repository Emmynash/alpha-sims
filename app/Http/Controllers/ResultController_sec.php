<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClassAverageMark;
use App\Classlist_sec;
use App\Addpost;
use App\Addsubject_sec;
use App\Addstudent_sec;
use App\Addmark_sec;
use App\Addmoto_sec;
use App\MotoList;
use App\ResultAverage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repository\Result\ProcessClassAverage;
use App\Repository\Result\ResultAverageProcess;


class ResultController_sec extends Controller
{
    public function index(){

        $classlist_sec = Classlist_sec::where('schoolid', Auth::user()->schoolid)->get();
        
        if(Auth::user()->role == "Student"){
            $studentdetails = Addstudent_sec::where('usernamesystem', Auth::user()->id)->get();
            
            $allDetails = array(
                'classlist_sec'=>$classlist_sec,
                'studentdetails'=>$studentdetails
            );
            
        }else{
            
            $allDetails = array(
                'classlist_sec'=>$classlist_sec
            );
            
        }

        // $allDetails = array(
        //     'classlist_sec'=>$classlist_sec
        // );

        return view('secondary.result_sec')->with('allDetails', $allDetails);
    }

    public function viewResult(Request $request){

        $validatedData = $request->validate([
            'selectedclassmarks' => 'required',
            'selectedtermmarks' => 'required',
            'studentRegnomarks' => 'required',
            'schoolsession'=>'required'
        ]);

        $studentclass = $request->input('selectedclassmarks');
        $term = $request->input('selectedtermmarks');
        $studentregno = $request->input('studentRegnomarks');
        $schoolsession = $request->input('schoolsession');

        $request->session()->put('studentclass', $studentclass);
        $request->session()->put('term', $term);
        $request->session()->put('studentregno', $studentregno);
        $request->session()->put('schoolsession', $schoolsession);
        
        $addpost = Addpost::where('id', Auth::user()->schoolid)->get();

        $allDetails = array(
            'addpost'=>$addpost
        );

        return view('secondary.result_view_sec')->with('allDetails', $allDetails);
    }

    public function fetchresultdetails(Request $request){
        
        $validatedData = $request->validate([
            'classid' => 'required',
            'term' => 'required',
            'regNo' => 'required',
            'session'=>'required'
        ]);

        $classid = $request->input('classid');
        $term = $request->input('term');
        $regNo = $request->input('regNo');
        $schoolsession = $request->input('session');
        
//---------------------------------------------------------------------------------
//-----------------------------update classcount here------------------------------
//---------------------------------------------------------------------------------

        $classList = Classlist_sec::where('schoolid', Auth::user()->schoolid)->get();

        if(count($classList) > 0){
            for ($i=0; $i < count($classList); $i++) { 
                $classidcountupdate = $classList[$i]['id'];
                
                $studentcountquery = Addstudent_sec::where('classid', $classidcountupdate)->get();
                
                $maincount = count($studentcountquery);
                
                $updatecountquery = Classlist_sec::find($classidcountupdate);
                $updatecountquery->studentcount = $maincount;
                $updatecountquery->save();
                
            }
        }

//--------------------------------------------------------------------------------
//                                 process class average
//--------------------------------------------------------------------------------

        $subjectarray = Addsubject_sec::where('classid', $classid)->pluck('id');
        

        for ($i=0; $i < count($subjectarray); $i++) {

            $subjectidav = $subjectarray[$i];

            $addmarkcounter = Addmark_sec::where(['classid'=>$classid, 'term'=>$term, 'subjectid'=>$subjectidav, 'session'=>$schoolsession])->get();

            $addmarkAverage = DB::table('addmark_secs') 
            ->where(['classid'=>$classid, 'term'=>$term, 'subjectid'=>$subjectidav])->SUM('totalmarks');

            if (count($addmarkcounter) > 0) {
                $averagemark = $addmarkAverage/count($addmarkcounter);

                // return $addmarkAverage;

                // check if average has already been added.

                $averageCheck = ClassAverageMark::where(['session'=>$schoolsession, 'classid'=>$classid, 'term'=>$term, 'subjectid'=>$subjectidav])->get();

                if (count($averageCheck) > 0) {

                    $averageCheckid = $averageCheck[0]['id'];

                    $averagemarkupdate = ClassAverageMark::find($averageCheckid);
                    $averagemarkupdate->average = $averagemark;
                    $averagemarkupdate->save();
                    // return $averageCheck;
                    
                }else{

                    $addaverage = new ClassAverageMark();
                    $addaverage->subjectid = $subjectidav;
                    $addaverage->schoolid = Auth::user()->schoolid;
                    $addaverage->classid = $classid;
                    $addaverage->average = $averagemark;
                    $addaverage->term = $term;
                    $addaverage->session = $schoolsession;
                    $addaverage->save();

                }

            }
            
        }


        $getaverageposition = ResultAverage::where(['classid'=>$classid, 'regno'=>$regNo, 'term'=>$term, 'session'=>$schoolsession])->get();

        if (count($getaverageposition) < 1) {

            return response()->json(['notready' => 'notready'], 200);
        }else{

            $psycomoto = Addmoto_sec::where(['classid'=>$classid, 'term'=>$term, 'regno'=>$regNo, 'session'=>$schoolsession])->get();

            if (count($psycomoto) < 1) {
                return response()->json(['notready' => 'notready'], 200);
            }else{
                $resultdetails = DB::table('addmark_secs')
                ->join('addsubject_secs', 'addsubject_secs.id','=','addmark_secs.subjectid')
                ->join('class_average_marks', 'class_average_marks.subjectid','=','addmark_secs.subjectid')
                ->join('classlist_secs', 'classlist_secs.id','=','addmark_secs.classid')
                ->select('addmark_secs.*', 'addsubject_secs.subjectname', 'class_average_marks.average', 'classlist_secs.classname')
                ->where(['addmark_secs.schoolid'=>Auth::user()->schoolid, 'addmark_secs.classid'=>$classid, 'addmark_secs.term'=>$term, 'addmark_secs.regno'=>$regNo])->get();



                $fetchUserDetails = DB::table('addstudent_secs')
                    ->join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
                    ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
                    ->join('addsection_secs', 'addsection_secs.id','=','addstudent_secs.studentsection')
                    ->select('addstudent_secs.*', 'classlist_secs.classname', 'users.firstname', 'users.middlename', 'users.lastname', 'addsection_secs.sectionname')
                    ->where(['addstudent_secs.id'=>$regNo])->get();

                return response()->json(['resultdetails'=>$resultdetails, 'fetchUserDetails'=>$fetchUserDetails, 'psycomoto'=>$psycomoto, 'positionaverage'=>$getaverageposition]);
            }
        }
    }

    public function viewSingleResult(Request $request)
    {


        $validatedData = $request->validate([
            'classid' => 'required',
            'term' => 'required',
            'student_reg_no' => 'required',
            'session'=>'required'
        ]);

        $classid = $request->input('classid');
        $term = $request->input('term');
        $regNo = $request->input('student_reg_no');
        $schoolsession = $request->input('session');

        $studentdetails = Addstudent_sec::find($regNo);

        $addschool = Addpost::find(Auth::user()->schoolid);
        $subjects = Addsubject_sec::where('classid', $classid)->get();

        $motolist = MotoList::where('schoolid', Auth::user()->schoolid)->get();

        $resultAverage = ResultAverage::where(["regno"=>$regNo, "schoolid"=>Auth::user()->schoolid, "classid"=>$classid, "term"=>$term, "session"=>$schoolsession])->first();

        return view('secondary.result.viewresult.singleresult', compact('studentdetails', 'addschool', 'schoolsession', 'term', 'subjects', 'motolist', 'resultAverage'));
        

//--------------------------------------------------------------------------------
//                                 process class average
//--------------------------------------------------------------------------------

        $subjectarray = Addsubject_sec::where('classid', $classid)->pluck('id');
        

        for ($i=0; $i < count($subjectarray); $i++) {

            $subjectidav = $subjectarray[$i];

            $addmarkcounter = Addmark_sec::where(['classid'=>$classid, 'term'=>$term, 'subjectid'=>$subjectidav, 'session'=>$schoolsession])->get();

            $addmarkAverage = DB::table('addmark_secs') 
            ->where(['classid'=>$classid, 'term'=>$term, 'subjectid'=>$subjectidav])->SUM('totalmarks');

            if (count($addmarkcounter) > 0) {
                $averagemark = $addmarkAverage/count($addmarkcounter);

                // return $addmarkAverage;

                // check if average has already been added.

                $averageCheck = ClassAverageMark::where(['session'=>$schoolsession, 'classid'=>$classid, 'term'=>$term, 'subjectid'=>$subjectidav])->get();

                if (count($averageCheck) > 0) {

                    $averageCheckid = $averageCheck[0]['id'];

                    $averagemarkupdate = ClassAverageMark::find($averageCheckid);
                    $averagemarkupdate->average = $averagemark;
                    $averagemarkupdate->save();
                    // return $averageCheck;
                    
                }else{

                    $addaverage = new ClassAverageMark();
                    $addaverage->subjectid = $subjectidav;
                    $addaverage->schoolid = Auth::user()->schoolid;
                    $addaverage->classid = $classid;
                    $addaverage->average = $averagemark;
                    $addaverage->term = $term;
                    $addaverage->session = $schoolsession;
                    $addaverage->save();

                }

            }
            
        }


        $getaverageposition = ResultAverage::where(['classid'=>$classid, 'regno'=>$regNo, 'term'=>$term, 'session'=>$schoolsession])->get();

        if (count($getaverageposition) < 1) {

            return response()->json(['notready' => 'notready'], 200);
        }else{

            $psycomoto = Addmoto_sec::where(['classid'=>$classid, 'term'=>$term, 'regno'=>$regNo, 'session'=>$schoolsession])->get();

            if (count($psycomoto) < 1) {
                return response()->json(['notready' => 'notready'], 200);
            }else{
                $resultdetails = DB::table('addmark_secs')
                ->join('addsubject_secs', 'addsubject_secs.id','=','addmark_secs.subjectid')
                ->join('class_average_marks', 'class_average_marks.subjectid','=','addmark_secs.subjectid')
                ->join('classlist_secs', 'classlist_secs.id','=','addmark_secs.classid')
                ->select('addmark_secs.*', 'addsubject_secs.subjectname', 'class_average_marks.average', 'classlist_secs.classname')
                ->where(['addmark_secs.schoolid'=>Auth::user()->schoolid, 'addmark_secs.classid'=>$classid, 'addmark_secs.term'=>$term, 'addmark_secs.regno'=>$regNo])->get();



                $fetchUserDetails = DB::table('addstudent_secs')
                    ->join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
                    ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
                    ->join('addsection_secs', 'addsection_secs.id','=','addstudent_secs.studentsection')
                    ->select('addstudent_secs.*', 'classlist_secs.classname', 'users.firstname', 'users.middlename', 'users.lastname', 'addsection_secs.sectionname')
                    ->where(['addstudent_secs.id'=>$regNo])->get();



                return response()->json(['resultdetails'=>$resultdetails, 'fetchUserDetails'=>$fetchUserDetails, 'psycomoto'=>$psycomoto, 'positionaverage'=>$getaverageposition]);
            }
        }

        
    }

    public function result_by_class()
    {
        $school = Addpost::find(Auth::user()->schoolid);

        return view('secondary.result.resultbyclass', compact('school'));
    }

    public function view_by_class(Request $request)
    {
        $term = $request->term;
        $section = $request->section;
        $session = $request->session;

        $entirestudent = Addstudent_sec::where(['classid'=>$request->classid, "studentsection"=>$request->section, "schoolsession"=>$request->session])->get();

        return view('secondary.result.viewentireclass', compact('entirestudent', 'term', 'section', 'session'));
    }

    public function generateResult()
    {
        $classlist = Classlist_sec::where('schoolid', Auth::user()->id)->get();

        return view('secondary.adminside.result.generateresult', compact('classlist'));
    }

    public function generateResultMain(Request $request, ProcessClassAverage $processClassAverage, ResultAverageProcess $resultAverageProcess)
    {


        //--------------------------------------------------------------------------------
        //                                 process class average
        //--------------------------------------------------------------------------------

        $resultAverage = $resultAverageProcess->processResultAverage($request);

        if ($resultAverage == "success") {
            
            $process_class_average = $processClassAverage->processresult($request);

            return $process_class_average;
        }








    }




}
