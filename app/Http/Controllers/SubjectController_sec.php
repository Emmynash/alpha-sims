<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classlist_sec;
use App\Addsubject_sec;
use App\Addmark_sec;
use App\Addpost;
use App\Addsection_sec;
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

    public function addsubject_sec(){
        
        $classesAll = $this->classlist_sec->where('schoolid', Auth::user()->schoolid)->get();

        $schoolDetails = Addpost::find(Auth::user()->schoolid);

        $allsubjects = Addsubject_sec::join('classlist_secs', 'classlist_secs.id', '=', 'addsubject_secs.classid')
                ->leftJoin('addsection_secs', 'addsection_secs.id','=','addsubject_secs.subjectsectione')
                ->select('addsubject_secs.*', 'classlist_secs.classname', 'addsection_secs.sectionname')
                ->where('addsubject_secs.schoolid', Auth::user()->schoolid)->get();

        $coresubjects = Addsubject_sec::where(['schoolid'=> Auth::user()->schoolid, 'subjecttype'=>'2'])->get();

        $electivesubjects = Addsubject_sec::where(['schoolid'=> Auth::user()->schoolid, 'subjecttype'=>'1'])->get();

        $schoolsection = Addsection_sec::where('schoolid', Auth::user()->schoolid)->get();
        

        return response()->json(['classesAll'=>$classesAll, 'schoolDetails'=>$schoolDetails, 'allsubjects'=>$allsubjects, 'coresubjects'=>$coresubjects, 'electivesubjects'=>$electivesubjects, 'schoolsection'=>$schoolsection]);
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

            $checkExist = Addsubject_sec::where(['schoolid'=>Auth::user()->schoolid, 'classid'=>$request->input('class_sec'), 'subjectname'=>strtoupper($request->input('subjectnamesec')), 'subjecttype' => $request->subjecttype_sec])->get();

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
}
