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
use App\SubHistory;
use Illuminate\Support\Facades\Auth;


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
    
            $alldetails = array(
                'addschool' => $addschool,
                "getStudentCount"=>$getStudentCount,
                "subHistory"=>$subHistory
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

        return back();
    }

    public function grades_sec(){

        $addgrades = Addgrades_sec::where('schoolid', Auth::user()->schoolid)->get();

        // return $addgrades;

        return view('secondary.gradessec')->with('addgrades', $addgrades);
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

        $schoolsessioninput = $request->input('schoolsessioninput');

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
        $updateSchoolSession->schoolsession = $schoolsessioninput;
        $updateSchoolSession->save();

        $msg = 1;
        return response()->json(array('msg' => $msg), 200);

    }

    public function addClasses(Request $request){
        
        $addclasses_input = $request->input('addclasses_input');

        if (empty($addclasses_input)) {
            $msg = 0;
            return response()->json(array('msg' => $msg), 200);
        }

        $addclasses_sec_explode = explode(',', $addclasses_input);

        for ($i=0; $i < count($addclasses_sec_explode); $i++) { 

            $classlistCheck = Classlist_sec::where(['classname' => $addclasses_sec_explode[$i], 'schoolid' => Auth::user()->schoolid])->get();

            if (count($classlistCheck) < 1) {
                $addclasses_sec = new Classlist_sec();
                $addclasses_sec->schoolid = Auth::user()->schoolid;
                $addclasses_sec->classname = strtoupper($addclasses_sec_explode[$i]);
                $addclasses_sec->studentcount = 0;
                $addclasses_sec->save();
            }
        }

        $msg = 1;
        return response()->json(array('msg' => $msg), 200);
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
}
