<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classlist_sec;
use App\Addstudent_sec;
use App\Addsection_sec;
use App\AddMoto_sec;
use App\Addpost;
use App\MotoList;
use Validator;
use Auth;
use DB;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class MotoController_sec extends Controller
{
    public function index(){

        $class_list = Classlist_sec::where('schoolid', Auth::user()->schoolid)->get();
        $addsection_sec = Addsection_sec::where('schoolid', Auth::user()->schoolid)->get();
        $addpost = Addpost::where('id', Auth::user()->schoolid)->get();

        $alldetails = array(
            'class_list'=>$class_list,
            'addsection_sec'=>$addsection_sec,
            'addpost'=>$addpost
        );
        
        return view('secondary.psycomotor.moto_sec')->with('alldetails', $alldetails);
    }

    public function settingsmoto()
    {

        $addmoto = MotoList::where('schoolid', Auth::user()->schoolid)->get();

        return view('secondary.psycomotor.settings', compact('addmoto'));
    }

    public function addSettingsMoto(Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $addmoto = new MotoList();
        $addmoto->name = $request->name;
        $addmoto->schoolid = (int)Auth::user()->schoolid;
        $addmoto->save();

        return back()->with('success', 'process was successfull...');


    }

    public function get_students_for_psyco(Request $request){

        $validator = Validator::make($request->all(),[
            'selectedclassmoto' => 'required',
            'selectedsectionmoto' => 'required',
            'selectedtermmoto' => 'required',
            'sessionmoto' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $addstudent = DB::table('addstudent_secs')
                    ->join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
                    ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
                    ->join('addsection_secs', 'addsection_secs.id','=','addstudent_secs.studentsection')
                    ->select('addstudent_secs.*', 'classlist_secs.classname', 'users.firstname', 'users.middlename', 'users.lastname', 'addsection_secs.sectionname', 'users.id as userid')
                    ->where(['addstudent_secs.classid'=>$request->input('selectedclassmoto'), 'addstudent_secs.studentsection'=>$request->input('selectedsectionmoto'), 'addstudent_secs.schoolsession'=>$request->input('sessionmoto'),])
                    ->get();

        $checkifmotohasbeenadded = AddMoto_sec::where(["term"=>$request->selectedtermmoto, "schoolid"=>Auth::user()->schoolid, "session"=>$request->sessionmoto])->pluck('student_id');

        return response()->json(['success'=>$addstudent, 'atlist'=>$checkifmotohasbeenadded]);

    }

    public function addFunNowMain($id)
    {
        $addmoto = MotoList::where('schoolid', Auth::user()->schoolid)->get();
        $student = Addstudent_sec::where('usernamesystem', $id)->first();
        
        return view('secondary.psycomotor.addmoto', compact('addmoto', 'student'));
    }

    public function addmotomain(Request $request, $id){

        
        $requestData = $request->except(['_token']);

        $getschoolData = Addpost::find(Auth::user()->schoolid);

        $check = AddMoto_sec::where(['session'=>$getschoolData->schoolsession, 'schoolid'=>Auth::user()->schoolid, 'term'=>$getschoolData->term])->get();

        if ($check->count() > 0) {
            return back()->with('error', 'moto already added');
        }

        foreach ($requestData as $key => $value) {
            
            $explodeSelection = explode('_', $value);

            

            $addmoto = new AddMoto_sec();
            $addmoto->moto_id = $explodeSelection[0];
            $addmoto->moto_score = $explodeSelection[2];
            $addmoto->student_id = $id;
            $addmoto->schoolid = Auth::user()->schoolid;
            $addmoto->session = $getschoolData->schoolsession;
            $addmoto->term = $getschoolData->term;
            $addmoto->save();

            

        }

        return back()->with('success', 'process was successfull');



    }

    


}
