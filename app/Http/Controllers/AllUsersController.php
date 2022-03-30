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
use App\Addstudent_sec;
use App\Http\Middleware\Roles;
use Redirect;
use Carbon\Carbon;
use App\Studentattendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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


        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('secondary.allusers.allusers', compact('schooldetails'));
    }
    public function fetch_all_student()
    {
        try {

       $allusers = User::where(['schoolid' => Auth::user()->schoolid])->orderBy('firstname', 'asc')->get();

        


        $usersListMain = array();

        for ($i=0; $i < $allusers->count(); $i++) { 

            $user = User::find($allusers[$i]['id']);
            $role = $user->roles->pluck('name');

           $addmisNo = '';

           if(count($role) > 0){

            if ($role[0] == "Student") {
                // echo $user->id.",";
                $student = Addstudent_sec::where('usernamesystem', $user->id)->first();
                if ($student != null) {
                    $addmisNo = $student->admission_no;
                }
                
               
           }

            

            $newObject = array(
                "name" => $allusers[$i]['firstname']." ".$allusers[$i]['middlename']." ".$allusers[$i]['lastname'],
                "role" => $role,
                "id" => $allusers[$i]['id'],
                "phonenumber" => $allusers[$i]['phonenumber'],
                "email" => $allusers[$i]['email'],
                "addmins"=>$addmisNo
            );

            array_push($usersListMain, $newObject);

           }




        }

            return response()->json(['allusers' => $usersListMain]);
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
            return response()->json(['response' => $th]);

        }
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
