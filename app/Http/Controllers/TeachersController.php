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
use App\Addteachers;
use App\Addsubject;
use Auth;
use Redirect;
use Carbon\Carbon;
use App\TeacherAttendance;
use Validator;
use DB;

class TeachersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->schoolid;

        $userschool = Addpost::where('id', $id)->get();
        $classList = Classlist::where('schoolid', $id)->get();
        $addHouses = Addhouses::where('schoolid', $id)->get();
        $addSection = Addsection::where('schoolid', $id)->get();
        $addClub = AddClub::where('schoolid', $id)->get();
        $addteachers = Addteachers::where('schoolid', $id)->get();
        $addsubjects = DB::table('addsubjects')
                     ->join("classlists", "classlists.id","=","addsubjects.classid")
                     ->where('addsubjects.schoolid', $id)
                     ->select("addsubjects.*", "classlists.classnamee")->get();

        $studentDetails = array(
            'userschool' => $userschool,
            'classList' => $classList,
            'addHouses' => $addHouses,
            'addSection' => $addSection,
            'addClub' => $addClub,
            'addteachers' => $addteachers,
            'addsubjects' => $addsubjects
        );
        
        // $studentDetails['classList']

        return view('pages.addteacher')->with('studentDetails', $studentDetails);
    }
    
    // public function 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->input('key');
        
        if($request->input('key') == "form"){
            
            $validatedData = $request->validate([
                'formclass' => 'required',
                'formsection' => 'required',
                'systemnumberTeacher' => 'required'
            ]);
            
            $checkteacher = Addteachers::where("systemid", $request->input('systemnumberTeacher'))->get();
            
            if(count($checkteacher) > 0){
                
                return response()->json(['already' => "none"], 200);
                
            }
            
            $addteachers = new Addteachers;
            $addteachers->schoolid = Auth::user()->schoolid;
            $addteachers->formteacher = $request->input('formclass');
            $addteachers->formsection = $request->input('formsection');
            $addteachers->systemid = $request->input('systemnumberTeacher');
            $addteachers->track = Auth::user()->useridsystem;
            $addteachers->save();

            //update user role
            $teacherDetail = User::where('id', $request->input('systemnumberTeacher'))->get();

            $id = $teacherDetail[0]['id'];

            $updateRole = User::find($id);
            $updateRole->role = "Teacher";
            $updateRole->schoolid = Auth::user()->schoolid;
            $updateRole->save();
            
            return response()->json(['success' => "success"], 200);
            
        }else{
            
            $validatedData = $request->validate([
                'systemnumberTeacherSubject' => 'required',
                'subjectAllocatedSubject' => 'required',
            ]);
            
            $checkteacher = Addteachers::where("systemid", $request->input('systemnumberTeacherSubject'))->get();
            
            if(count($checkteacher)<1){
                
                $addteachers = new Addteachers;
                $addteachers->schoolid = Auth::user()->schoolid;
                $addteachers->systemid = $request->input('systemnumberTeacherSubject');
                $addteachers->track = Auth::user()->useridsystem;
                $addteachers->save();
                
            }

            //update user role
            $teacherDetail = User::where('id', $request->input('systemnumberTeacherSubject'))->get();

            $id = $teacherDetail[0]['id'];

            $updateRole = User::find($id);
            $updateRole->role = "Teacher";
            $updateRole->schoolid = Auth::user()->schoolid;
            $updateRole->save();
            
            //alocate subject to teacher
            
            $addsubjecttoteacher = Addsubject::find($request->input('subjectAllocatedSubject'));
            $addsubjecttoteacher->teacherid = $request->input('systemnumberTeacherSubject');
            $addsubjecttoteacher->save();

            return response()->json(['success' => "success"], 200); 
            
        }
        
        






        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function verifyTeacher(Request $request){
        
        $key = $request->input('type');
        
                if($key == "addteacherform"){
                    
                $regNumber = $request->input('regNumber');
        
                $teachDetails = User::where(['id'=> $regNumber])->get();
        
                $teachersCheck = DB::table('addteachers')
                               ->leftjoin("classlists", "classlists.id","=","addteachers.formteacher")
                               ->leftjoin("addsections", "addsections.id","=","addteachers.formsection")
                               ->where('systemid', $regNumber)
                               ->select("addteachers.*", "classlists.classnamee", "addsections.sectionname")->get();
                
                
                // Addteachers::where('systemid', $regNumber)->get();
        
                $checkCountteachers = count($teachersCheck);
                
                
                
                
        
                $teacherDetailsArray = array(
                    'firstname' => $teachDetails[0]['firstname'],
                    'middlename' => $teachDetails[0]['middlename'],
                    'lastname' => $teachDetails[0]['lastname'],
                    'profileimg' => $teachDetails[0]['profileimg'],
                    'checkCountteachers' => $checkCountteachers,
                    'teachersCheck'=>$teachersCheck
        
                );
        
                return response()->json($teacherDetailsArray, 200);
            
        }else{
            
                    $regNumber = $request->input('regNumber');

                    $teachDetails = User::where(['id'=> $regNumber])->get();
            
                    $teachersCheck = DB::table('addteachers')
                                   ->leftjoin("classlists", "classlists.id","=","addteachers.formteacher")
                                   ->leftjoin("addsections", "addsections.id","=","addteachers.formsection")
                                   ->where('systemid', $regNumber)
                                   ->select("addteachers.*", "classlists.classnamee", "addsections.sectionname")->get();
                    
                    
                    // Addteachers::where('systemid', $regNumber)->get();
            
                    $checkCountteachers = count($teachersCheck);
                    
                    
                    
                    
            
                    $teacherDetailsArray = array(
                        'firstname' => $teachDetails[0]['firstname'],
                        'middlename' => $teachDetails[0]['middlename'],
                        'lastname' => $teachDetails[0]['lastname'],
                        'profileimg' => $teachDetails[0]['profileimg'],
                        'checkCountteachers' => $checkCountteachers,
                        'teachersCheck'=>$teachersCheck
            
                    );
            
                    return response()->json($teacherDetailsArray, 200);
            
        }


        
    }

    public function viewteachers(){

        $id = Auth::user()->schoolid;

        $userschool = Addpost::where('id', $id)->get();
        $classList = Classlist::where('schoolid', $id)->get();
        $addHouses = Addhouses::where('schoolid', $id)->get();
        $addSection = Addsection::where('schoolid', $id)->get();
        $addClub = AddClub::where('schoolid', $id)->get();

        $studentDetails = array(
            'userschool' => $userschool,
            'classList' => $classList,
            'addHouses' => $addHouses,
            'addSection' => $addSection,
            'addClub' => $addClub
        );

        return view('pages.viewteachers')->with('studentDetails', $studentDetails);
    }

    public function getTeacher(Request $request){
        $regNumber = $request->input('regNumber');

        $userRegCheck = DB::table('addteachers') 
        ->join('users', 'users.id', '=', 'addteachers.systemid')
        ->join('classlists', 'classlists.id', '=', 'addteachers.classid')
        ->select('addteachers.*', 'users.firstname', 'users.middlename', 'users.lastname', 'classlists.classnamee')
        ->where('addteachers.id', $regNumber)->get();

        $id = Auth::user()->schoolid;

        $userschool = Addpost::where('id', $id)->get();

        $schoolInitial = $userschool[0]['shoolinitial'];

        $newuserId = $six_digit_random_number = mt_rand(100000, 999999);

        $newuserFinal = $schoolInitial.'-'.$newuserId;

        if ($schoolInitial == "") {

            $msg = "failed";

            return response()->json(array('msg' => $msg), 200);
        }else{
            // $msg = array(
            //     'firstname' => $userRegCheck[0]['firstname'],
            //     'middlename' => $userRegCheck[0]['middlename'],
            //     'lastname' => $userRegCheck[0]['lastname'],
            //     'useridsystem' => $userRegCheck[0]['systemid'],
            //     'session' => $userRegCheck[0]['section'],
            //     'gender' => $userRegCheck[0]['gender'],
            //     'classid' => $userRegCheck[0]['classid']
            // );
    
            return response()->json($userRegCheck, 200);
        }
    }

