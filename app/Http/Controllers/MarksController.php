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
use App\Addsubject;
use App\Addmarks;
use App\Addgrades;
use App\Addteachers;
use Auth;
use App\ResultAveragePri;
use Redirect;
use Carbon\Carbon;
use App\Studentattendance;
use Validator;
use DB;

class MarksController extends Controller
{
    public function index(){

        $id = Auth::user()->schoolid;

        $userschool = Addpost::where('id', $id)->get();
        $classList = Classlist::where('schoolid', $id)->get();
        $addHouses = Addhouses::where('schoolid', $id)->get();
        $addSection = Addsection::where('schoolid', $id)->get();
        $addClub = AddClub::where('schoolid', $id)->get();
        // $addsubject = Addsubject::where('schoolid', $id)->get();
        $gradeCheck = Addgrades::where('schoolid', $id)->get();

        if (Auth::user()->role == "Teacher") {

            $addteachers = Addteachers::where(['schoolid' => $id, 'systemid' => Auth::user()->id])->get();

            $studentDetails = array(
                'userschool' => $userschool,
                'classList' => $classList,
                'addHouses' => $addHouses,
                'addSection' => $addSection,
                'addClub' => $addClub,
                'gradeCheck' => $gradeCheck,
                'addteachers' => $addteachers
            );

            // return $studentDetails['gradeCheck'][0]['classid'];

        } else {

            $studentDetails = array(
                'userschool' => $userschool,
                'classList' => $classList,
                'addHouses' => $addHouses,
                'addSection' => $addSection,
                'addClub' => $addClub,
                'gradeCheck' => $gradeCheck
            );
        }

        

        

        return view('pages.addmarks')->with('studentDetails', $studentDetails);
    }

    public function getClassSubject(Request $request){

        $classid = $request->input('classid');

        $subject = Addsubject::where(['schoolid' => Auth::user()->schoolid, 'classid' => $classid])->get();


        return response()->json($subject, 200);

    }

    public function getsubjectmarks(Request $request){

        $subjectId = $request->input('subjectId');

        $selectedSubject = Addsubject::where(['schoolid' => Auth::user()->schoolid, 'id' => $subjectId])->get();

        return response()->json($selectedSubject, 200);

    }

    public function getclassStudentsbyname(Request $request){

        $session = $request->input('session');
        $classId = $request->input('classId');
        $subjectbyclassid = $request->input('subjectbyclassid');
        $schoolterm = $request->input('schoolterm');
        $studentshift = $request->input('studentshift');
        $studentsection = $request->input('studentsection');

        $studentlist = DB::table('addstudents')
        ->join('users', 'users.id', '=', 'addstudents.usernamesystem')
        ->select('addstudents.*', 'users.firstname', 'users.middlename', 'users.lastname')
        ->where(['addstudents.classid' => $classId, 'addstudents.schoolsession' => $session, 'addstudents.studentshift' => $studentshift, 'addstudents.studentsection' => $studentsection])->get();

        $marksCheck = Addmarks::where(['subjectid' => $subjectbyclassid, 'classid' => $classId, 'term' => $schoolterm, 'section' => $studentsection])->get();

        $a = array();

        for ($i=0; $i < count($marksCheck); $i++) { 
            $marksRegNum = $marksCheck[$i]['regno'];
                array_push($a, $marksRegNum);
        }

        return response()->json([$studentlist, $a, $marksCheck], 200);
    }

