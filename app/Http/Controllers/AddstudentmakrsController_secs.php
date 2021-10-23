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
use App\ElectiveAdd;
use App\Repository\Result\GetSubjectPosition;
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

        try {
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
    
           $checksubjecttype = CLassSubjects::where(['subjectid'=>$subjectbyclassid, 'classid'=>$classId, 'sectionid'=>$studentsection])->first();
    
            if($checksubjecttype->subjecttype == 2){
    
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
    
            }else{

                $a = $this->addmark_sec->where(['schoolid' => Auth::user()->schoolid, 'classid' => $classId, 'subjectid' => $subjectbyclassid, 'term' => $schoolterm, 'section' => $studentsection, 'session' => $session])->take('regno');
            
                $studentlist = Addstudent_sec::
                join('users', 'users.id', '=', 'addstudent_secs.usernamesystem')
                ->leftJoin('addmark_secs', function($join) use($subjectbyclassid, $schoolterm){
                    $join->on('addmark_secs.regno', '=', 'addstudent_secs.id');
                    $join->where(['addmark_secs.subjectid' => $subjectbyclassid, 'addmark_secs.term'=> $schoolterm]);
                })
                ->select('addstudent_secs.*', 'users.firstname', 'users.middlename', 'users.lastname', 'addmark_secs.subjectid', 'addmark_secs.exams', 'addmark_secs.grades', 'addmark_secs.totalmarks', 'addmark_secs.ca1', 'addmark_secs.ca2', 'addmark_secs.ca3', 'addmark_secs.id as markid', 'addmark_secs.position')
                ->where(['addstudent_secs.classid' => $classId, 'addstudent_secs.schoolsession' => $session, 'addstudent_secs.studentsection' => $studentsection])->get();

                $mainList = array();

                $checkElective = ElectiveAdd::where(['classid'=>$classId, 'sectionid'=>$studentsection, 'subjectid'=>$subjectbyclassid])->pluck('regno')->toArray();

                for ($i=0; $i < count($studentlist); $i++) { 

                    if (in_array($studentlist[$i]['id'], $checkElective)) {
                        array_push($mainList, $studentlist[$i]);
                    }
                    
                }
    
                return response()->json(['studentlist'=>collect($mainList), 'a'=>$a], 200);



            }


        } catch (\Throwable $th) {
            // return response()->json(['error'=>$th]);
            return $th;
        }


    }

    public function addmarksmiain(GetSubjectPosition $getSubjectPosition, Request $request){

        $validator = Validator::make($request->all(),[
            'classidmain' => 'required',
            'currentsessionform' => 'required',
            'currentterm' => 'required',
            'studentregno' => 'required',
            'subjectid' => 'required'
        ]);

            try {
                if ($validator->fails()) {
                    return response()->json(['errors'=>$validator->errors()->keys()]);
                }
                $getSubjectPosition->addResultMain($request);
                
                return response()->json(['success' => "success"], 200);

            } catch (\Throwable $th) {
                //throw $th;
                return $th;
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