//---------------------------------------------------------------------------------
//                        fetchteachers for viewing
//---------------------------------------------------------------------------------

    public function getAllTeachersforview(Request $request){

        $session = $request->input('studentSession');
        $studentclassMain = $request->input('studentclassMain');
        $studentsectionMain = $request->input('studentsectionMain');
        $studentshiftMain = $request->input('studentshiftMain');

        $allClassStudent = DB::table('addteachers') 
        ->join('users', 'users.id', '=', 'addteachers.systemid')
        ->join('classlists', 'classlists.id', '=', 'addteachers.classid')
        ->select('addteachers.*', 'classlists.classnamee', 'users.firstname', 'users.middlename', 'users.lastname')
        ->where(['addteachers.session' => $session, 'addteachers.classid' => $studentclassMain, 'addteachers.section' => $studentsectionMain, 'addteachers.shift' => $studentshiftMain])->get();


        return response()->json($allClassStudent, 200);

    }



    public function getAllTeachers(Request $request){

        $session = $request->input('studentSession');
        $studentclassMain = $request->input('studentclassMain');
        $studentsectionMain = $request->input('studentsectionMain');
        $studentshiftMain = $request->input('studentshiftMain');

        $allClassStudent = Addteachers::where(['session' => $session, 'classid' => $studentclassMain, 'section' => $studentsectionMain, 'shift' => $studentshiftMain])->get();

        $datemain = Carbon::now();
        $attDate = $datemain->toDateString();

        $getTeachers = TeacherAttendance::where('datetoday', $attDate)->get();

        $a = array();

        for ($i=0; $i < count($getTeachers); $i++) { 
            $attendanceRegNum = $getTeachers[$i]['regnumber'];
                array_push($a, $attendanceRegNum);
        }

        return response()->json([$allClassStudent, $a], 200);

    }

    public function teachersAttendance(){
        $id = Auth::user()->schoolid;

        $userschool = Addpost::where('id', $id)->get();
        $classList = Classlist::where('schoolid', $id)->get();
        $addHouses = Addhouses::where('schoolid', $id)->get();
        $addSection = Addsection::where('schoolid', $id)->get();
        $addClub = AddClub::where('schoolid', $id)->get();

        $datemain = Carbon::now();
        $attDate = $datemain->toDateString();

        $studentDetails = array(
            'userschool' => $userschool,
            'classList' => $classList,
            'addHouses' => $addHouses,
            'addSection' => $addSection,
            'addClub' => $addClub,
            'attDate' => $attDate
        );
        return view('pages.teachersattendance')->with('studentDetails', $studentDetails);
    } 

