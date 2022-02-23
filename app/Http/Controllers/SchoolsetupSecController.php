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
use App\CommentsModel;
use App\CommentTable;
use App\Repository\Schoolsetup\SchoolSetup as SchoolsetupSchoolSetup;
use App\SubAssesmentModel;
use App\SubHistory;
use Egulias\EmailValidator\Warning\Comment;
use GuzzleHttp\Promise\Create;
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
        $updateSchoolSession->secondtermbegins = $request->secondtermstarts;
        $updateSchoolSession->secondtermends = $request->secondtermends;
        $updateSchoolSession->thirdtermbegins = $request->thirdtermstarts;
        $updateSchoolSession->thirdtermends = $request->thirdtermends;
        $updateSchoolSession->save();

        $msg = 1;
        return response()->json(array('msg' => $msg), 200);

    }

    public function addClasses(SchoolsetupSchoolSetup $schoolSetup, Request $request){

        try {
           $query = $schoolSetup->setupClasses($request);
           return response()->json(array('msg' => 'Process successful', 'code'=>200), 200);
            if($query == "success"){
                return response()->json(array('msg' => 'Class added successfully', 'code'=>200), 200);
            }else if($query == "unsuccessful"){
                return response()->json(array('msg' => 'Class could not be added', 'code'=>401), 200);
            }else{
                return response()->json(array('msg' => 'Invalid request. Please referr to the users manual', 'code'=>409), 200);
            }
        } catch (\Throwable $th) {
            return back()->with('error', 'error');
        }

    }

    public function disableClass($id)
    {
        
        try {
            $classlist = Classlist_sec::find($id);

            //check if there students in the class

            $studentcountcheck = Addstudent_sec::where('classid', $id)->get();

            if(count($studentcountcheck) > 0){
                return response()->json(['msg'=>"Class cannot be deleted. Student exist in class", 'code'=>401], 200);
            }

            $classlist->delete();
                return response()->json(['msg'=>"class deleted successfully", 'code'=>200], 200);
        } catch (\Throwable $th) {
            //throw $th;
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

    public function fetchSchoolDetailsSetUp()
    {
        $schoolDetails = Addpost::where('id', Auth::user()->schoolid)->first();

        $classlist = Classlist_sec::where("schoolid", Auth::user()->schoolid)->orderBy('index', 'asc')->get();

        $houselist = Addhouse_sec::where("schoolid", Auth::user()->schoolid)->get();

        $classsection = Addsection_sec::where("schoolid", Auth::user()->schoolid)->get();

        $clubs = Addclub_sec::where("schoolid", Auth::user()->schoolid)->get();

        $assessment = AssesmentModel::where("schoolid", Auth::user()->schoolid)->orderBy('order', 'asc')->get();

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
                    ['name'=>$request->name, 'maxmark'=>$request->maxmarks, 'order'=>$request->order, 'schoolid'=>Auth::user()->schoolid, 'status'=>true]
                );

                return response()->json(['response'=>'success', 'code'=>200], 200);
            }else{
                return response()->json(['response'=>'Sum of marks must not be above 100', 'code'=>400], 200);
            }

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response'=>'error'], 402);
        }

    }

    public function updateAssessmentOrder(Request $request)
    {
        try {
            $sourceId = $request->sourceId;

            $destinationId = $request->destinationId;

            $source = '';
            $destination = '';

            $getSourceAssessment = AssesmentModel::find($sourceId);
            $source = $getSourceAssessment->order;

            $getDestinationAssessment = AssesmentModel::find($destinationId);
            $destination = $getDestinationAssessment->order;

            $getSourceAssessment->order = $destination;
            $getSourceAssessment->save();

            $getDestinationAssessment->order = $source;
            $getDestinationAssessment->save();

            return response()->json(['response'=>'success']);
            
        } catch (\Throwable $th) {
            //throw $th;


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
                return response()->json(['response'=>'success', 'code'=>200], 200);
            }else{
                return response()->json(['response'=>'Out of range', 'code'=>400], 200);
            }

            

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response'=>$th], 400);
        }
    }


    public function setupComment()
    {
        $schooldetails = Addpost::find(Auth::user()->schoolid);
        $comments = CommentTable::where('schoolid', Auth::user()->schoolid)->get();

        return view('secondary.comment.commentsetup', compact('schooldetails', 'comments'));
    }

    public function adminComment()
    {
        $schooldetails = Addpost::find(Auth::user()->schoolid);
        $comments = CommentTable::where('schoolid', Auth::user()->schoolid)->get();

        return view('secondary.comment.admincomment', compact('schooldetails', 'comments'));
    }

    public function setupNewComment(Request $request)
    {

        try {

            $addComment = CommentTable::create(
                [
                    'comment' => $request->comment,
                    'schoolid' => Auth::user()->schoolid
                ]
            );

            return back()->with('success', 'Comment added successfully');

        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Error adding comment');
        }
        
    }

    public function deletecomment(Request $request)
    {
        $deleteComment = CommentTable::find($request->deleteid);
        $deleteComment->delete();

        return back()->with('success', 'Comment deleted successfully');

    }
}
