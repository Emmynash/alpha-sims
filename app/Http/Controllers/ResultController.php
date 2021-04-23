<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Addpost;
use App\User;
use App\Classlist;
use App\Addhouses;
use App\Addsection;
use App\AddClub;
use App\Addstudent;
use App\Addmarks;
use App\Addsubject;
use App\ClassAverageMarksPri;
use App\ResultAveragePri;
use Illuminate\Support\Facades\Auth;
use App\Addmoto;
use Redirect;
use Carbon\Carbon;
use App\Studentattendance;
use Illuminate\Support\Facades\DB;
use App\Quotation;

class ResultController extends Controller
{
    public function index(){

        $id = Auth::user()->schoolid;

        $userschool = Addpost::where('id', $id)->get();
        $classList = Classlist::where('schoolid', $id)->get();
        $addHouses = Addhouses::where('schoolid', $id)->get();
        $addSection = Addsection::where('schoolid', $id)->get();
        $addClub = AddClub::where('schoolid', $id)->get();
        $addstudent = Addstudent::where(['schoolid' => $id, 'usernamesystem' => Auth::user()->id])->get();

        // return $classList;

        $studentDetails = array(
            'userschool' => $userschool,
            'classList' => $classList,
            'addHouses' => $addHouses,
            'addSection' => $addSection,
            'addClub' => $addClub,
            'addstudent' => $addstudent
        );

        return view('pages.result')->with('studentDetails', $studentDetails);
    }

    // public function queryStudentForResult(Request $request){

    //     $validatedData = $request->validate([
    //         'studentclass' => 'required',
    //         'studentsection' => 'required',
    //         'sessionquery' => 'required',
    //         'studentshift' => 'required',
    //     ]);

    //     $addStudent = Addstudent::where(['schoolid' => Auth::user()->schoolid, 'classid' => $request->input('studentclass'), 'schoolsession' => $request->input('sessionquery'), 'studentshift' => $request->input('studentshift'), 'studentsection' => $request->input('studentsection')])->get();



    //     return redirect()->back()->with('addStudent', $addStudent);


    // }

    public function processresult(Request $request){
        
        // return $request->input('studentclass');

        $validatedData = $request->validate([
            'studentclass' => 'required',
            'schoolterm' => 'required',
            'regno' => 'required',
            'schoolsession'=>'required'
        ]);

        // return $request->input();

        // $addmarks = Addmarks::where(['term' => $request->input('schoolterm'), 'regno' => $request->input('studentid'), 'schoolid' => $request->input('schoolid'), 'classid' => $request->input('classid'), 'session' => $request->input('schoolsession')])->get();

        $studentclass = $request->input('studentclass');
        $term = $request->input('schoolterm');
        $studentregno = $request->input('regno');
        $schoolsession = $request->input('schoolsession');

        $request->session()->put('studentclass', $studentclass);
        $request->session()->put('term', $term);
        $request->session()->put('studentregno', $studentregno);
        $request->session()->put('schoolsession', $schoolsession);
        
        $addpost = Addpost::where('id', Auth::user()->schoolid)->get();

        $allDetails = array(
            'addpost'=>$addpost
        );

        return view('pages.resultprint')->with('allDetails', $allDetails);
        

    }
    
