<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Addpost;
use App\Classlist_sec;
use App\Addhouse_sec;
use App\Addsection_sec;
use App\Addclub_sec;
use App\Addgrades_sec;
use App\Addstudent_sec;
use App\Addstudent;
use App\AssesmentModel;
use App\Repository\Schoolsetup\SchoolSetup as SchoolsetupSchoolSetup;
use App\SubAssesmentModel;
use App\SubHistory;
use Illuminate\Support\Facades\Auth;
use SchoolSetup;

class SchoolsetupSecController extends Controller
{
    public function index(){

        $schoolId = Auth::user()->schoolid;

        $addschool = Addpost::where('id', $schoolId)->get();
        
        if($addschool[0]->schooltype == "Primary"){
            
            $getStudentCount = Addstudent::where(['sessionstatus'=> '1', 'schoolid'=>Auth::user()->schoolid])->get();
            
            $subHistory = SubHistory::where(['schoolid'=> Auth::user()->schoolid, 'session'=>$addschool[0]->schoolsession])->sum('student_count');
    
            $alldetails = array(
                'addschool' => $addschool,
                "getStudentCount"=>$getStudentCount,
                "subHistory"=>$subHistory
            );
    
            // return $alldetails['getStudentCount'];
    
            return view('secondary.setupschool.schoolsetup')->with('alldetails', $alldetails);
            
        }else{
            
            $getStudentCount = Addstudent_sec::where(['sessionstatus'=> '0', 'schoolid'=>Auth::user()->schoolid])->get();
            $subHistory = SubHistory::where(['schoolid'=> Auth::user()->schoolid, 'session'=>$addschool[0]->schoolsession])->sum('student_count');
            $classlist_sec = Classlist_sec::where('schoolid', Auth::user()->schoolid)->get();
    
            $alldetails = array(
                'addschool' => $addschool,
                "getStudentCount"=>$getStudentCount,
                "subHistory"=>$subHistory,
                "classlist_sec"=>$classlist_sec
            );
    
            // return $alldetails['getStudentCount'];
    
            return view('secondary.setupschool.schoolsetup')->with('alldetails', $alldetails);
        }
        
        
    }
    
    public function update_term(Request $request)
    {
        $updateterm = Addpost::find(Auth::user()->schoolid);
        $updateterm->term = $request->term;
        $updateterm->save();

        return response()->json(array('sucess' => 'success'), 200);
    }

    public function grades_sec(){

        $addgrades = Addgrades_sec::where('schoolid', Auth::user()->schoolid)->get();

        // return $addgrades;
        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('secondary.gradessec', compact('schooldetails', 'addgrades'));
    }

    public function delete_grades_sec(Request $request)
    {

        if ($request->key == "edit") {

            $check1 = Addgrades_sec::where(['gpaname'=>$request->gpaname, 'marksfrom'=>$request->marksfrom, 'marksto'=>$request->marksto])->get();

            $check2 = Addgrades_sec::where(['gpaname'=>$request->gpaname, 'marksfrom'=>$request->marksto, 'marksto'=>$request->marksfrom])->get();

            if ($check1->count() > 0 || $check2->count() > 0) {
                return back()->with('error', 'record cannot be same');
            }

            $editRecord = Addgrades_sec::find($request->gradeid);
            $editRecord->gpaname = $request->gpaname;
            $editRecord->marksfrom = $request->marksfrom;
            $editRecord->marksto = $editRecord->marksto;
            $editRecord->save();

            return back()->with('success', 'Update was successfull');
            
        }else{

            $deleteRequest = Addgrades_sec::find($request->gradetodelete);
            $deleteRequest->delete();
    
            return back()->with("success", "Process was successfull");

        }


    }

    public function addSchoolInitials(Request $request){

        $schoolinitialsinput = $request->input('schoolinitialsinput');

        if (empty($schoolinitialsinput)) {
            $msg = 0;
            return response()->json(array('msg' => $msg), 200);
        }

        $schoolId = Auth::user()->schoolid;

        $updateSchoolInitials = Addpost::find($schoolId);
        $updateSchoolInitials->shoolinitial = $schoolinitialsinput;
        $updateSchoolInitials->save();

        $msg = 1;
        return response()->json(array('msg' => $msg), 200);
    }

