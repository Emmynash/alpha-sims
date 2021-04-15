<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Addpost;
use App\User;
use App\Classlist;
use App\Addhouses;
use App\Addsection;
use App\AddClub;
use App\Addstudent;
use App\Addsubject;
use App\Addmarks;
use App\Addgrades;
use Auth;
use Redirect;
use Carbon\Carbon;
use App\Studentattendance;
use DB;

class AllUsersController extends Controller
{
    public function index(){
        $id = Auth::user()->schoolid;


        $userschool = Addpost::where('id', $id)->get();
        $classList = User::where('id', $id)->get();
        $addHouses = User::where('id', $id)->get();
        $addSection = User::where('id', $id)->get();
        $addClub = User::where('id', $id)->get();
        $allusers = User::where('schoolid', $id)->paginate(10);

        $studentDetails = array(
            'userschool' => $userschool,
            'classList' => $classList,
            'addHouses' => $addHouses,
            'addSection' => $addSection,
            'addClub' => $addClub,
            'allusers' => $allusers
        );
        return view('pages.allusers')->with('studentDetails', $studentDetails);
    }

    public function index_sec(){
        $id = Auth::user()->schoolid;

        $allusers = User::where('schoolid', $id)->paginate(10);

        return view('secondary.viewallusers')->with('allusers', $allusers);
    }

    public function fetchuser_sec(Request $request){
        $systemno = $request->input('systemno');
        $role = $request->input('role');

        if($role == "Student"){

            $userdetails = DB::table('addstudent_secs')
                            ->join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
                            ->join('addsection_secs', 'addsection_secs.id','=','addstudent_secs.studentsection')
                            ->where(['addstudent_secs.usernamesystem'=> $systemno])
                            ->select('addstudent_secs.*', 'classlist_secs.classname', 'addsection_secs.sectionname')->get();

                            return response()->json(['data'=>$userdetails]);

        }
        else{
            
            return response()->json(['none'=>"none"]);
            
        }

        
    }
}