    public function addStudentMarks(Request $request){

        // return response()->json($request->input(), 200);
        $validatedData = $request->validate([
            'schoolsession' => 'required',
            'schooltermform' => 'required',
            'selectedClassform' => 'required',
            'studentregnomarks' => 'required',
            'studentsectionform' => 'required',
            'studentshiftform' => 'required',
            'subjectbyclassidform' => 'required'
        ]);



        $checkifidexists = $request->input('markidform');
        $studentId = $request->input('studentregnomarks');
        $examsmarks = $request->input('exams');
        $ca1marks = $request->input('ca1');
        $ca2marks = $request->input('ca2');
        $ca3marks = $request->input('ca3');
        $attendancemarks = "NA";
        $selectedclassidMain = $request->input('selectedClassform');
        $subjectbyclassidMain = $request->input('subjectbyclassidform');
        $schooltermMain = $request->input('schooltermform');
        $studentshiftMain = $request->input('studentshiftform');
        $studentsectionMain = $request->input('studentsectionform');
        $sessionquery = $request->input('schoolsession');

        if ($examsmarks == "" && $ca1marks == "" && $ca2marks == "" && $ca3marks == "") {
            $msg = "Failed";
            
            return response()->json(['msg' => $msg], 200);
        }

//---------------------------------------------------------------------------------
//                  check if result has already been entered
//---------------------------------------------------------------------------------
        $checkduplicate = Addmarks::where(['regno'=>$studentId, 'schoolid'=>Auth::user()->schoolid, 'classid'=>$selectedclassidMain, 'session'=>$sessionquery, 'subjectid' => $subjectbyclassidMain, 'section'=>$request->input('studentsectionform')])->get();

        if(count($checkduplicate) > 0 && $checkifidexists == "NA"){
            $msg = "duplicate";
            
            return response()->json(['msg' => $msg], 200);
        }
        

//--------------------------------------------------------------------------------
//              enter grades either complete or partly the first time
//--------------------------------------------------------------------------------

        if ($checkifidexists == "NA") {

                $studentgradeprocess = Addgrades::where('schoolid', Auth::user()->schoolid)->get();

                if (count($studentgradeprocess) < 5) {
                    $msg = "grades";
            
                    return response()->json(['msg' => $msg], 200);
                }else{
//---------------------------------------------------------------------------------
//                                partial result entry
//---------------------------------------------------------------------------------
                    if ($examsmarks == "" || $ca1marks == "" || $ca2marks == "" || $ca3marks == "") {
                        
                    $totalmarks = $examsmarks + $ca1marks + $ca2marks + $ca3marks;

                    $studentgradeprocess = Addgrades::where('schoolid', Auth::user()->schoolid)->get();
    
                    $gradeFInal = "";
    
                    for ($i=0; $i < count($studentgradeprocess); $i++) {
                        if ($totalmarks >= $studentgradeprocess[$i]['marksfrom'] && $totalmarks<= $studentgradeprocess[$i]['marksto']) {
                            $gradeFInal = $studentgradeprocess[$i]['gpaname'];
                        }
                    }
            
                    $addmarks = new Addmarks();
                    $addmarks->regno = $studentId;
                    $addmarks->schoolid = Auth::user()->schoolid;
                    $addmarks->classid = $selectedclassidMain;
                    $addmarks->subjectid = $subjectbyclassidMain;
                    $addmarks->exams = $examsmarks;
                    $addmarks->ca1 = $ca1marks;
                    $addmarks->ca2 = $ca2marks;
                    $addmarks->ca3 = $ca3marks;
                    $addmarks->totalmarks = $totalmarks;
                    $addmarks->grades = $gradeFInal;;
                    $addmarks->term = $schooltermMain;
                    $addmarks->session = $sessionquery;
                    $addmarks->shift = $studentshiftMain;
                    $addmarks->section = $studentsectionMain;
                    $addmarks->save();
                    
                    // get student position

                    $getstudentposition = Addmarks::where(['schoolid'=>Auth::user()->schoolid, 'classid'=>$selectedclassidMain, 'session'=>$sessionquery, 'subjectid' => $subjectbyclassidMain, 'section'=>$request->input('studentsectionform')])->orderBy('totalmarks', 'desc')->get();

                    $subjectscrorearray = array();
                    

                    for ($i=0; $i < count($getstudentposition); $i++) { 
                        $score = $getstudentposition[$i]['totalmarks'];
                            array_push($subjectscrorearray, $score);
                        
                    }

                    for ($i=0; $i < count($getstudentposition); $i++) { 

                        $mainScore = $getstudentposition[$i]['totalmarks'];
                        $mainScoreId = $getstudentposition[$i]['id'];

                        $positiongotten = array_search($mainScore, $subjectscrorearray);

                        $updateposition = Addmarks::find($mainScoreId);
                        $updateposition->position = $positiongotten + 1;
                        $updateposition->save();
                        
                    }
            
                    $msg = "success";
            
                    return response()->json(['msg' => $msg], 200);
                    }else{

//---------------------------------------------------------------------------------
//                              enter complete result
//---------------------------------------------------------------------------------
                        $totalmarks = $examsmarks + $ca1marks + $ca2marks + $ca3marks;

                        $gradeFInal = "";

                        for ($i=0; $i < count($studentgradeprocess); $i++) {
                            if ($totalmarks >= $studentgradeprocess[$i]['marksfrom'] && $totalmarks<= $studentgradeprocess[$i]['marksto']) {
                                $gradeFInal = $studentgradeprocess[$i]['gpaname'];
                            }
                        }
                
                        $addmarks = new Addmarks();
                        $addmarks->regno = $studentId;
                        $addmarks->schoolid = Auth::user()->schoolid;
                        $addmarks->classid = $selectedclassidMain;
                        $addmarks->subjectid = $subjectbyclassidMain;
                        $addmarks->exams = $examsmarks;
                        $addmarks->ca1 = $ca1marks;
                        $addmarks->ca2 = $ca2marks;
                        $addmarks->ca3 = $ca3marks;
                        $addmarks->totalmarks = $totalmarks;
                        $addmarks->grades = $gradeFInal;
                        $addmarks->term = $schooltermMain;
                        $addmarks->session = $sessionquery;
                        $addmarks->shift = $studentshiftMain;
                        $addmarks->section = $studentsectionMain;
                        $addmarks->save();
                        
                            // get student position
    
                        $getstudentposition = Addmarks::where(['schoolid'=>Auth::user()->schoolid, 'classid'=>$selectedclassidMain, 'session'=>$sessionquery, 'subjectid' => $subjectbyclassidMain, 'section'=>$request->input('studentsectionform')])->orderBy('totalmarks', 'desc')->get();
    
                        $subjectscrorearray = array();
                        
    
                        for ($i=0; $i < count($getstudentposition); $i++) { 
                            $score = $getstudentposition[$i]['totalmarks'];
                                array_push($subjectscrorearray, $score);
                            
                        }
    
                        for ($i=0; $i < count($getstudentposition); $i++) { 
    
                            $mainScore = $getstudentposition[$i]['totalmarks'];
                            $mainScoreId = $getstudentposition[$i]['id'];
    
                            $positiongotten = array_search($mainScore, $subjectscrorearray);
    
                            $updateposition = Addmarks::find($mainScoreId);
                            $updateposition->position = $positiongotten + 1;
                            $updateposition->save();
                            
                        }
                
                        $msg = "success";
                
                        return response()->json(['msg' => $msg], 200);
                    }
                    
                }
        }else{
//----------------------------------------------------------------------------------
//                                 updating of result
//----------------------------------------------------------------------------------
            

            $grademarkid = $request->input('markidform');

        //---------------------------------------------------------
        //               processing patial entry
        //---------------------------------------------------------

            if ($examsmarks == "" || $ca1marks == "" || $ca2marks == "" || $ca3marks == "") {
                
                $totalmarks = $examsmarks + $ca1marks + $ca2marks + $ca3marks;

                $studentgradeprocess = Addgrades::where('schoolid', Auth::user()->schoolid)->get();

                $gradeFInal = "";

                for ($i=0; $i < count($studentgradeprocess); $i++) {
                    if ($totalmarks >= $studentgradeprocess[$i]['marksfrom'] && $totalmarks<= $studentgradeprocess[$i]['marksto']) {
                        $gradeFInal = $studentgradeprocess[$i]['gpaname'];
                    }
                }
                
                $updatestudentresult = Addmarks::find($grademarkid);
                $updatestudentresult->exams = $examsmarks;
                $updatestudentresult->ca1 = $ca1marks;
                $updatestudentresult->ca2 = $ca2marks;
                $updatestudentresult->ca3 = $ca3marks;
                $updatestudentresult->totalmarks = $totalmarks;
                $updatestudentresult->grades = $gradeFInal;
                $updatestudentresult->save();
                
                    // get student position

                    $getstudentposition = Addmarks::where(['schoolid'=>Auth::user()->schoolid, 'classid'=>$selectedclassidMain, 'session'=>$sessionquery, 'subjectid' => $subjectbyclassidMain, 'section'=>$request->input('studentsectionform')])->orderBy('totalmarks', 'desc')->get();

                    $subjectscrorearray = array();
                    

                    for ($i=0; $i < count($getstudentposition); $i++) { 
                        $score = $getstudentposition[$i]['totalmarks'];
                            array_push($subjectscrorearray, $score);
                        
                    }

                    for ($i=0; $i < count($getstudentposition); $i++) { 

                        $mainScore = $getstudentposition[$i]['totalmarks'];
                        $mainScoreId = $getstudentposition[$i]['id'];

                        $positiongotten = array_search($mainScore, $subjectscrorearray);

                        $updateposition = Addmarks::find($mainScoreId);
                        $updateposition->position = $positiongotten + 1;
                        $updateposition->save();
                        
                    }

                $msg = "success";
                    
                return response()->json(['msg' => $msg], 200);


            } else {
        //-----------------------------------------------------------------
        //                     process result with grade
        //-----------------------------------------------------------------

                $totalmarks = $examsmarks + $ca1marks + $ca2marks + $ca3marks;

                $studentgradeprocess = Addgrades::where('schoolid', Auth::user()->schoolid)->get();

                $gradeFInal = "";

                for ($i=0; $i < count($studentgradeprocess); $i++) {
                    if ($totalmarks >= $studentgradeprocess[$i]['marksfrom'] && $totalmarks<= $studentgradeprocess[$i]['marksto']) {
                        $gradeFInal = $studentgradeprocess[$i]['gpaname'];
                    }
                }

                $updatestudentresult = Addmarks::find($grademarkid);
                $updatestudentresult->exams = $examsmarks;
                $updatestudentresult->ca1 = $ca1marks;
                $updatestudentresult->ca2 = $ca2marks;
                $updatestudentresult->ca3 = $ca3marks;
                $updatestudentresult->totalmarks = $totalmarks;
                $updatestudentresult->grades = $gradeFInal;
                $updatestudentresult->save();
                
                
                // get student position

                $getstudentposition = Addmarks::where(['schoolid'=>Auth::user()->schoolid, 'classid'=>$selectedclassidMain, 'session'=>$sessionquery, 'subjectid' => $subjectbyclassidMain, 'section'=>$request->input('studentsectionform')])->orderBy('totalmarks', 'DESC')->get();

                $subjectscrorearray = array();
                

                for ($i=0; $i < count($getstudentposition); $i++) { 
                    $score = $getstudentposition[$i]['totalmarks'];
                        array_push($subjectscrorearray, $score);
                    
                }
                
                // return $subjectscrorearray;

                for ($i=0; $i < count($getstudentposition); $i++) { 

                    $mainScore = $getstudentposition[$i]['totalmarks'];
                    $mainScoreId = $getstudentposition[$i]['id'];

                    $positiongotten = array_search($mainScore, $subjectscrorearray);

                    $updateposition = Addmarks::find($mainScoreId);
                    $updateposition->position = $positiongotten + 1;
                    $updateposition->save();
                    
                }
                
                

                $msg = "success";
                    
                return response()->json(['msg' => $msg], 200);
                
            }
        }
   
    }

