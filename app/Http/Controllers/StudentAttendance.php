<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classlist_sec;
use App\Addsection_sec;
use App\Addpost;
use App\StudentAt;
use App\Addstudent_sec;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentAttendance extends Controller
{
    private $classlist_sec;
    private $addsection_sec;
    private $addpost;
    private $studentAt;
    private $addstudent_sec;

    function __construct(Classlist_sec $classlist_sec, Addsection_sec $addsection_sec, Addpost $addpost, StudentAt $studentAt, Addstudent_sec $addstudent_sec)
    {
        $this->classlist_sec = $classlist_sec;
        $this->addsection_sec = $addsection_sec;
        $this->addpost = $addpost;
        $this->studentAt = $studentAt;
        $this->addstudent_sec = $addstudent_sec;

        
    }

    public function index(){

        $addschool = $this->addpost->where('id', Auth::user()->schoolid)->first();

        return view('secondary.attendance.students.studentattendance_sec', compact('addschool'));
    }

    public function fetchalluserbyclass_sec(Request $request){

        $validator = Validator::make($request->all(),[
            'classselect' => 'required|string',
            'schoolsession' => 'required|string',
            'studentsection' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }


        $fetchallclass_sec = DB::table('addstudent_secs')
        ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
        ->join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
        ->join('addsection_secs', 'addsection_secs.id','=','addstudent_secs.studentsection')
        ->select('addstudent_secs.*', 'users.firstname', 'users.middlename', 'users.lastname', 'classlist_secs.classname', 'addsection_secs.sectionname')
        ->where(['classid'=>$request->input('classselect'), 'schoolsession'=>$request->input('schoolsession'), 'studentsection'=>$request->input('studentsection')])->get();


        $idf = $fetchallclass_sec->toJson();
        $studentdetails = json_decode($idf, true);

        $datemain = Carbon::now();
        $attDate = $datemain->toDateString();

        $a = $this->studentAt->where('datetoday', $attDate)->pluck('regnumber');

        return response()->json(['fetch'=>$studentdetails, 'attids'=>$a]);

    }

    public function studentattendanceMain(Request $request){

        $studentregnumber = $request->input('studentregnum');

        $datemain = Carbon::now();
        $attDate = $datemain->toDateString();

        $datemainmonth = Carbon::now();
        $attDatemonth = $datemainmonth->toDateString();

        $dateExplode = explode("-", $attDatemonth);
        $monthdateOnly = $dateExplode[0]."-".$dateExplode[1];

        $getSystemNumber = $this->addstudent_sec->where('id', $studentregnumber)->get();

        $systemNum = $getSystemNumber[0]["usernamesystem"];

        $attendancecheck = $this->studentAt->where(['regnumber' => $studentregnumber, 'datetoday' => $attDate, 'schoolid' => Auth::user()->schoolid])->get();

        if (count($attendancecheck) > 0) {
            $msg = "already";
            return response()->json(array('msg' => $msg), 200);
        }else{
            $attendance = new StudentAt();
            $attendance->regnumber = $studentregnumber;
            $attendance->systemid = $systemNum;
            $attendance->schoolid = Auth::user()->schoolid;
            $attendance->datetoday = $attDate;
            $attendance->monthtoday = $monthdateOnly;
            $attendance->save();

            $msg = "success";
            return response()->json(array('msg' => $msg), 200);
        }

    }
    
    public function check_att_sec_route(){
        
        $addschool = $this->addpost->where('id', Auth::user()->schoolid)->first();
        
        return view('secondary.attendance.students.viewstudentattendance', compact('addschool'));
    }
    
    public function check_att_sec(Request $request){
        
        $validator = Validator::make($request->all(),[
            'classselect' => 'required|string',
            'schoolsession' => 'required|string',
            'studentsection' => 'required|string',
            'daydate'=>'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }


        $fetchallclass_sec = DB::table('addstudent_secs')
        ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
        ->join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
        ->join('addsection_secs', 'addsection_secs.id','=','addstudent_secs.studentsection')
        ->select('addstudent_secs.*', 'users.firstname', 'users.middlename', 'users.lastname', 'classlist_secs.classname', 'addsection_secs.sectionname')
        ->where(['classid'=>$request->input('classselect'), 'schoolsession'=>$request->input('schoolsession'), 'studentsection'=>$request->input('studentsection')])->get();

        // return $fetchallclass_sec;

        $idf = $fetchallclass_sec->toJson();
        $studentdetails = json_decode($idf, true);

        $datemain = Carbon::now();
        $attDate = $datemain->toDateString();
        
        $daymaindate = Carbon::parse($request->input('daydate'))->format('Y-m-d');

        $a = $this->studentAt->where('datetoday', $daymaindate)->pluck('regnumber');

        return response()->json(['fetch'=>$studentdetails, 'attids'=>$a]);
        
    }
}
