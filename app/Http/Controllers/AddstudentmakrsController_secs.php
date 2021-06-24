<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classlist_sec;
use App\Addsection_sec;
use App\Addsubject_sec;
use App\Addmark_sec;
use App\Addpost;
use App\Addgrades_sec;
use Validator;
use App\ResultAverage;
use App\Addstudent_sec;
use App\PromotionAverage_sec;
use App\Addteachers_sec;
use App\CLassSubjects;
use App\SubjectScoreAllocation;
use App\TeacherSubjects;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddstudentmakrsController_secs extends Controller
{

    private $addpost;
    private $addsubject_sec;
    private $addmark_sec;

    public function __construct(Addpost $addpost, Addsubject_sec $addsubject_sec, Addmark_sec $addmark_sec)
    {

        $this->addpost = $addpost;
        $this->addsubject_sec = $addsubject_sec;
        $this->addmark_sec = $addmark_sec;
    }

    public function index(){

       $addpost = $this->addpost->where('id', Auth::user()->schoolid)->first();

       if (Auth::user()->hasRole('Teacher')) {
           $teachersSubjects = TeacherSubjects::where('user_id', Auth::user()->id)->pluck('subject_id');

           $arrayOfSubjects = array();

           for ($i=0; $i < count($teachersSubjects); $i++) { 

            $addsubject_sec = Addsubject_sec::join('classlist_secs', 'classlist_secs.id','=','addsubject_secs.classid')
                             ->where('addsubject_secs.id', $teachersSubjects[$i])
                             ->select("classlist_secs.classname", "classlist_secs.id")->first();

            array_push($arrayOfSubjects, $addsubject_sec);
               
           }

           $arrayOfClassesMain = array_unique($arrayOfSubjects);

        //    return view('secondary.teachers.addmarks.studentmarks', compact('addpost', 'arrayOfClassesMain'));
        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('secondary.teachers.addmarks.studentmarksreact', compact('schooldetails'));


       }


        // return view('secondary.adminside.markmanage_secs', compact('addpost'));

        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('secondary.adminside.managemarkreact', compact('schooldetails'));
    
    }

    public function fetchstudentssubject(Request $request, $classid, $sectionid){
        
        //---------------------------------------------------------------------------------------------------//
        //                                fetch subjects for each class                                      //
        // --------------------------------------------------------------------------------------------------//

        // if (Auth::user()->role == "Teacher") {

        //     $teachersSubjects = TeacherSubjects::where('user_id', Auth::user()->id)->pluck('subject_id')->toArray();

        //     $subjectlist = $this->addsubject_sec->where(['schoolid'=> Auth::user()->schoolid, 'classid'=>$request->input('classid')])->get();

        //     $teachersSubjectMain = array();

        //     for ($i=0; $i < count($subjectlist); $i++) { 
        //         if (in_array((int)$subjectlist[$i]['id'], $teachersSubjects, TRUE)) { 
        //             array_push($teachersSubjectMain, $subjectlist[$i]);
        //         }
        //     }

        //     return response()->json(['subjectlist'=>$teachersSubjectMain]);
            
        // }

        $classAllocatedSubject = CLassSubjects::where(['classid'=>$classid, 'sectionid'=>$sectionid])->pluck('subjectid')->toArray();

        $subjectsmain = array();

        for ($i=0; $i < count($classAllocatedSubject); $i++) { 
            $subjectlistsingle = Addsubject_sec::find($classAllocatedSubject[$i]);
            array_push($subjectsmain, $subjectlistsingle);
        }
        
        return response()->json(['subjectlist'=>$subjectsmain]);
    }

    public function fetchsubjectdetails(Request $request){
        
        //----------------------------------------------------------------------------------------------------//
        //                                  fetch all marks for each subject                                  //
        //----------------------------------------------------------------------------------------------------//
        
        $subjectlist = $this->addsubject_sec->where(['id'=>$request->input('subjectid')])->get();
        return response()->json(['subjectdetails'=>$subjectlist]);
    }

    public function getallstudentsandmarks(Request $request){

        $validator = Validator::make($request->all(),[
            'selected_class' => 'required',
            'selected_subject' => 'required',
            'selected_term' => 'required',
            'currentsession' => 'required',
            'selected_section' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['response'=>"feilds"]);
        }

        $session = $request->input('currentsession');
        $classId = $request->input('selected_class');
        $subjectbyclassid = $request->input('selected_subject');
        $schoolterm = $request->input('selected_term');
        $studentsection = $request->input('selected_section');
        
        // fetch all regno for all marks

        $a = $this->addmark_sec->where(['schoolid' => Auth::user()->schoolid, 'classid' => $classId, 'subjectid' => $subjectbyclassid, 'term' => $schoolterm, 'section' => $studentsection, 'session' => $session])->take('regno');
        
            $studentlist = DB::table('addstudent_secs')
            ->join('users', 'users.id', '=', 'addstudent_secs.usernamesystem')
            ->leftJoin('addmark_secs', function($join) use($subjectbyclassid, $schoolterm){
                $join->on('addmark_secs.regno', '=', 'addstudent_secs.id');
                $join->where(['addmark_secs.subjectid' => $subjectbyclassid, 'addmark_secs.term'=> $schoolterm]);
            })
            ->select('addstudent_secs.*', 'users.firstname', 'users.middlename', 'users.lastname', 'addmark_secs.subjectid', 'addmark_secs.exams', 'addmark_secs.grades', 'addmark_secs.totalmarks', 'addmark_secs.ca1', 'addmark_secs.ca2', 'addmark_secs.ca3', 'addmark_secs.id as markid', 'addmark_secs.position')
            ->where(['addstudent_secs.classid' => $classId, 'addstudent_secs.schoolsession' => $session, 'addstudent_secs.studentsection' => $studentsection])->get();

        return response()->json(['studentlist'=>$studentlist, 'a'=>$a], 200);
    }

    public function addmarksmiain(Request $request){

        // return $request;


        $validator = Validator::make($request->all(),[
            'classidmain' => 'required',
            'currentsessionform' => 'required',
            'currentterm' => 'required',
            'studentregno' => 'required',
            'subjectid' => 'required'
        ]);

        // return $request;

            try {
                if ($validator->fails()) {
                    return response()->json(['errors'=>$validator->errors()->keys()]);
                }
        
                
                    $checkifidexists = $request->input('markidstudent');
                    $studentId = $request->input('studentregno');
                    $examsmarks = $request->input('examsmarksentered');
                    $ca1marks = $request->input('ca1marksentered');
                    $ca2marks = $request->input('ca2marksentered');
                    $ca3marks = $request->input('ca3marksentered');
                    $attendancemarks = "NA";
                    $selectedclassidMain = $request->input('classidmain');
                    $subjectbyclassidMain = $request->input('subjectid');
                    $schooltermMain = $request->input('currentterm');
                    $studentshiftMain = "NA";
                    $studentsectionMain = $request->input('studentsection');
                    $sessionquery = $request->input('currentsessionform');

                    // return $request;
            
            
                    if ($examsmarks == 0 && $ca1marks == 0 && $ca2marks == 0 && $ca3marks == 0) {
                        $msg = "Failed";
                        
                        return response()->json(['empty' => $msg], 200);
                    }
        
                    
            
            //---------------------------------------------------------------------------------
            //                  check if result has already been entered
            //---------------------------------------------------------------------------------
                    $checkduplicate = $this->addmark_sec->where(['regno'=>$studentId, 'schoolid'=>Auth::user()->schoolid, 'classid'=>$selectedclassidMain, 'term'=>$request->input('currentterm'), 'session'=>$sessionquery, 'subjectid' => $subjectbyclassidMain])->get();
            
                    if(count($checkduplicate) > 0 && $checkifidexists == "null"){
                        $msg = "duplicate";
                        
                        return response()->json(['msg' => $msg], 200);
                    }
        
                    
            
            //--------------------------------------------------------------------------------
            //              enter grades either complete or partly the first time
            //--------------------------------------------------------------------------------
        
            
            
                    if ($checkifidexists == "null") {
        
                        
            
                            $getClassDetails = Classlist_sec::find($selectedclassidMain);
            
                            $studentgradeprocess = Addgrades_sec::where(['schoolid'=> Auth::user()->schoolid, 'type'=>$getClassDetails->classtype])->get();
        
                            
            
                            if (count($studentgradeprocess) < 5) {
                                $msg = "grades";
                        
                                return response()->json(['msg' => $msg], 200);
        
                                
                            }else{
        
        
                                
            //---------------------------------------------------------------------------------
            //                                partial result entry
            //---------------------------------------------------------------------------------
                                if ($examsmarks == 0 || $ca1marks == 0 || $ca2marks == 0 || $ca3marks == 0) {
            
                                $totalmarks = $examsmarks + $ca1marks + $ca2marks + $ca3marks;
            
                                $studentgradeprocess = Addgrades_sec::where(['schoolid'=> Auth::user()->schoolid, 'type'=>$getClassDetails->classtype])->get();
                
                                $gradeFInal = "";
                
                                for ($i=0; $i < count($studentgradeprocess); $i++) {
                                    if ($totalmarks >= $studentgradeprocess[$i]['marksfrom'] && $totalmarks<= $studentgradeprocess[$i]['marksto']) {
                                        $gradeFInal = $studentgradeprocess[$i]['gpaname'];
                                    }
                                }
                        
                                $addmarks = new Addmark_sec();
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
            
                                $getstudentposition = Addmark_sec::where(['schoolid'=>Auth::user()->schoolid, 'classid'=>$selectedclassidMain, 'term'=>$request->input('currentterm'), 'session'=>$sessionquery, 'subjectid' => $subjectbyclassidMain, 'section'=>$studentsectionMain])->orderBy('totalmarks', 'desc')->get();
            
                                $subjectscrorearray = array();
                                
            
                                for ($i=0; $i < count($getstudentposition); $i++) { 
                                    $score = $getstudentposition[$i]['totalmarks'];
                                        array_push($subjectscrorearray, $score);
                                    
                                }
            
                                for ($i=0; $i < count($getstudentposition); $i++) { 
            
                                    $mainScore = $getstudentposition[$i]['totalmarks'];
                                    $mainScoreId = $getstudentposition[$i]['id'];
            
                                    $positiongotten = array_search($mainScore, $subjectscrorearray);
            
                                    $updateposition = Addmark_sec::find($mainScoreId);
                                    $updateposition->position = $positiongotten + 1;
                                    $updateposition->save();
                                    
                                }
                        
                                $msg = "success";
                        
                                return response()->json(['success' => $msg], 200);
                                }else{
            
            //---------------------------------------------------------------------------------
            //                              enter complete result
            //---------------------------------------------------------------------------------
            
                                    $totalmarks = $examsmarks + $ca1marks + $ca2marks + $ca3marks;
            
                                    $gradeFInal = "";

                                    // return $request;
            
                                    for ($i=0; $i < count($studentgradeprocess); $i++) {
                                        if ($totalmarks >= $studentgradeprocess[$i]['marksfrom'] && $totalmarks<= $studentgradeprocess[$i]['marksto']) {
                                            $gradeFInal = $studentgradeprocess[$i]['gpaname'];
                                        }
                                    }
            
                                    $addmarks = new Addmark_sec();
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
            
            
            
                                    $getstudentposition = Addmark_sec::where(['schoolid'=>Auth::user()->schoolid, 'classid'=>$selectedclassidMain, 'session'=>$sessionquery, 'subjectid' => $subjectbyclassidMain, 'term'=>$request->input('currentterm'), 'section'=>$studentsectionMain])->orderBy('totalmarks', 'desc')->get();
            
                                    $subjectscrorearray = array();
                                    
            
                                    for ($i=0; $i < count($getstudentposition); $i++) { 
                                        $score = $getstudentposition[$i]['totalmarks'];
                                            array_push($subjectscrorearray, $score);
                                        
                                    }
            
                                    for ($i=0; $i < count($getstudentposition); $i++) { 
            
                                        $mainScore = $getstudentposition[$i]['totalmarks'];
                                        $mainScoreId = $getstudentposition[$i]['id'];
            
                                        $positiongotten = array_search($mainScore, $subjectscrorearray);
            
                                        $updateposition = Addmark_sec::find($mainScoreId);
                                        $updateposition->position = $positiongotten + 1;
                                        $updateposition->save();
                                        
                                    }
            
            
                            
                                    $msg = "success";
                            
                                    return response()->json(['success' => $msg], 200);
                                }
                                
                            }
                            
                    }else{
                        
            //----------------------------------------------------------------------------------
            //                                 updating of result
            //----------------------------------------------------------------------------------
                        
            
                        $grademarkid = $request->input('markidstudent');
            
            //---------------------------------------------------------
            //               processing patial entry
            //---------------------------------------------------------
            
                            $getClassDetails = Classlist_sec::find($selectedclassidMain);
        
                            
                            
                        if ($examsmarks == 0 || $ca1marks == 0 || $ca2marks == 0 || $ca3marks == 0) {
        
                            // return $request;
            
                            $totalmarks = $examsmarks + $ca1marks + $ca2marks + $ca3marks;

                            // return $totalmarks;
            
                            $studentgradeprocess = Addgrades_sec::where(['schoolid'=> Auth::user()->schoolid, 'type'=>$getClassDetails->classtype])->get();
            
                            $gradeFInal = "";
                            $point = 0;
            
                            for ($i=0; $i < count($studentgradeprocess); $i++) {
                                if ($totalmarks >= $studentgradeprocess[$i]['marksfrom'] && $totalmarks<= $studentgradeprocess[$i]['marksto']) {
                                    $gradeFInal = $studentgradeprocess[$i]['gpaname'];
                                    $point = $studentgradeprocess[$i]['point'] == "NA" ? 0:(int)$studentgradeprocess[$i]['point'];
                                }
                            }

                            // return $gradeFInal;
            
                            $updatestudentresult = Addmark_sec::find($grademarkid);
                            $updatestudentresult->exams = $examsmarks;
                            $updatestudentresult->ca1 = $ca1marks;
                            $updatestudentresult->ca2 = $ca2marks;
                            $updatestudentresult->ca3 = $ca3marks;
                            $updatestudentresult->totalmarks = $totalmarks;
                            $updatestudentresult->grades = $gradeFInal;
                            $updatestudentresult->points = (int)$point;
                            $updatestudentresult->save();

                            
            
                            $getstudentposition = Addmark_sec::where(['schoolid'=>Auth::user()->schoolid, 'classid'=>$selectedclassidMain, 'session'=>$sessionquery, 'subjectid' => $subjectbyclassidMain, 'term'=>$request->input('currentterm'), 'section'=>$studentsectionMain])->orderBy('totalmarks', 'desc')->get();
            
                            $subjectscrorearray = array();
                            
            
                            for ($i=0; $i < count($getstudentposition); $i++) { 
                                $score = $getstudentposition[$i]['totalmarks'];
                                    array_push($subjectscrorearray, $score);
                                
                            }
            
                            for ($i=0; $i < count($getstudentposition); $i++) { 
            
                                $mainScore = $getstudentposition[$i]['totalmarks'];
                                $mainScoreId = $getstudentposition[$i]['id'];
            
                                $positiongotten = array_search($mainScore, $subjectscrorearray);
            
                                $updateposition = Addmark_sec::find($mainScoreId);
                                $updateposition->position = $positiongotten + 1;
                                $updateposition->save();
                                
                            }
            
                            $msg = "success";
                                
                            return response()->json(['success' => $msg], 200);
            
            
                        } else {
            //-----------------------------------------------------------------
            //                     process result with grade
            //-----------------------------------------------------------------
            
                            $totalmarks = $examsmarks + $ca1marks + $ca2marks + $ca3marks;
            
                            $studentgradeprocess = Addgrades_sec::where(['schoolid'=> Auth::user()->schoolid, 'type'=>$getClassDetails->classtype])->get();
            
                            $gradeFInal = "";
                            $point = "0";
            
                            for ($i=0; $i < count($studentgradeprocess); $i++) {
                                if ($totalmarks >= $studentgradeprocess[$i]['marksfrom'] && $totalmarks<= $studentgradeprocess[$i]['marksto']) {
                                    $gradeFInal = $studentgradeprocess[$i]['gpaname'];
                                    $point = $studentgradeprocess[$i]['point'] == "NA" ? "0":$studentgradeprocess[$i]['point'];
                                }
                            }
            
                            $updatestudentresult = Addmark_sec::find($grademarkid);
                            $updatestudentresult->exams = $examsmarks;
                            $updatestudentresult->ca1 = $ca1marks;
                            $updatestudentresult->ca2 = $ca2marks;
                            $updatestudentresult->ca3 = $ca3marks;
                            $updatestudentresult->totalmarks = $totalmarks;
                            $updatestudentresult->grades = $gradeFInal;
                            $updatestudentresult->points = (int)$point;
                            $updatestudentresult->save();
            
            
                            // get student subject position
            
                            $getstudentposition = Addmark_sec::where(['schoolid'=>Auth::user()->schoolid, 'classid'=>$selectedclassidMain, 'session'=>$sessionquery, 'subjectid' => $subjectbyclassidMain, 'term'=>$request->input('currentterm'), 'section'=>$studentsectionMain])->orderBy('totalmarks', 'desc')->get();
            
                            $subjectscrorearray = array();
                            
            
                            for ($i=0; $i < count($getstudentposition); $i++) { 
                                $score = $getstudentposition[$i]['totalmarks'];
                                array_push($subjectscrorearray, $score);
                            }
            
            
            
                            for ($i=0; $i < count($getstudentposition); $i++) { 
            
                                $mainScore = $getstudentposition[$i]['totalmarks'];
                                $mainScoreId = $getstudentposition[$i]['id'];
            
                                $positiongotten = array_search($mainScore, $subjectscrorearray);
            
                                $updateposition = Addmark_sec::find($mainScoreId);
                                $updateposition->position = $positiongotten + 1;
                                $updateposition->save();
            
                            }
            
                            $msg = "success";
                                
                            return response()->json(['error' => $msg], 200);
                            
                        }
                        
                    }
            } catch (\Throwable $th) {
                //throw $th;
                return $th;
            }

            
    }

    public function processPosition(Request $request){

        // process student position
        $validator = Validator::make($request->all(),[
            'classidmarks' => 'required',
            'processterm' => 'required',
            'sessionprocessmark' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }
            
    }

    public function fetchStudentSections($id)
    {

        //$id subject id

        try {
            if (Auth::user()->role == "Teacher") {

                $getTeachersSubject = TeacherSubjects::where(['user_id'=>Auth::user()->id, 'subject_id'=>$id])->pluck('section_id')->toArray();
    
                $sectionsArray = array();
    
                for ($i=0; $i < count($getTeachersSubject); $i++) { 
    
                    $getSection = Addsection_sec::find($getTeachersSubject[$i]);
                    
                    if ($getSection != null) {
                        array_push($sectionsArray, $getSection);
                    }
                    
                }

                if (count($sectionsArray) <1) {
                    return response()->json(['schoolsection'=>'notallocatedtoyou']);
                }else{
                    return response()->json(['schoolsection'=>$sectionsArray]);
                }
    
                
            }
    
            $schoolsection = Addsection_sec::where('schoolid', Auth::user()->schoolid)->get();
    
            return response()->json(['schoolsection'=>$schoolsection]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response'=>$th]);
        }
        
    }

    public function getSchoolBasicDetails()
    {
        $schooldetails = Addpost::find(Auth::user()->schoolid);

        $classlist = Classlist_sec::where(['schoolid'=> Auth::user()->schoolid, 'status'=>1])->get();

        $subjects = Addsubject_sec::where('schoolid', Auth::user()->schoolid)->get();

        $schoolsection = Addsection_sec::where('schoolid', Auth::user()->schoolid)->get();

        $subjectScore = SubjectScoreAllocation::where('schoolid', Auth::user()->schoolid)->first();


        return response()->json(['classlist'=>$classlist, 'subjects'=>$subjects, 'schoolsection'=>$schoolsection, 'schooldetails'=>$schooldetails, 'subjectScore'=>$subjectScore]);
        
    }


}
