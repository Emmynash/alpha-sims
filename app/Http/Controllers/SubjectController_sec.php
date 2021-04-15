<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classlist_sec;
use App\Addsubject_sec;
use App\Addmark_sec;
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

        return view('secondary.subjects.viewsubjects_sec', compact('subjectAll', 'classesAll'));
    }

    public function addsubject_sec(){
        
        $classesAll = $this->classlist_sec->where('schoolid', Auth::user()->schoolid)->get();

        return view('secondary.subjects.addsubject', compact('classesAll'));
    }

    public function store(Request $request){

        try {
            $validator = Validator::make($request->all(),[
                'ca1marks_sec' => 'required|max:7|min:3|string',
                'ca2marks_sec' => 'required|max:7|min:3|string',
                'ca3marks_sec' => 'required|max:7|min:3|string',
                'class_sec' => 'required|string',
                'examsmark_sec' => 'required|max:7|min:3|string',
                'fullmarkpassmark_sec' => 'required|max:7|min:3|string',
                'gradesystem_sec' => 'required|string',
                'subjectcodesec' => 'required|string',
                'subjectnamesec' => 'required|string',
                'subjecttype_sec' => 'required|string'
            ]);
    
    
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()->keys()]);
            }
    
            $formInputNames = array("ca1marks_sec", "ca2marks_sec", "ca3marks_sec", "examsmark_sec", "fullmarkpassmark_sec");
    
                $withissues = array();
    
            for ($i=0; $i < count($formInputNames); $i++) { 
    
                $mainValues = trim($request->input($formInputNames[$i]));
                
                $explodevalue = explode(",", $mainValues);
    
                if (count($explodevalue) < 2 || $explodevalue[1] == "") {
                    array_push($withissues, $formInputNames[$i]);
                }
            }
    
    
            if (count($withissues) > 0) {
                return response()->json(['errors'=>$withissues]);
            }
    
            $addsubjectCheck = $this->addsubject_sec->where(['subjectcode'=> $request->input('subjectcodesec'), 'schoolid'=>Auth::user()->schoolid])->get();
    
            if (count($addsubjectCheck) > 0) {
                return response()->json(['duplicate'=>"yes"]);
            }
    
            $ca1marks_sec = $request->input('ca1marks_sec');
            $ca1marks_secexplode = explode(',', $ca1marks_sec);
            $ca1marks_sec_finalfull = $ca1marks_secexplode[0];
            $ca1marks_sec_passmark = $ca1marks_secexplode[1];
    
            $ca2marks_sec = $request->input('ca2marks_sec');
            $ca2marks_secexplode = explode(',', $ca2marks_sec);
            $ca2marks_sec_finalfull = $ca2marks_secexplode[0];
            $ca2marks_sec_passmark = $ca2marks_secexplode[1];
    
            $ca3marks_sec = $request->input('ca3marks_sec');
            $ca3marks_secexplode = explode(',', $ca3marks_sec);
            $ca3marks_sec_finalfull = $ca3marks_secexplode[0];
            $ca3marks_sec_passmark = $ca3marks_secexplode[1];
    
            $examsmark_sec = $request->input('examsmark_sec');
            $examsmark_secexplode = explode(',', $examsmark_sec);
            $examsmark_sec_finalfull = $examsmark_secexplode[0];
            $examsmark_sec_passmark = $examsmark_secexplode[1];
    
            $fullmarkpassmark_sec = $request->input('fullmarkpassmark_sec');
            $fullmarkpassmark_secexplode = explode(',', $fullmarkpassmark_sec);
            $fullmarkpassmark_sec_finalfull = $fullmarkpassmark_secexplode[0];
            $fullmarkpassmark_sec_passmark = $fullmarkpassmark_secexplode[1];
    
            $Addsubject_sec = new Addsubject_sec();
            $Addsubject_sec->schoolid =Auth::user()->schoolid;
            $Addsubject_sec->classid = $request->input('class_sec');
            $Addsubject_sec->subjectcode = strtoupper($request->input('subjectcodesec'));
            $Addsubject_sec->subjectname = strtoupper($request->input('subjectnamesec'));
            $Addsubject_sec->subjecttype = $request->input('subjecttype_sec');
            $Addsubject_sec->gradesystem = $request->input('gradesystem_sec');
            $Addsubject_sec->totalfull = $fullmarkpassmark_sec_finalfull;
            $Addsubject_sec->totalpass = $fullmarkpassmark_sec_passmark;
            $Addsubject_sec->examfull = $examsmark_sec_finalfull;
            $Addsubject_sec->exampass = $examsmark_sec_passmark;
            $Addsubject_sec->ca1full = $ca1marks_sec_finalfull;
            $Addsubject_sec->ca1pass = $ca1marks_sec_passmark;
            $Addsubject_sec->ca2full = $ca2marks_sec_finalfull;
            $Addsubject_sec->ca2pass = $ca2marks_sec_passmark;
            $Addsubject_sec->ca3full = $ca3marks_sec_finalfull;
            $Addsubject_sec->ca3pass = $ca3marks_sec_passmark;
            $Addsubject_sec->save();
    
            return response()->json(['success'=> "success"]);
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