    public function viewmarks(){

        $id = Auth::user()->schoolid;


        $userschool = Addpost::where('id', $id)->get();
        $classList = Classlist::where('schoolid', $id)->get();
        $addHouses = Addhouses::where('schoolid', $id)->get();
        $addSection = Addsection::where('schoolid', $id)->get();
        $addClub = AddClub::where('schoolid', $id)->get();
        
        if (Auth::user()->role == "Teacher") {

            $addteachers = Addteachers::where(['schoolid' => $id, 'systemid' => Auth::user()->id])->get();

            $studentDetails = array(
                'userschool' => $userschool,
                'classList' => $classList,
                'addHouses' => $addHouses,
                'addSection' => $addSection,
                'addClub' => $addClub,
                'addteachers' => $addteachers
            );

            // return $studentDetails['addteachers'][0]['classid'];

        } else {

            $studentDetails = array(
                'userschool' => $userschool,
                'classList' => $classList,
                'addHouses' => $addHouses,
                'addSection' => $addSection,
                'addClub' => $addClub
            );
        }
        



        return view('pages.viewmarks')->with('studentDetails', $studentDetails);
    }

    public function viewusersbyclass(Request $request){

        // return response()->json($request->input(), 200);

        $validator = Validator::make($request->all(),[
            'studentclass' => 'required',
            'subjectbyclass' => 'required',
            'schoolterm' => 'required',
            'sessionquery' => 'required',
            'studentshift' => 'required',
            'studentsection' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $session = $request->input('sessionquery');
        $classId = $request->input('studentclass');
        $subjectbyclassid = $request->input('subjectbyclass');
        $schoolterm = $request->input('schoolterm');
        $studentshift = $request->input('studentshift');
        $studentsection = $request->input('studentsection');

        $marks = Addmarks::where(['schoolid' => Auth::user()->schoolid, 'classid' => $classId, 'subjectid' => $subjectbyclassid, 'term' => $schoolterm, 'shift' => $studentshift, 'section' => $studentsection, 'session' => $session])->get();
        
            $studentlist = DB::table('addstudents')
            ->join('users', 'users.id', '=', 'addstudents.usernamesystem')
            ->leftJoin('addmarks', function($join) use($subjectbyclassid, $schoolterm){
                $join->on('addmarks.regno', '=', 'addstudents.id');
                $join->where(['addmarks.subjectid' => $subjectbyclassid, 'addmarks.term'=> $schoolterm]);
            })
            ->select('addstudents.*', 'users.firstname', 'users.middlename', 'users.lastname', 'addmarks.subjectid', 'addmarks.exams', 'addmarks.grades', 'addmarks.totalmarks', 'addmarks.ca1', 'addmarks.ca2', 'addmarks.ca3', 'addmarks.position', 'addmarks.id as markid')
            ->where(['addstudents.classid' => $classId, 'addstudents.schoolsession' => $session, 
            'addstudents.studentshift' => $studentshift, 'addstudents.studentsection' => $studentsection])->orderBy('renumberschoolnew', 'desc')->get();

        $a = array();

        for ($i=0; $i < count($marks); $i++) { 
            $markscheck = $marks[$i]['regno'];
                array_push($a, $markscheck);
        }

        return response()->json([$studentlist, $a], 200);

    }

    public function deletestudent(Request $request){

        $studentmarkId = $request->input('studentmarkId');

        $deletemarks = Addmarks::find($studentmarkId);
        $deletemarks->delete();
        
        return response()->json(['msg' => "success"], 200);

    }

    public function try(){

        return back();
    }
    
    
    public function processPriPosition(Request $request){
        
        // return $request->input();
            // process student position
            $validator = Validator::make($request->all(),[
                'classidmarks' => 'required',
                'processterm' => 'required',
                'sessionprocessmark' => 'required',
                'selectedsection' => 'required',
            ]);
        
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()->keys()]);
            }
        