    public function addSchoolSession(Request $request){

        $schoolsessioninput = $request->session;

        if (empty($schoolsessioninput)) {
            $msg = 0;
            return response()->json(array('msg' => $msg), 200);
        }

        $explodedSession = explode("/", $schoolsessioninput);

        if (count($explodedSession) < 2) {
            $msg = 0;
            return response()->json(array('msg' => $msg), 200);
        }

        $schoolId = Auth::user()->schoolid;

        $updateSchoolSession = Addpost::find($schoolId);
        $updateSchoolSession->schoolsession = $request->session;
        $updateSchoolSession->firsttermstarts = $request->firsttermstarts;
        $updateSchoolSession->firsttermends = $request->firsttermends;
        $updateSchoolSession->secondtermstarts = $request->secondtermstarts;
        $updateSchoolSession->secondtermends = $request->secondtermends;
        $updateSchoolSession->thirdtermstarts = $request->thirdtermstarts;
        $updateSchoolSession->thirdtermends = $request->thirdtermends;
        $updateSchoolSession->save();

        $msg = 1;
        return response()->json(array('msg' => $msg), 200);

    }

    public function addClasses(SchoolsetupSchoolSetup $schoolSetup, Request $request){
        
        try {
           return $query = $schoolSetup->setupClasses($request);
            if($query == "success"){
                return back()->with('success', 'process was successfull');
            }
        } catch (\Throwable $th) {
            return back()->with('error', 'error');
        }

    }

