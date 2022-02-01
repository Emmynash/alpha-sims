<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Addpost;
use App\User;
use App\Classlist;
use App\Addhouses;
use App\Addsection;
use App\AddClub;
use App\Addstudent;
use App\Addmarks;
use App\Addteachers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Redirect;
use Carbon\Carbon;
use App\Studentattendance;
use Spatie\Permission\Models\Role;
use Validator;


class StudentController extends Controller
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
        $addstudent = Addstudent::where('schoolid', $id)->get();

        $studentDetails = array(
            'userschool' => $userschool,
            'classList' => $classList,
            'addHouses' => $addHouses,
            'addSection' => $addSection,
            'addClub' => $addClub,
            'addstudent' => $addstudent
        );

        // return $studentDetails['userschool'][0]['schoolsession'];

        return view('pages.students.addstudent', compact('classList', 'addSection', 'addHouses', 'addClub'));
    }

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

        return $request;
        
        $validatedData = $request->validate([
            'classidstd' => 'required',
            'StudentSectionstd' => 'required',
            'systemnumberstd' => 'required',
            'studentgender' => 'required',
            'shiftstd' => 'required',
            'studentfathername' => 'required',
            'studentfathernumber' => 'required|regex:/(0)[0-9]{10}/',
            'studentmothersname' => 'required',
            'studentmothersnumber' => 'required|regex:/(0)[0-9]{10}/',
            'studentpresenthomeaddress' => 'required',
            'studentpermanenthomeaddress' => 'required',
            'studentbloodgroup' => 'required',
            'studenthouse' => 'required',
            'studentclub' => 'required',
            'dateofbirth' => 'required'
        ]);

        $classid = $request->input('classidstd');
        $studentSection =  $request->input('StudentSectionstd');
        $studentgender = $request->input('studentgender');
        $studenthouse = $request->input('studenthouse');
        $sudentreligion = $request->input('sudentreligion');
        $studentbloodgroup = $request->input('studentbloodgroup');
        $studentclub = $request->input('studentclub');
        $studentshift = $request->input('shiftstd');
        $dateOfBirth = $request->input('dateofbirth');

       

        if ($classid == "") {
            return back()->with('error', 'student class is required');
        }
        if ($studentSection == "") {
            return back()->with('error', 'student section is required');
        }
        if ($studentgender == "") {
            return back()->with('error', 'student gender is required');
        }
        if ($studenthouse == "") {
            return back()->with('error', 'student gender is required');
        }
        if ($sudentreligion == "") {
            return back()->with('error', 'student religion is required');
        }
        if ($studentbloodgroup == "") {
            return back()->with('error', 'student blood group is required');
        }
        if ($studentclub == "") {
            return back()->with('error', 'student club is required');
        }
        if ($studentshift == "") {
            return back()->with('error', 'student shift is required');
        }

        $rollNumberProcess = Addstudent::where(['schoolid' => Auth::user()->schoolid, 'classid' => $classid])->get();


            $a = array();

            for ($i=0; $i < count($rollNumberProcess); $i++) {
                
                $rollnumber = $rollNumberProcess[$i]['renumberschoolnew'];
                array_push($a, $rollnumber);
            }

            if (count($a) > 0) {
                $maxrollnum = max($a);
                $newrolnumber = $maxrollnum + 1;
            }else{
                $newrolnumber = '1';
            }

            $checkifstudentreg = Addstudent::where('usernamesystem', $request->input('systemnumberstd'))->get();

            if(count($checkifstudentreg) > 0){
                return back()->with('error', 'Student already registered');
            }

        $className = Classlist::where(['id'=> $request->input('studentclass'), 'schoolid'=> Auth::user()->schoolid])->get();

        $schoolDetails = Addpost::find(Auth::user()->schoolid);

        $addstudent = new Addstudent;
        $addstudent->classid = $request->input('classidstd');
        $addstudent->schoolid = Auth::user()->schoolid;
        $addstudent->usernamesystem = $request->input('systemnumberstd');
        $addstudent->renumberschoolnew = $newrolnumber;
        $addstudent->studentsection =$studentSection;
        $addstudent->schoolsession = $schoolDetails->schoolsession;
        $addstudent->gender = $studentgender;
        $addstudent->studenthouse = $studenthouse;
        $addstudent->studentreligion = $sudentreligion;
        $addstudent->bloodgroup = $studentbloodgroup;
        $addstudent->studentclub = $studentclub;
        $addstudent->studentshift = $studentshift;
        $addstudent->studentfathername = $request->input('studentfathername');
        $addstudent->studentfathernumber = $request->input('studentfathernumber');
        $addstudent->studentmothersname = $request->input('studentmothersname');
        $addstudent->studentmothersnumber = $request->input('studentmothersnumber');
        $addstudent->studentpresenthomeaddress = $request->input('studentpresenthomeaddress');
        $addstudent->studentpermanenthomeaddress = $request->input('studentpermanenthomeaddress');
        $addstudent->dateOfBirth = $dateOfBirth;
        $addstudent->sessionstatus = "1";
        $addstudent->save(); 

        //asign student role
        
        $user = User::where('id', $request->input('systemnumberstd'))->first();
        // $userIdFinal = $userId[0]['id'];

        //update schoolId field
        $user->schoolid = Auth::user()->schoolid;;
        $user->role = "Student";
        $user->save();

        $user->assignRole('Student');

        return back()->with('success', 'Student added successfully');
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

    public function viewlist(){

        $studentList = Addstudent::where(['schoolid'=>Auth::user()->schoolid, 'sessionstatus'=>'0'])->get();

        return view('pages.students.viewstudents', compact('studentList'));
    }

    public function confirmReg(Request $request){

        $validator = Validator::make($request->all(),[
            'sessionquery' => 'required',
            'studentclass' => 'required',
            'studentsection' => 'required',
            'studentshift' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $userRegCheck = DB::table('addstudents')
        ->join('users', 'users.id', '=', 'addstudents.usernamesystem')
        ->join('classlists', 'classlists.id', '=', 'addstudents.classid')
        ->select('addstudents.*', 'users.firstname', 'users.middlename', 'users.lastname', 'classlists.classnamee')
        ->where(['addstudents.schoolsession' => $request->input('sessionquery'), 
        'addstudents.schoolid' => Auth::user()->schoolid, 
        'addstudents.classid' => $request->input('studentclass'), 
        'addstudents.studentsection' => $request->input('studentsection'),
        'addstudents.studentshift' => $request->input('studentshift')])
        ->get();



        return response()->json($userRegCheck, 200);
    }

    public function confirmRegNew(Request $request){

        $validator = Validator::make($request->all(),[
            'regNumberQuery' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $regNumber = $request->input('regNumberQuery');

        $userRegCheck = DB::table('addstudents')
        ->join('users', 'users.id', '=', 'addstudents.usernamesystem')
        ->select('addstudents.*', 'users.firstname', 'users.middlename', 'users.lastname')
        ->where(['addstudents.id' => $regNumber, 'addstudents.schoolid' => Auth::user()->schoolid])
        ->get();

        return response()->json($userRegCheck, 200);
    }

    public function getAllStudent(Request $request){

        $session = $request->input('studentSession');
        $studentclassMain = $request->input('studentclassMain');
        $studentsectionMain = $request->input('studentsectionMain');
        $studentshiftMain = $request->input('studentshiftMain');

        $allClassStudent = DB::table('addstudents') 
                        ->join('users', 'users.id', '=', 'addstudents.usernamesystem')
                        ->join('classlists', 'classlists.id', '=', 'addstudents.classid')
                        ->join('addsections', 'addsections.id','=','addstudents.studentsection')
                        ->select('addstudents.*', 'users.firstname', 'users.middlename', 'users.lastname', 'classlists.classnamee', 'addsections.sectionname')
                        ->where(['schoolsession' => $session, 'classid' => $studentclassMain, 'studentsection' => $studentsectionMain, 'studentshift' => $studentshiftMain])->get();

        $datemain = Carbon::now();
            $attDate = $datemain->toDateString();
    
            $getStudent = Studentattendance::where('datetoday', $attDate)->get();
    
            $a = array();
    
            for ($i=0; $i < count($getStudent); $i++) { 
                $attendanceRegNum = $getStudent[$i]['regnumber'];
                    array_push($a, $attendanceRegNum);
            }

        return response()->json([$allClassStudent, $a], 200);
    }

    public function studentAttendance(){

        $id = Auth::user()->schoolid;

        $userschool = Addpost::where('id', $id)->get();
        $classList = Classlist::where('schoolid', $id)->get();
        $addHouses = Addhouses::where('schoolid', $id)->get();
        $addSection = Addsection::where('schoolid', $id)->get();
        $addClub = AddClub::where('schoolid', $id)->get();
        // $addsubject = Addsubject::where('schoolid', $id)->get();
        // $gradeCheck = Addgrades::where('schoolid', $id)->get();

        $datemain = Carbon::now();
        $attDate = $datemain->toDateString();

        if (Auth::user()->role == "Teacher") {

            $addteachers = Addteachers::where(['schoolid' => $id, 'systemid' => Auth::user()->id])->get();

            $studentDetails = array(
                'userschool' => $userschool,
                'classList' => $classList,
                'addHouses' => $addHouses,
                'addSection' => $addSection,
                'addClub' => $addClub,
                'addteachers' => $addteachers,
                'attDate' => $attDate
            );

            // return $studentDetails['gradeCheck'][0]['classid'];

        } else {

            $studentDetails = array(
                'userschool' => $userschool,
                'classList' => $classList,
                'addHouses' => $addHouses,
                'addSection' => $addSection,
                'addClub' => $addClub,
                'attDate' => $attDate
            );
        }

        return view('pages.studentattendance')->with('studentDetails', $studentDetails);
    }

//---------------------------------------------------------------------------------------
//                         students attendance taken here
//---------------------------------------------------------------------------------------

    public function studentAtt(Request $request){

        $regNumber = $request->input('regNumber');

        $datemain = Carbon::now();
        $attDate = $datemain->toDateString();

        $datemainmonth = Carbon::now();
        $attDatemonth = $datemainmonth->toDateString();

        $dateExplode = explode("-", $attDatemonth);
        $monthdateOnly = $dateExplode[0]."-".$dateExplode[1];

        $getSystemNumber = Addstudent::where('id', $regNumber)->get();

        $systemNum = $getSystemNumber[0]["usernamesystem"];

        // return $systemNum;
        

        // $date = Carbon::createFromFormat('m/d/Y', $datemain);
        $attendancecheck = Studentattendance::where(['regnumber' => $regNumber, 'datetoday' => $attDate, 'schoolid' => Auth::user()->schoolid])->get();

        if (count($attendancecheck) > 0) {
            $msg = "already";
            return response()->json(array('msg' => $msg), 200);
        }else{
            $attendance = new Studentattendance();
            $attendance->regnumber = $regNumber;
            $attendance->systemid = $systemNum;
            $attendance->schoolid = Auth::user()->schoolid;
            $attendance->datetoday = $attDate;
            $attendance->monthtoday = $monthdateOnly;
            $attendance->save();

            $msg = "success";
            return response()->json(array('msg' => $msg), 200);
        }
    }

    public function viewallstudents(){
        $id = Auth::user()->schoolid;

        $userschool = Addpost::where('id', $id)->get();
        $classList = Classlist::where('schoolid', $id)->get();
        $addHouses = Addhouses::where('schoolid', $id)->get();
        $addSection = Addsection::where('schoolid', $id)->get();
        $addClub = AddClub::where('schoolid', $id)->get();
        // $addsubject = Addsubject::where('schoolid', $id)->get();
        // $gradeCheck = Addgrades::where('schoolid', $id)->get();

        $datemain = Carbon::now();
        $attDate = $datemain->toDateString();

        if (Auth::user()->role == "Teacher") {

            $addteachers = Addteachers::where(['schoolid' => $id, 'systemid' => Auth::user()->id])->get();

            $studentDetails = array(
                'userschool' => $userschool,
                'classList' => $classList,
                'addHouses' => $addHouses,
                'addSection' => $addSection,
                'addClub' => $addClub,
                'addteachers' => $addteachers,
                'attDate' => $attDate
            );

            // return $studentDetails['gradeCheck'][0]['classid'];

        } else {

            $studentDetails = array(
                'userschool' => $userschool,
                'classList' => $classList,
                'addHouses' => $addHouses,
                'addSection' => $addSection,
                'addClub' => $addClub,
                'attDate' => $attDate
            );
        }

            return view('pages.viewattendancestudents')->with('studentDetails', $studentDetails);
    }

    public function viewatstudent(Request $request){
        
        $session = $request->input('studentSession');
            $studentclassMain = $request->input('studentclassMain');
            $studentsectionMain = $request->input('studentsectionMain');
            $studentshiftMain = $request->input('studentshiftMain');
            $datehist = $request->input('datehist');

            $allClassStudent = DB::table('addstudents') 
            ->join('users', 'users.id', '=', 'addstudents.usernamesystem')
            ->join('classlists', 'classlists.id','=', 'addstudents.classid')
            ->select('addstudents.*', 'users.firstname', 'users.middlename', 'users.lastname', 'classlists.classnamee')
            ->where(['schoolsession' => $session, 'classid' => $studentclassMain, 'studentsection' => $studentsectionMain, 'studentshift' => $studentshiftMain])->get();

            $datemain = Carbon::now();
           $attDate = $datemain->toDateString();

            $getStudent = Studentattendance::where('datetoday', $datehist)->get();

            $a = array();

            for ($i=0; $i < count($getStudent); $i++) { 
                $attendanceRegNum = $getStudent[$i]['regnumber'];
                    array_push($a, $attendanceRegNum);
            }

            return response()->json([$allClassStudent, $a], 200);
        }

        public function getExamsMarks(){

            $id = Auth::user()->schoolid;

            $userschool = Addpost::where('id', $id)->get();
            $classList = Classlist::where('schoolid', $id)->get();
            $addHouses = Addhouses::where('schoolid', $id)->get();
            $addSection = Addsection::where('schoolid', $id)->get();
            $addClub = AddClub::where('schoolid', $id)->get();
            $addstudent = Addstudent::where(['usernamesystem' => Auth::user()->id, 'schoolid' => $id])->get();

            $studentregNumber = $addstudent[0]['id'];
            $studentcurrentsession = $addstudent[0]['schoolsession'];

            // return $studentcurrentsession;

            $addmarks = DB::table('addmarks')
            ->join('addsubjects', 'addsubjects.id', '=', 'addmarks.subjectid')
            ->select('addmarks.*', 'addsubjects.subjectcode', 'addsubjects.subjectname')
            ->where(['addmarks.regno' => $studentregNumber, 'addmarks.schoolid' => Auth::user()->schoolid, 'addmarks.session' => $studentcurrentsession])
            ->get();

            // return $addmarks;
    
            $studentDetails = array(
                'userschool' => $userschool,
                'classList' => $classList,
                'addHouses' => $addHouses,
                'addSection' => $addSection,
                'addClub' => $addClub,
                'addmarks' => $addmarks
            );

            

            return view('pages.exammarks_student')->with('studentDetails', $studentDetails);
        }

        public function specificresult(Request $request){

            $validator = Validator::make($request->all(),[
                'querysession' => 'required',
                'schoolterm' => 'required',
                'studentclass' => 'required',
            ]);
    
            if ($validator->fails()) {
                return back()->with('error', 'An error occured. Check that all fields are entered correctly');
            }

            // return $request->input();
            
            $id = Auth::user()->schoolid;
            $addstudent = Addstudent::where(['usernamesystem' => Auth::user()->id, 'schoolid' => $id])->get();

            $studentregNumber = $addstudent[0]['id'];
            $studentcurrentsession = $request->input('querysession');

            // return $studentcurrentsession;

            $addmarks = DB::table('addmarks')
            ->join('addsubjects', 'addsubjects.id', '=', 'addmarks.subjectid')
            ->select('addmarks.*', 'addsubjects.subjectcode', 'addsubjects.subjectname')
            ->where(['addmarks.regno' => $studentregNumber, 'addmarks.schoolid' => Auth::user()->schoolid, 'addmarks.session' => $studentcurrentsession, 'addmarks.term' => $request->input('schoolterm'), 'addmarks.classid' => $request->input('studentclass')])
            ->get();

            return response()->json($addmarks, 200);
        }

//-------------------------------------------------------------------------------------
//        confirm user registration check if a user has created an account
//------------------------------------------------------------------------------------

        public function verifyuserregistration(Request $request){

            $validator = Validator::make($request->all(),[
                // 'schoolsession' => 'required',
                'studentclass' => 'required',
                'studentsection' => 'required',
                'studentshift' => 'required',
                'systemnumber' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()->all()]);
            }

            $userdetails = User::where(['id' => $request->input('systemnumber')])->first();

            if ($userdetails->hasAnyRole(Role::all())) {
                return response()->json("already", 200);
            }


            return response()->json($userdetails, 200);
        }

//----------------------------------------------------------------------------------------
//                      create an account for a student manually
//----------------------------------------------------------------------------------------

        public function regUserManuallyAdmin(Request $request){

            $validatedData = $request->validate([
                'email' => 'required|string|email|max:255',
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'middlename' => 'required|string',
                'password' => 'required|min:8|string',
                'phonenumber' => 'required|string',
            ]);

            try {

                $adduser = new User();
                $adduser->firstname = $request->input('firstname');
                $adduser->middlename = $request->input('middlename');
                $adduser->lastname = $request->input('lastname');
                $adduser->email = $request->input('email');
                $adduser->phonenumber = $request->input('phonenumberc');
                $adduser->password = Hash::make($request->input('password'));
                $adduser->save();

                return response()->json($userdetails, 200);

            } catch (Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    $userdetails = "0";
                    return response()->json($userdetails, 200);
                }
            }
        }
}
