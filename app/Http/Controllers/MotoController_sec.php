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
use Illuminate\Support\Facades\DB;
use Validator;

class MotoController_sec extends Controller
{
    public function index()
    {

        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('features.psycomotor.motoreact', compact('schooldetails'));
    }

    public function settingsmoto()
    {

        $addmoto = MotoList::where('schoolid', Auth::user()->schoolid)->get();

        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('features.psycomotor.settings', compact('addmoto', 'schooldetails'));
    }

    public function addSettingsMoto(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'category' => 'required'
        ]);

        $addmoto = new MotoList();
        $addmoto->name = $request->name;
        $addmoto->category = $request->category;
        $addmoto->schoolid = (int)Auth::user()->schoolid;
        $addmoto->save();

        return back()->with('success', 'process was successfull...');
    }

    public function editSettingsmoto(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'category' => 'required'
        ]);

        $addmoto = MotoList::find($request->id);
        $addmoto->name = $request->name;
        $addmoto->category = $request->category;
        $addmoto->schoolid = (int)Auth::user()->schoolid;
        $addmoto->save();

        return back()->with('success', 'process was successfull...');
    }

    public function get_students_for_psyco(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'selectedclassmoto' => 'required',
            'selectedsectionmoto' => 'required',
        ]);

        // return $request;

        try {
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->keys()]);
            }

            $schooldetails = Addpost::find(Auth::user()->schoolid);

            $addstudent = DB::table('addstudent_secs')
                ->join('classlist_secs', 'classlist_secs.id', '=', 'addstudent_secs.classid')
                ->join('users', 'users.id', '=', 'addstudent_secs.usernamesystem')
                ->join('addsection_secs', 'addsection_secs.id', '=', 'addstudent_secs.studentsection')
                ->select('addstudent_secs.*', 'classlist_secs.classname', 'users.firstname', 'users.middlename', 'users.lastname', 'addsection_secs.sectionname', 'users.id as userid')
                ->where(['addstudent_secs.classid' => $request->input('selectedclassmoto'), 'addstudent_secs.studentsection' => $request->input('selectedsectionmoto'), 'addstudent_secs.schoolsession' => $schooldetails->schoolsession,])
                ->get();

            $checkifmotohasbeenadded = AddMoto_sec::where(["term" => $schooldetails->term, "schoolid" => Auth::user()->schoolid, "session" => $schooldetails->schoolsession])->pluck('student_id');

            $motolist = MotoList::where('schoolid', Auth::user()->schoolid)->get();

            return response()->json(['success' => $addstudent, 'atlist' => $checkifmotohasbeenadded, 'motolist' => $motolist], 200);
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json(['error' => $th], 400);
        }
    }

    public function addFunNowMain($id)
    {
        $addmoto = MotoList::where('schoolid', Auth::user()->schoolid)->get();
        $student = Addstudent_sec::where('usernamesystem', $id)->first();

        return view('features.psycomotor.addmoto', compact('addmoto', 'student'));
    }

    public function addmotoMain(Request $request)
    {

        // return $request->input();

        try {

            $getschoolData = Addpost::find(Auth::user()->schoolid);

            if (count($request->input()) > 0) {

                $getuserid = $request[0]["userId"];

                $getMotoList = AddMoto_sec::where(['schoolid' => Auth::user()->schoolid, 'student_id' => $getuserid, 'session' => $getschoolData->schoolsession, 'term' => $getschoolData->term])->pluck('moto_id')->toArray();

                AddMoto_sec::where(['schoolid' => Auth::user()->schoolid, 'student_id' => $getuserid, 'session' => $getschoolData->schoolsession, 'term' => $getschoolData->term])->delete();

                for ($i = 0; $i < count($request->input()); $i++) {

                    // if (!in_array($request[$i]['moto_id'], $getMotoList)) {


                    try {
                        // $addmoto = AddMoto_sec::Create(
                        // ["moto_id"=>$request[$i]['moto_id'],
                        // "student_id"=>$request[$i]['userId'],
                        // "schoolid"=>Auth::user()->schoolid,
                        // "session"=>$getschoolData->schoolsession,
                        // "term"=>$getschoolData->term],

                        // ["moto_id"=>$request[$i]['moto_id'], 
                        // "moto_score"=>$request[$i]['valueSelected'],
                        // "student_id"=>$request[$i]['userId'],
                        // "schoolid"=>Auth::user()->schoolid,
                        // "session"=>$getschoolData->schoolsession,
                        // "term"=>$getschoolData->term]);
                        $addmoto = new AddMoto_sec();
                        $addmoto->moto_id = $request[$i]['moto_id'];
                        $addmoto->moto_score = $request[$i]['valueSelected'];
                        $addmoto->student_id = $request[$i]['userId'];
                        $addmoto->schoolid = Auth::user()->schoolid;
                        $addmoto->session = $getschoolData->schoolsession;
                        $addmoto->term = $getschoolData->term;
                        $addmoto->save();
                    } catch (\Throwable $th) {
                        //throw $th;
                        return response()->json(['response' => $th]);
                    }

                    // $checkMoto = AddMoto_sec::where(['moto_id'=>$request[$i]['moto_id'], 'student_id'=>$request[$i]['userId'], 'session'=>$getschoolData->schoolsession, 'term'=>$getschoolData->term])->first();

                    // if($checkMoto == null){

                    //     $addmoto = new AddMoto_sec();
                    //     $addmoto->moto_id = $request[$i]['moto_id'];
                    //     $addmoto->moto_score = $request[$i]['valueSelected'];
                    //     $addmoto->student_id = $request[$i]['userId'];
                    //     $addmoto->schoolid = Auth::user()->schoolid;
                    //     $addmoto->session = $getschoolData->schoolsession;
                    //     $addmoto->term = $getschoolData->term;
                    //     $addmoto->save();

                    // }else{

                    //     return response()->json(['response'=>"success", 'data'=>$checkMoto]);

                    //     $checkMoto->moto_score = $request[$i]['valueSelected'];
                    //     $checkMoto->save();

                    // }

                    // }

                }

                return response()->json(['response' => "success"]);
            } else {
                return response()->json(['response' => "error"]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => $th]);
        }
    }
}
