<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classlist_sec;
use App\Addsubject_sec;
use App\Addmark_sec;
use App\Addpost;
use App\Addsection_sec;
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
                ->select('addsubject_secs.*', 'classlist_secs.classname', 'addsection_secs.sectionname')
                ->where('addsubject_secs.schoolid', Auth::user()->schoolid)->get();

        $coresubjects = Addsubject_sec::where(['schoolid'=> Auth::user()->schoolid, 'subjecttype'=>'2'])->get();

        $electivesubjects = Addsubject_sec::where(['schoolid'=> Auth::user()->schoolid, 'subjecttype'=>'1'])->get();

        $schoolsection = Addsection_sec::where('schoolid', Auth::user()->schoolid)->get();

        $subjectScores = SubjectScoreAllocation::where('schoolid', Auth::user()->schoolid)->first();

        $getElectivesSettingNumber = Electives_sec::join('classlist_secs', 'classlist_secs.id','=','electives_secs.classid')
                                    ->join('addsection_secs', 'addsection_secs.id','=','electives_secs.sectionid')
                                    ->where('electives_secs.schoolid',Auth::user()->schoolid)
                                    ->select('electives_secs.*', 'addsection_secs.sectionname', 'classlist_secs.classname')->get();
        

        return response()->json(['classesAll'=>$classesAll, 'schoolDetails'=>$schoolDetails, 'allsubjects'=>$allsubjects, 'coresubjects'=>$coresubjects, 'electivesubjects'=>$electivesubjects, 'schoolsection'=>$schoolsection, 'subjectScores'=>$subjectScores, 'getElectivesSettingNumber'=>$getElectivesSettingNumber]);
    }

    public function store(Request $request){

        try {

            $schoolDetails = Addpost::find(Auth::user()->schoolid);

            
                $validator = Validator::make($request->all(),[
                    'subjecttype_sec' => 'required|string',
                    'subjectnamesec' => 'required|string',
                    'class_sec' => 'required|string',
                    'subjectsectione' => 'required|string'
                ]);

    
            if ($validator->fails()) {
                return response()->json(['response'=>'fields']);
            }

            $checkExist = Addsubject_sec::where(['schoolid'=>Auth::user()->schoolid, 'subjectsectione'=>$request->input('subjectsectione'), 'classid'=>$request->input('class_sec'), 'subjectname'=>strtoupper($request->input('subjectnamesec')), 'subjecttype' => $request->subjecttype_sec])->get();

            if ($checkExist->count()>0) {
                return response()->json(['response'=>'duplicate']);
            }

    
            $Addsubject_sec = new Addsubject_sec();
            $Addsubject_sec->schoolid =Auth::user()->schoolid;
            $Addsubject_sec->classid = $request->input('class_sec');
            $Addsubject_sec->subjectcode = strtoupper($request->input('subjectcodesec'));
            $Addsubject_sec->subjectname = strtoupper($request->input('subjectnamesec'));
            $Addsubject_sec->subjecttype = $request->input('subjecttype_sec');
            $Addsubject_sec->subjectsectione = $request->input('subjectsectione');
            $Addsubject_sec->save();

    
            return response()->json(['response'=> "success"]);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteSubject(Request $request){

        $subjectId = $request->input('subjectid_sec');
        
        $checkIfSubjectHasAMarkRecord = $this->addmark_sec->where(["subjectid"=>$subjectId, "schoolid"=>Auth::user()->schoolid])->get();
        
        if(count($checkIfSubjectHasAMarkRecord) > 0){
            
            return back()->with("error", "subject cannot be deleted because students record for the subject has been added...");
            
        }

        $deletesubject = $this->addsubject_sec->find($subjectId);
        $deletesubject->delete();
        return back()->with('success', 'subject deleted successfully');

    }

    public function editSubject_sec(Request $request){

        
        $newclass_sec = $request->input('newclass_sec');
        $newsubjectname_sec = $request->input('newsubjectname_sec');
        $newsubjectcode_sec = $request->input('newsubjectcode_sec');
        $subjectid_sec = $request->input('subjectid_sec');

        $checksubjectcode = Addsubject_sec::where(['subjectcode'=> $newsubjectcode_sec, 'schoolid'=>Auth::user()->schoolid])->get();

        if (count($checksubjectcode) > 0) {
            return back()->with("error", "Subject code already exist");
        }

        if ($newclass_sec == "") {
            $updatesubject_sec = $this->addsubject_sec->find($subjectid_sec);
            $updatesubject_sec->subjectname = $newsubjectname_sec;
            $updatesubject_sec->subjectcode = $newsubjectcode_sec;
            $updatesubject_sec->save();
        }else{
            
            $checkIfSubjectHasAMarkRecord = $this->addmark_sec->where(["subjectid"=>$subjectid_sec, "schoolid"=>Auth::user()->schoolid])->get();
            
            
            if(count($checkIfSubjectHasAMarkRecord) > 0){
            
                return back()->with("error", "subject cannot be asigned to a new class because sudent record has been added...");
            
            }
            
            $updatesubject_sec = $this->addsubject_sec->find($subjectid_sec);
            $updatesubject_sec->classid = $newclass_sec;
            $updatesubject_sec->subjectname = $newsubjectname_sec;
            $updatesubject_sec->subjectcode = $newsubjectcode_sec;
            $updatesubject_sec->save();
        }


        return back()->with("success", "Subject updated successfully");

    }

    public function addSubjectScore(Request $request)
    {

        try {
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
}
