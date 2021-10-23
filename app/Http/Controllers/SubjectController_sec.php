<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classlist_sec;
use App\Addsubject_sec;
use App\Addmark_sec;
use App\Addpost;
use App\Addsection_sec;
use App\CLassSubjects;
use App\Electives_sec;
use App\SubjectScoreAllocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class SubjectController_sec extends Controller
{
    private $classlist_sec;
    private $addsubject_sec;
    private $addmark_sec;

    function __construct(Classlist_sec $classlist_sec, Addsubject_sec $addsubject_sec, Addmark_sec $addmark_sec)
    {
        $this->classlist_sec = $classlist_sec;
        $this->addsubject_sec = $addsubject_sec;
        $this->addmark_sec = $addmark_sec;
    }

    public function index(){ 

        $subjectAll = DB::table('addsubject_secs')
                ->join('classlist_secs', 'classlist_secs.id', '=', 'addsubject_secs.classid')
                ->select('addsubject_secs.*', 'classlist_secs.classname')
                ->where('addsubject_secs.schoolid', Auth::user()->schoolid)->get();

        $classesAll = $this->classlist_sec->where('schoolid', Auth::user()->schoolid)->get();
        $schoolDetails = Addpost::find(Auth::user()->schoolid);

        return view('secondary.subjects.viewsubjects_sec', compact('subjectAll', 'classesAll', 'schoolDetails'));
    }

    public function addsubject_sec_page()
    {

        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('secondary.subjects.addsubjectsreact', compact('schooldetails'));
    }

    public function addsubject_sec(){
        
        $classesAll = $this->classlist_sec->where(['schoolid'=> Auth::user()->schoolid, 'status'=>1])->get();

        $schoolDetails = Addpost::find(Auth::user()->schoolid);

        $allsubjects = Addsubject_sec::join('classlist_secs', 'classlist_secs.id', '=', 'addsubject_secs.classid')
                ->leftJoin('addsection_secs', 'addsection_secs.id','=','addsubject_secs.subjectsectione')
                ->select('addsubject_secs.*', 'classlist_secs.classname', 'addsection_secs.sectionname', 'addsection_secs.id as sectionid')
                ->where('addsubject_secs.schoolid', Auth::user()->schoolid)->get();

        $allSubjectmain = Addsubject_sec::where('schoolid', Auth::user()->schoolid)->get();

        $coresubjects = Addsubject_sec::where(['schoolid'=> Auth::user()->schoolid, 'subjecttype'=>'2'])->get();

        $electivesubjects = Addsubject_sec::where(['schoolid'=> Auth::user()->schoolid, 'subjecttype'=>'1'])->get();

        $schoolsection = Addsection_sec::where('schoolid', Auth::user()->schoolid)->get();

        $subjectScores = SubjectScoreAllocation::where('schoolid', Auth::user()->schoolid)->first();

        $getElectivesSettingNumber = Electives_sec::join('classlist_secs', 'classlist_secs.id','=','electives_secs.classid')
                                    ->join('addsection_secs', 'addsection_secs.id','=','electives_secs.sectionid')
                                    ->where('electives_secs.schoolid',Auth::user()->schoolid)
                                    ->select('electives_secs.*', 'addsection_secs.sectionname', 'classlist_secs.classname')->get();
        

        return response()->json(['classesAll'=>$classesAll, 'schoolDetails'=>$schoolDetails, 'allsubjects'=>$allsubjects, 'coresubjects'=>$coresubjects, 'electivesubjects'=>$electivesubjects, 'schoolsection'=>$schoolsection, 'subjectScores'=>$subjectScores, 'getElectivesSettingNumber'=>$getElectivesSettingNumber, 'allSubjectmain'=>$allSubjectmain]);
    }

    public function store(Request $request){

        try {


            // return $request;


            $schoolDetails = Addpost::find(Auth::user()->schoolid);

            
                $validator = Validator::make($request->all(),[
                    'sectionclasstype' => 'required|string',
                    'subjectname' => 'required|string',
                    // 'class_sec' => 'required|string',
                    // 'subjectsectione' => 'required|string'
                ]);

    
            if ($validator->fails()) {
                return response()->json(['response'=>'fields']);
            }

            $checkExist = Addsubject_sec::where(['schoolid'=>Auth::user()->schoolid, 'sectionclasstype'=>$request->input('sectionclasstype'), 'subjectname'=>strtoupper($request->input('subjectname'))])->get();

            if ($checkExist->count()>0) {
                return response()->json(['response'=>'duplicate']);
            }

    
            $Addsubject_sec = new Addsubject_sec();
            $Addsubject_sec->schoolid =Auth::user()->schoolid;
            // $Addsubject_sec->classid = $request->input('class_sec');
            // $Addsubject_sec->subjectcode = strtoupper($request->input('subjectcodesec'));
            $Addsubject_sec->subjectname = strtoupper($request->subjectname);
            $Addsubject_sec->sectionclasstype = $request->sectionclasstype;
            // $Addsubject_sec->subjectsectione = $request->input('subjectsectione');
            $Addsubject_sec->save();

    
            return response()->json(['response'=> "success"]);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteSubject(Request $request){

        $subjectid = $request->subjectid;
        $classid = $request->classid;
        $sectionid = $request->sectionid;
        $subjectname = $request->subjectname;
        $subjecttype = $request->subjecttype;


        
        $checkIfSubjectHasAMarkRecord = $this->addmark_sec->where(["subjectid"=>$subjectid, "schoolid"=>Auth::user()->schoolid])->get();
        
        if(count($checkIfSubjectHasAMarkRecord) > 0){
            
            return response()->json(['response'=>"Student scores already added"], 401);
            
        }


        

        DB::beginTransaction();

        try {

            DB::table('addsubject_secs')->delete($subjectid);

            DB::table('c_lass_subjects')->where('subjectid',$subjectid)->delete();

            DB::commit();
            // all good
            return response()->json(['response'=>"Subject deleted successfully"], 200);
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return response()->json(['response'=>"unknown error"], 400);
        }





        

    }

    public function editSubject_sec(Request $request){


        $subjectid_sec = $request->subjectid;
        $newclass_sec = $request->classid;
        $sectionid = $request->sectionid;
        $newsubjectname_sec = $request->subjectname;
        $subjecttype = $request->subjecttype;



        $checksubjectcode = Addsubject_sec::where(['classid'=>$newclass_sec, 'subjectname'=>$newsubjectname_sec, 'schoolid'=>Auth::user()->schoolid])->get();

        if (count($checksubjectcode) > 0) {
            return response()->json(['response'=>'Subject already exist for the selected class'], 401);
        }

        if ($newclass_sec == "") {
            return response()->json(['response'=>'Class cannot be empty'], 401);
        }else{
            
            $checkIfSubjectHasAMarkRecord = $this->addmark_sec->where(["subjectid"=>$subjectid_sec, "schoolid"=>Auth::user()->schoolid])->get();
            
            
            if(count($checkIfSubjectHasAMarkRecord) > 0){
            
                return response()->json(['response'=>"subject cannot be asigned to a new class because sudent record has been added..."], 401);
            
            }
            
            $updatesubject_sec = $this->addsubject_sec->find($subjectid_sec);
            $updatesubject_sec->classid = $newclass_sec;
            $updatesubject_sec->subjectname = $newsubjectname_sec;
            $updatesubject_sec->subjecttype = $subjecttype;
            $updatesubject_sec->subjectsectione = $sectionid;
            $updatesubject_sec->save();

            return response()->json(['response', 'Subject updated successfully'], 200);
        }


        

    }

    public function addSubjectScore(Request $request)
    {

        try {

            $sumScoreCheck = (int)$request->examsfull + (int)$request->ca1full + (int)$request->ca2full + (int)$request->ca3full;

            if ($sumScoreCheck > 100 || $sumScoreCheck < 1) {
                return response()->json(['response'=>'invalid']);
            }

            $checkIfHasBeenENteredThenUpdate = SubjectScoreAllocation::where('schoolid', Auth::user()->schoolid)->first();

            if ($checkIfHasBeenENteredThenUpdate == null) {
                $AddSubjectScore = new SubjectScoreAllocation();
                $AddSubjectScore->examsfull = $request->examsfull;
                $AddSubjectScore->ca1full = $request->ca1full;
                $AddSubjectScore->ca2full = $request->ca2full;
                $AddSubjectScore->ca3full = $request->ca3full;
                $AddSubjectScore->schoolid = Auth::user()->schoolid;
                $AddSubjectScore->save();
    
                return response()->json(['response'=>'success']);
            }else{
                $checkIfHasBeenENteredThenUpdate->examsfull = $request->examsfull;
                $checkIfHasBeenENteredThenUpdate->ca1full = $request->ca1full;
                $checkIfHasBeenENteredThenUpdate->ca2full = $request->ca2full;
                $checkIfHasBeenENteredThenUpdate->ca3full = $request->ca3full;
                $checkIfHasBeenENteredThenUpdate->save();
    
                return response()->json(['response'=>'success']);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response'=>$th]);
        }
    }

    public function addNumberOfEllectives(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'classid' => 'required',
            'sectionid' => 'required',
            'number_ellectives' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['response'=>'fields']);
        }

        try {

            if ($request->number_ellectives < 1) {
                return response()->json(['response'=>'error']);
            }

            $checkIfAddedAlready = Electives_sec::where(['classid'=>$request->classid, 'sectionid'=>$request->sectionid])->first();

            if ($checkIfAddedAlready == null) {

                $addElectivesEachClass = new Electives_sec();
                $addElectivesEachClass->classid = $request->classid;
                $addElectivesEachClass->sectionid = $request->sectionid;
                $addElectivesEachClass->number_ellectives = $request->number_ellectives;
                $addElectivesEachClass->schoolid = Auth::user()->schoolid;
                $addElectivesEachClass->save();
        
                return response()->json(['response'=>'success']);
            }else{

                $checkIfAddedAlready->number_ellectives = $request->number_ellectives;
                $checkIfAddedAlready->save();
        
                return response()->json(['response'=>'updated']);
            }


        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response'=>'error']);
        }
    }

    public function asignSubjectToClass(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'classid' => 'required',
            'sectionid' => 'required',
            'subjectid' => 'required',
            'subjecttype' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['response'=>'fields']);
        }

        $classSubject = CLassSubjects::where(['classid'=>$request->classid, 'sectionid'=>$request->sectionid, 'subjectid'=>$request->subjectid])->get();

        if (count($classSubject) > 0) {
            return response()->json(['response'=>'already']);
        }


        $asignSubjects = new CLassSubjects();
        $asignSubjects->classid = $request->classid;
        $asignSubjects->sectionid = $request->sectionid;
        $asignSubjects->subjectid = $request->subjectid;
        $asignSubjects->schoolid = Auth::user()->schoolid;
        $asignSubjects->subjecttype = $request->subjecttype;
        $asignSubjects->save();


        return response()->json(['response'=>'success']);
    }

    public function getClassForSubject($subjectid)
    {
        $getClass = CLassSubjects::join('classlist_secs', 'classlist_secs.id','=','c_lass_subjects.classid')
                    ->join('addsection_secs', 'addsection_secs.id','=','c_lass_subjects.sectionid')
                    ->where('subjectid', $subjectid)
                    ->select('c_lass_subjects.*', 'classlist_secs.classname', 'addsection_secs.sectionname')->get();

        return response()->json(['response'=>$getClass]);
        
    }

    public function deleteClassForSubject($subjectidAlloc)
    {

        try {
            $getClassSubject = CLassSubjects::find($subjectidAlloc);

            $deleteAddedMarks = Addmark_sec::where(['classid'=>$getClassSubject->classid, 'section'=>$getClassSubject->sectionid, 'subjectid'=>$getClassSubject->subjectid])->delete();

            // Addmark_sec::destroy($deleteAddedMarks);

            $getClassSubject->delete();

            return response()->json(['response'=>"success"]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response'=>$th]);
        }


        
    }
}
