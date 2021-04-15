<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\teachersattendance_sec;
use App\Classlist_sec;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AttendanceTeachers extends Controller
{
    public function index(){

        return view('secondary.attendance.teachers.teachersattendance_sec');
    }

    public function fetchteachers(Request $request){

        $teacherdetaild = DB::table('addteachers_secs')
                        ->leftjoin('addsubject_secs', 'addsubject_secs.id','=','addteachers_secs.subject')
                        ->leftjoin('classlist_secs', 'classlist_secs.id','=','addteachers_secs.teachclass')
                        ->join('users', 'users.id','=','addteachers_secs.systemid')
                        ->where(['addteachers_secs.schoolid'=>Auth::user()->schoolid])
                        ->select('addteachers_secs.*', 'addsubject_secs.subjectname', 'users.firstname', 'users.middlename', 'users.lastname', 'classlist_secs.classname')
                        ->get();

                        $datemain = Carbon::now();
                        $attDate = $datemain->toDateString();

                        $getTeachers = teachersattendance_sec::where('datetoday', $attDate)->get();

                        $a = array();
                
                        for ($i=0; $i < count($getTeachers); $i++) { 
                            $attendanceRegNum = $getTeachers[$i]['regnumber'];
                                array_push($a, $attendanceRegNum);
                        }

                        return response()->json(['success'=>$teacherdetaild, 'a'=>$a]);
                        

    }

    public function teachersAttendance(Request  $request){

        $regno = $request->input('regno');

        $datemain = Carbon::now();
        $attDate = $datemain->toDateString();

        // $date = Carbon::createFromFormat('m/d/Y', $datemain);

        $attendancecheck = teachersattendance_sec::where(['regnumber' => $regno, 'datetoday' => $attDate, 'schoolid' => Auth::user()->schoolid])->get();

        if (count($attendancecheck) > 0) {
            $msg = "already";
            return response()->json(array('already' => $msg), 200);
        }else{
            $attendance = new teachersattendance_sec();
            $attendance->regnumber = $regno;
            $attendance->schoolid = Auth::user()->schoolid;
            $attendance->datetoday = $attDate;
            $attendance->save();

            $msg = "success";
            return response()->json(array('success' => $msg), 200);
        }


    }
}