    public function fetchresultdetailsPri(Request $request){

        $classid = $request->input('classid');
        $term = $request->input('term');
        $regNo = $request->input('regNo');
        $schoolsession = $request->input('session');
        
        
//---------------------------------------------------------------------------------
//                           update classcount here
//----------------------------------------------------------------------------------

        $classList = Classlist::where('schoolid', Auth::user()->schoolid)->get();

        if(count($classList) > 0){
            for ($i=0; $i < count($classList); $i++) { 
                $classidcountupdate = $classList[$i]['id'];
                
                $studentcountquery = Addstudent::where('classid', $classidcountupdate)->get();
                
                $maincount = count($studentcountquery);
                
                $updatecountquery = Classlist::find($classidcountupdate);
                $updatecountquery->studentcount = $maincount;
                $updatecountquery->save();
                
            }
        }

//--------------------------------------------------------------------------------
//                                 process class average
//--------------------------------------------------------------------------------

        $addsubjectaverage = Addsubject::where('classid', $classid)->get();

        $subjectarray = array();

        for ($i=0; $i < count($addsubjectaverage); $i++) { 
            $subjid = $addsubjectaverage[$i]['id'];
            array_push($subjectarray, $subjid);
        }
        // get total class count

        // $addstudentAverage = Addstudent_sec::where('classid', $classid)->get();

        // $classcount = count($addstudentAverage);

        // return array_flip();

        // foreach ($subjectarray as $idx => $val) {
        //     $aa[$val] = $idx + 1;
        //   }
        //   return ($aa);

        //add average and data to database

        

        for ($i=0; $i < count($subjectarray); $i++) {

            $subjectidav = $subjectarray[$i];

            $addmarkcounter = Addmarks::where(['classid'=>$classid, 'term'=>$term, 'subjectid'=>$subjectidav, 'session'=>$schoolsession])->get();

            $addmarkAverage = DB::table('addmarks') 
            ->where(['classid'=>$classid, 'term'=>$term, 'subjectid'=>$subjectidav])->SUM('totalmarks');

            if (count($addmarkcounter) > 0) {
                $averagemark = $addmarkAverage/count($addmarkcounter);

                // return $addmarkAverage;

                // check if average has already been added.

                $averageCheck = ClassAverageMarksPri::where(['session'=>$schoolsession, 'classid'=>$classid, 'term'=>$term, 'subjectid'=>$subjectidav])->get();

                if (count($averageCheck) > 0) {

                    $averageCheckid = $averageCheck[0]['id'];

                    $averagemarkupdate = ClassAverageMarksPri::find($averageCheckid);
                    $averagemarkupdate->average = $averagemark;
                    $averagemarkupdate->save();
                    // return $averageCheck;
                    
                }else{

                    $addaverage = new ClassAverageMarksPri();
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


        $getaverageposition = ResultAveragePri::where(['classid'=>$classid, 'regno'=>$regNo, 'term'=>$term, 'session'=>$schoolsession])->get();
        

        if (count($getaverageposition) < 1) {

            return response()->json(['notready' => 'notready'], 200);
        }else{

            $psycomoto = Addmoto::where(['classid'=>$classid, 'term'=>$term, 'regno'=>$regNo, 'session'=>$schoolsession])->get();
            
            //  return $psycomoto;

            if (count($psycomoto) < 1) {
                return response()->json(['notready' => 'notready'], 200);
            }else{
                $resultdetails = DB::table('addmarks')
                ->join('addsubjects', 'addsubjects.id','=','addmarks.subjectid')
                ->join('class_average_marks_pris', 'class_average_marks_pris.subjectid','=','addmarks.subjectid')
                ->select('addmarks.*', 'addsubjects.subjectname', 'class_average_marks_pris.average')
                ->where(['addmarks.schoolid'=>Auth::user()->schoolid, 'addmarks.classid'=>$classid, 'addmarks.term'=>$term, 'addmarks.regno'=>$regNo])->get();



                $fetchUserDetails = DB::table('addstudents')
                    ->join('classlists', 'classlists.id','=','addstudents.classid')
                    ->join('users', 'users.id','=','addstudents.usernamesystem')
                    ->join('addsections', 'addsections.sectionname','=','addstudents.studentsection')
                    ->select('addstudents.*', 'classlists.classnamee', 'classlists.studentcount', 'users.firstname', 'users.middlename', 'users.lastname', 'addsections.sectionname')
                    ->where(['addstudents.id'=>$regNo])->get();

                return response()->json(['resultdetails'=>$resultdetails, 'fetchUserDetails'=>$fetchUserDetails, 'psycomoto'=>$psycomoto, 'positionaverage'=>$getaverageposition]);
            }
        }
    }

    public function addmoto(){
        
    }
}
