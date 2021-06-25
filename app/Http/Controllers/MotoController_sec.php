<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classlist_sec;
use App\Addstudent_sec;
use App\Addsection_sec;
use App\AddMoto_sec;
use App\Addpost;
use App\MotoList;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;

class MotoController_sec extends Controller
{
    public function index(){

        $schooldetails = Addpost::find(Auth::user()->schoolid);
        
        return view('secondary.psycomotor.motoreact', compact('schooldetails'));
    }

    public function settingsmoto()
    {

        $addmoto = MotoList::where('schoolid', Auth::user()->schoolid)->get();

        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('secondary.psycomotor.settings', compact('addmoto', 'schooldetails'));
    }

    public function addSettingsMoto(Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required',
            'category' =>'required'
        ]);

        $addmoto = new MotoList();
        $addmoto->name = $request->name;
        $addmoto->category = $request->category;
        $addmoto->schoolid = (int)Auth::user()->schoolid;
        $addmoto->save();

        return back()->with('success', 'process was successfull...');


    }

    public function get_students_for_psyco(Request $request){

        $validator = Validator::make($request->all(),[
            'selectedclassmoto' => 'required',
            'selectedsectionmoto' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $schooldetails = Addpost::find(Auth::user()->schoolid);

        $addstudent = DB::table('addstudent_secs')
                    ->join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
                    ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
                    ->join('addsection_secs', 'addsection_secs.id','=','addstudent_secs.studentsection')
                    ->select('addstudent_secs.*', 'classlist_secs.classname', 'users.firstname', 'users.middlename', 'users.lastname', 'addsection_secs.sectionname', 'users.id as userid')
                    ->where(['addstudent_secs.classid'=>$request->input('selectedclassmoto'), 'addstudent_secs.studentsection'=>$request->input('selectedsectionmoto'), 'addstudent_secs.schoolsession'=>$schooldetails->schoolsession,])
                    ->get();

        $checkifmotohasbeenadded = AddMoto_sec::where(["term"=>$schooldetails->term, "schoolid"=>Auth::user()->schoolid, "session"=>$schooldetails->schoolsession])->pluck('student_id');

        $motolist = MotoList::where('schoolid', Auth::user()->schoolid)->get();

        return response()->json(['success'=>$addstudent, 'atlist'=>$checkifmotohasbeenadded, 'motolist'=>$motolist]);

    }

    public function addFunNowMain($id)
    {
        $addmoto = MotoList::where('schoolid', Auth::user()->schoolid)->get();
        $student = Addstudent_sec::where('usernamesystem', $id)->first();
        
        return view('secondary.psycomotor.addmoto', compact('addmoto', 'student'));
    }

    public function addmotomain(Request $request){

        // return count($request->input());

        try {

            $getschoolData = Addpost::find(Auth::user()->schoolid);
    
            if (count($request->input()) > 0 ) {
    
                $getuserid = $request[0]["userId"];
    
                $getMotoList = AddMoto_sec::where(['schoolid'=> Auth::user()->schoolid, 'student_id'=>$getuserid, 'session'=>$getschoolData->schoolsession, 'term'=>$getschoolData->term])->pluck('moto_id')->toArray();
    
                for ($i=0; $i < count($request->input()); $i++) { 
                    
                        if (!in_array($request[$i]['moto_id'], $getMotoList)) {
                            
                            $addmoto = new AddMoto_sec();
                            $addmoto->moto_id = $request[$i]['moto_id'];
                            $addmoto->moto_score = $request[$i]['valueSelected'];
                            $addmoto->student_id = $request[$i]['userId'];
                            $addmoto->schoolid = Auth::user()->schoolid;
                            $addmoto->session = $getschoolData->schoolsession;
                            $addmoto->term = $getschoolData->term;
                            $addmoto->save();
                        }

                }
    
                return response()->json(['response'=>"success"]);
    
            }else{
                return response()->json(['response'=>"error"]);
            }
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json(['response'=>$th]);
        }



    }

    


}