            $checkaverage = ResultAveragePri::where(['classid'=>$request->input('classidmarks'), 'term'=>$request->input('processterm'), 'session'=>$request->input('sessionprocessmark'), "section"=>$request->input('selectedsection')])->get();
        
            if (count($checkaverage) > 0) {
                return response()->json(['already'=>'already']);
            }
        
            $getallclassstudent = Addstudent::where(['classid'=>$request->input('classidmarks'), 'schoolsession'=>$request->input('sessionprocessmark')])->get();
        
            $studentregnumberarray = array();
        
            for ($i=0; $i < count($getallclassstudent); $i++) {
                $studentregno = $getallclassstudent[$i]['id'];
                array_push($studentregnumberarray, $studentregno);
            }
        
            // return count($studentregnumberarray);
        
            
        
            for ($i=0; $i < count($studentregnumberarray); $i++) { 
        
                $singleregno = $studentregnumberarray[$i];
        
                
                
                $studentmarks = Addmarks::where(['classid'=>$request->input('classidmarks'), 'term'=>$request->input('processterm'), 'regno'=>$singleregno, 'session'=>$request->input('sessionprocessmark')])->get();
        
                $scoresarraysingle = array();
                $coursesum = "";
                $averagevalue="";
        
                for ($d=0; $d < count($studentmarks); $d++) { 
                    $scoremainvalue = $studentmarks[$d]['totalmarks'];
                    array_push($scoresarraysingle, $scoremainvalue);
        
                    $coursesum = array_sum($scoresarraysingle);
        
                    $allsubjectcount = count($scoresarraysingle);
        
                    $averagevalue = $coursesum/$allsubjectcount;
                }
        
                $resultAverageAdd = new ResultAveragePri();
                $resultAverageAdd->regno = $singleregno;
                $resultAverageAdd->systemnumber = "0";
                $resultAverageAdd->schoolid = Auth::user()->schoolid;
                $resultAverageAdd->classid = $request->input('classidmarks');
                $resultAverageAdd->term = $request->input('processterm');
                $resultAverageAdd->section = $request->input('selectedsection');
                $resultAverageAdd->session = $request->input('sessionprocessmark');
                $resultAverageAdd->sumofmarks = $coursesum;
                $resultAverageAdd->average = $averagevalue;
                $resultAverageAdd->position = "0";
                $resultAverageAdd->save();  
            }
        
                $processposition = ResultAveragePri::where(['classid'=>$request->input('classidmarks'), 'term'=>$request->input('processterm'), 'session'=>$request->input('sessionprocessmark'), "section"=>$request->input('selectedsection')])->orderBy('average', 'desc')->get();
                
                $positiondeterminantarray = array();
        
            for ($i=0; $i < count($processposition); $i++) { 
                $id = $processposition[$i]['average'];
                array_push($positiondeterminantarray, $id);
            }
        
            for ($i=0; $i < count($processposition); $i++) { 
        
                $mainScore = $processposition[$i]['average'];
                $mainScoreId = $processposition[$i]['id'];
        
                $positiongotten = array_search($mainScore, $positiondeterminantarray);
        
                $updateposition = ResultAveragePri::find($mainScoreId);
                $updateposition->position = $positiongotten + 1;
                $updateposition->save();
            }
        
            
            return response()->json(['success'=>'success']);
    }
}