//---------------------------------------------------------------------------------------
//                         teachers attendance taken here
//---------------------------------------------------------------------------------------

    public function teachersAtt(Request $request){

        $regNumber = $request->input('regNumber');

        $datemain = Carbon::now();
        $attDate = $datemain->toDateString();

        // $date = Carbon::createFromFormat('m/d/Y', $datemain);

        $attendancecheck = TeacherAttendance::where(['regnumber' => $regNumber, 'datetoday' => $attDate, 'schoolid' => Auth::user()->schoolid])->get();

        if (count($attendancecheck) > 0) {
            $msg = "already";
            return response()->json(array('msg' => $msg), 200);
        }else{
            $attendance = new TeacherAttendance();
            $attendance->regnumber = $regNumber;
            $attendance->schoolid = Auth::user()->schoolid;
            $attendance->datetoday = $attDate;
            $attendance->save();

            $msg = "success";
            return response()->json(array('msg' => $msg), 200);
        }
    }

    public function viewallTeachers(){

        $id = Auth::user()->schoolid;

        $userschool = Addpost::where('id', $id)->get();
        $classList = Classlist::where('schoolid', $id)->get();
        $addHouses = Addhouses::where('schoolid', $id)->get();
        $addSection = Addsection::where('schoolid', $id)->get();
        $addClub = AddClub::where('schoolid', $id)->get();

        $datemain = Carbon::now();
        $attDate = $datemain->toDateString();

        $studentDetails = array(
            'userschool' => $userschool,
            'classList' => $classList,
            'addHouses' => $addHouses,
            'addSection' => $addSection,
            'addClub' => $addClub,
            'attDate' => $attDate
        );

        //  Addteachers::find(4)->teachersAttendance()->where('schoolid', Auth::user()->schoolid)->get();

         return view('pages.viewattendanceteachers')->with('studentDetails', $studentDetails);
        
    }

    public function viewatTeachers(Request $request){

        $session = $request->input('studentSession');
        $studentclassMain = $request->input('studentclassMain');
        $studentsectionMain = $request->input('studentsectionMain');
        $studentshiftMain = $request->input('studentshiftMain');
        $datehist = $request->input('datehist');

        $allClassStudent = Addteachers::where(['session' => $session, 'classid' => $studentclassMain, 'section' => $studentsectionMain, 'shift' => $studentshiftMain])->get();

        $datemain = Carbon::now();
        $attDate = $datemain->toDateString();

        $getTeachers = TeacherAttendance::where('datetoday', $datehist)->get();

        $a = array();

        for ($i=0; $i < count($getTeachers); $i++) { 
            $attendanceRegNum = $getTeachers[$i]['regnumber'];
                array_push($a, $attendanceRegNum);
        }

        return response()->json([$allClassStudent, $a], 200);
    }

    public function addStaff(){
        $id = Auth::user()->schoolid;

        $userschool = Addpost::where('id', $id)->get();
        $classList = Classlist::where('schoolid', $id)->get();
        $addHouses = Addhouses::where('schoolid', $id)->get();
        $addSection = Addsection::where('schoolid', $id)->get();
        $addClub = AddClub::where('schoolid', $id)->get();

        $studentDetails = array(
            'userschool' => $userschool,
            'classList' => $classList,
            'addHouses' => $addHouses,
            'addSection' => $addSection,
            'addClub' => $addClub
        );

        return view('pages.addstaff')->with('studentDetails', $studentDetails);
    }

    public function addstaffdata(Request $request){

        $validator = Validator::make($request->all(),[
            'systemnumber' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $systemnumber = $request->input('systemnumber');

        $userdetails = User::where('id', $systemnumber)->get();

        return response()->json($userdetails, 200);

    }

    public function addroles(Request $request){

        $validator = Validator::make($request->all(),[
            'SelectRole' => 'required',
            'staffid' => 'required'
        ]);

        $SelectRole = $request->input('SelectRole');
        $staffid = $request->input('staffid');

        $checkvalue = User::where(['id' => $staffid, 'schoolid' => Auth::user()->schoolid])->get();

        $notincludedroles = array("Student", "Teacher");

        if (count($checkvalue) > 0 && in_array($checkvalue[0]['role'], $notincludedroles)) {
            return back()->with('error', 'Operation not allowed');
        }else{
            $checkrole = User::find($staffid);
            $checkrole->schoolid = Auth::user()->schoolid;
            $checkrole->role = $SelectRole;
            $checkrole->save();
            return back()->with('success', 'Role allocated seccessfully');
        }   
    }

    public function editprofileteacher(){

            $id = Auth::user()->schoolid;

            $userschool = Addpost::where('id', $id)->get();
            $classList = Classlist::where('schoolid', $id)->get();
            $addHouses = Addhouses::where('schoolid', $id)->get();
            $addSection = Addsection::where('schoolid', $id)->get();
            $addClub = AddClub::where('schoolid', $id)->get();
            $addteachers = Addteachers::where(['schoolid' => $id, 'systemid' => Auth::user()->id])->get();

            $studentDetails = array(
                'userschool' => $userschool,
                'classList' => $classList,
                'addHouses' => $addHouses,
                'addSection' => $addSection,
                'addClub' => $addClub,
                'addteachers' =>$addteachers
            );

            // return $studentDetails['addteachers'][0];

            

        return view('pages.editprofileteacher')->with('studentDetails', $studentDetails);
    }

    public function editteachersdata(Request $request){
        // return $request->input();
        $validatedData = $request->validate([
            'firstnameedit' => 'required',
            'middlenameedit' => 'required',
            'lastnameedit' => 'required',
            'emailedit' => 'required',
            'courseedit' => 'required',
            'institutionedit' => 'required',
            'degreeedit' => 'required',
            'educationedit' => 'required',
            'graduationedit' => 'required',
            'birthedit' => 'required',
            'addressedit' => 'required',
            'entryid' => 'required',
            'genderedit'=> 'required',
            'religionedit' => 'required',
            'bloodgroupedit' => 'required',
        ]);

        $updateteachers = Addteachers::find($request->input('entryid'));
        $updateteachers->gender = $request->input('genderedit');
        $updateteachers->religion = $request->input('religionedit');
        $updateteachers->bloodgroup = $request->input('bloodgroupedit');
        $updateteachers->courseedit = $request->input('courseedit');
        $updateteachers->institutionedit = $request->input('institutionedit');
        $updateteachers->degreeedit = $request->input('degreeedit');
        $updateteachers->educationedit = $request->input('educationedit');
        $updateteachers->graduationedit = $request->input('graduationedit');
        $updateteachers->dob = $request->input('birthedit');
        $updateteachers->residentialaddress = $request->input('addressedit');
        $updateteachers->save(); 

        return back();
    }
}