    public function disableClass($id)
    {
        
        try {
            $classlist = Classlist_sec::find($id);

            if ($classlist->status == 0) {
                $classlist->status = 1;
                $classlist->save();
                return response()->json(['response'=>"success"]);
            }else{
                $classlist->status = 0;
                $classlist->save();
                return response()->json(['response'=>"success"]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
            return response()->json(['response'=>"error"]);
        }

    }

    public function addhouses_sec(Request $request){

        $addhouses_input = $request->input('addhouses_input');

        if (empty($addhouses_input)) {
            $msg = 0;
            return response()->json(array('msg' => $msg), 200);
        }

        $addhouses_sec_explode = explode(',', $addhouses_input);

        for ($i=0; $i < count($addhouses_sec_explode); $i++) { 

            $houselistCheck = Addhouse_sec::where('housename', $addhouses_sec_explode[$i])->get();

            if (count($houselistCheck) < 1) {
                $addhouses_sec = new Addhouse_sec();
                $addhouses_sec->schoolid = Auth::user()->schoolid;
                $addhouses_sec->housename = strtoupper($addhouses_sec_explode[$i]);
                $addhouses_sec->save();
            }
        }

        $msg = 1;
        return response()->json(array('msg' => $msg), 200);
    }

    public function addsection_sec(Request $request){

        $addsection_input = $request->input('addsection_input');

        if (empty($addsection_input)) {
            $msg = 0;
            return response()->json(array('msg' => $msg), 200);
        }

        $addsection_sec_explode = explode(',', $addsection_input);

        for ($i=0; $i < count($addsection_sec_explode); $i++) { 

            $sectionlistCheck = Addsection_sec::where(['sectionname' => $addsection_sec_explode[$i], 'schoolid' => Auth::user()->shoolid])->get();

            if (count($sectionlistCheck) < 1) {
                $addsection_sec = new Addsection_sec();
                $addsection_sec->schoolid = Auth::user()->schoolid;
                $addsection_sec->sectionname = strtoupper($addsection_sec_explode[$i]);
                $addsection_sec->save();
            }
        }

        $msg = 1;
        return response()->json(array('msg' => $msg), 200);
    }

    public function addclub_sec(Request $request){

        $addclub_input = $request->input('addclub_input');

        if (empty($addclub_input)) {
            $msg = 0;
            return response()->json(array('msg' => $msg), 200);
        }

        $addclub_sec_explode = explode(',', $addclub_input);

        for ($i=0; $i < count($addclub_sec_explode); $i++) { 

            $clublistCheck = Addclub_sec::where('clubname', $addclub_sec_explode[$i])->get();

            if (count($clublistCheck) < 1) {
                $addclub_sec = new Addclub_sec();
                $addclub_sec->schoolid = Auth::user()->schoolid;
                $addclub_sec->clubname = strtoupper($addclub_sec_explode[$i]);
                $addclub_sec->save();
            }
        }

        $msg = 1;
        return response()->json(array('msg' => $msg), 200);
    }

    public function updatecaSet(Request $request)
    {

        if($request->caoption == "on"){
            $addcaoption = Addpost::find(Auth::user()->schoolid);
            $addcaoption->caset = 1;
            $addcaoption->save();
            return back()->with('success', 'CA3 enabled');

        }else{
            $addcaoption = Addpost::find(Auth::user()->schoolid);
            $addcaoption->caset = 0;
            $addcaoption->save();
            return back()->with('success', 'CA3 disabled');
        }
        
    }

    public function updateExamsStatus(Request $request)
    {
        $schoolDetails = Addpost::find(Auth::user()->schoolid);
        $schoolDetails->exams = $request->examsstatus;
        $schoolDetails->save();

        return response()->json(['success'=>'success']);
    }

    public function updateCa1Status(Request $request)
    {
        $schoolDetails = Addpost::find(Auth::user()->schoolid);
        $schoolDetails->ca1 = $request->ca1status;
        $schoolDetails->save();

        return response()->json(['success'=>'success']);
    }

    public function updateCa2Status(Request $request)
    {
        $schoolDetails = Addpost::find(Auth::user()->schoolid);
        $schoolDetails->ca2 = $request->ca2status;
        $schoolDetails->save();

        return response()->json(['success'=>'success']);
    }

    public function updateCa3Status(Request $request)
    {
        $schoolDetails = Addpost::find(Auth::user()->schoolid);
        $schoolDetails->ca3 = $request->ca3status;
        $schoolDetails->save();

        return response()->json(['success'=>'success']);
    }

    public function fetchSchoolDetailsSetUp()
    {
        $schoolDetails = Addpost::where('id', Auth::user()->schoolid)->first();

        $classlist = Classlist_sec::where("schoolid", Auth::user()->schoolid)->get();

        $houselist = Addhouse_sec::where("schoolid", Auth::user()->schoolid)->get();

        $classsection = Addsection_sec::where("schoolid", Auth::user()->schoolid)->get();

        $clubs = Addclub_sec::where("schoolid", Auth::user()->schoolid)->get();

        $assessment = AssesmentModel::where("schoolid", Auth::user()->schoolid)->get();

        $subasscategory = SubAssesmentModel::join('assesment_models', 'assesment_models.id','=','sub_assesment_models.catid')
                         ->where('sub_assesment_models.schoolid', Auth::user()->schoolid)
                         ->select('sub_assesment_models.*', 'assesment_models.name')->get();

        return response()->json(['schoolDetails'=>$schoolDetails, 'classlist'=>$classlist, 'houselist'=>$houselist, 'classsection'=>$classsection, 'clubs'=>$clubs, 'assessment'=>$assessment, 'subasscategory'=>$subasscategory]);
    }

    public function setup_school_sec()
    {
        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('secondary.setupschool.schoolsetupreact', compact('schooldetails'));
        
    }

    public function setUpAssesment(Request $request)
    {
        try { 

            $checkMarksEntered = AssesmentModel::where('schoolid', Auth::user()->schoolid)->sum('maxmark');

            if (($checkMarksEntered + $request->maxmarks) <= 100) {
                
                $addAssessmentCat = AssesmentModel::updateOrCreate(
                    ['name'=>$request->name],
                    ['name'=>$request->name, 'maxmark'=>$request->maxmarks, 'schoolid'=>Auth::user()->schoolid, 'status'=>true]
                );

            }

            return response()->json(['response'=>'success'], 200);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response'=>'error'], 402);
        }

    }

    public function subAssessmentSetUp(Request $request)
    {
        try {

            $assessmentCatId = AssesmentModel::find($request->catid);
            $getAllMarksInCategory = SubAssesmentModel::where('catid', $request->catid)->sum('maxmarks');
            if (($getAllMarksInCategory + $request->submaxmarks) <= $assessmentCatId->maxmark) {
                
                $addAssessmentCat = SubAssesmentModel::updateOrCreate(
                    ['subname'=>$request->subname],
                    ['subname'=>$request->subname, 'catid'=>$request->catid, 'maxmarks'=>$request->submaxmarks, 'schoolid'=>Auth::user()->schoolid, 'status'=>true]
                );

            }

            return response()->json(['response'=>'success'], 200);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response'=>$th], 400);
        }
    }
}
