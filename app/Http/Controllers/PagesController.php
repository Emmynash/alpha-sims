<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Addpost;
use App\User;
use App\Classlist;
use App\Addhouses;
use App\Addsection;
use App\AddClub;
use App\Addmarks;
use App\Addgrades;
use App\Addgrades_sec;
use App\Addhouse_sec;
use App\Addsection_sec;
use App\Addstudent_sec;
use App\Addsubject_sec;
use App\AdmissionsTbl;
use App\Classlist_sec;
use App\FormTeachers;
use App\TeacherSubjects;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Redirect;
use Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PagesController extends Controller
{
    public function index(){



            // DB::transaction(function()
            // {
                



            //     $allList = AdmissionsTbl::all();

            //     //create email address for students dummy.. firstname plus serial number
        
            //     $arrayList = array();
            //     $passwordMain = Hash::make('password');
        
            //     for ($i=0; $i < $allList->count(); $i++) { 
        
                    
                    
        
            //         $explodeadmissionno = explode('/', $allList[$i]['AdmNo']);
        
            //         $dummyemailis = $allList[$i]['Surname'].$explodeadmissionno[3]."@gmail.com";
        
        
        
            //         $checkIfEntered = User::where('email', $dummyemailis)->get();
        
        
            //         if (count($checkIfEntered) < 1) {
                    
        
            //         //student name
            //         $firstname = $allList[$i]['Surname'];
            //         $middlename = $allList[$i]['Othernames'];
            //         $explode = explode(",", $allList[$i]['PGPhoneNo']);
            //         $phone = $explode[0];
            //         $fathername = $allList[$i]['PGName'];
            //         $address = $allList[$i]['PGHomeAdd'];
            //         $dateofbirth = $allList[$i]['BirthDate'];
            //         $dateAdmited = $allList[$i]['DateAdm'];
            //         $states = $allList[$i]['State'];
            //         $lga = $allList[$i]['LGA'];
            //         $hometown = $allList[$i]['HomeTown'];
            //         $class = $allList[$i]['ClassAdm'];
            //         $houses = $allList[$i]['House'];
            //         $religion = $allList[$i]['Religion'];
            //         $studentHouse = Addhouse_sec::where(['schoolid'=>"8", 'housename'=>$houses])->first();
            //         $studentHouseMain = $studentHouse->id;
            //         $gender = $allList[$i]['Gender'];
        
        
        
        
        
            //         //get student section
        
            //         $section = $allList[$i]['ClassAdm'];
        
            //         $explodeClass = str_split($section);
        
            //         if (count($explodeClass) > 5) {
            //             $getsection = Addsection_sec::where(['schoolid'=>"8", 'sectionname'=>$explodeClass[5]])->first();
        
            //             $studentclass = $explodeClass[0].$explodeClass[1].$explodeClass[2].$explodeClass[4];
        
            //         }else{
            //             $getsection = Addsection_sec::where(['schoolid'=>"8", 'sectionname'=>$explodeClass[4]])->first();
        
            //             $studentclass = $explodeClass[0].$explodeClass[1].$explodeClass[2].$explodeClass[3];
            //         }
        
            //         $studentsectionidmain = $getsection->id;
        
            //         //get class id
            //         $getStudentClass = Classlist_sec::where(['schoolid'=>"8", "classname"=>$studentclass])->first();
        
            //         $classidMain = $getStudentClass->id;
        
        
        
            //         //create account for user now
        
            //         $createUser = new User();
            //         $createUser->firstname = $firstname;
            //         $createUser->lastname = $middlename;
            //         $createUser->email = $dummyemailis;
            //         $createUser->schoolid = "8";
            //         $createUser->role = "Student";
            //         $createUser->phonenumber = $phone;
            //         $createUser->password = $passwordMain;
            //         $createUser->save();
        
        
        
            //         $rollNumberProcess = Addstudent_sec::where(['schoolid' => "8", 'classid' => $classidMain])->get();
            
            
            //         $a = array();
        
            //         for ($i=0; $i < count($rollNumberProcess); $i++) {
                        
            //             $rollnumber = $rollNumberProcess[$i]['renumberschoolnew'];
            //             array_push($a, $rollnumber);
            //         }
        
            //         if (count($a) > 0) {
            //             $maxrollnum = max($a);
            //             $newrolnumber = $maxrollnum + 1;
            //         }else{
            //             $newrolnumber = '1';
            //         }
        
        
        
            //         $Addstudent = new Addstudent_sec();
            //         $Addstudent->classid = $classidMain;
            //         $Addstudent->schoolid = "8";
            //         $Addstudent->usernamesystem = $createUser->id;
            //         $Addstudent->renumberschoolnew = $newrolnumber;
            //         $Addstudent->nationality = "Nigerian";
            //         $Addstudent->studentsection = $studentsectionidmain;
            //         $Addstudent->schoolsession = "2020/2021";
            //         $Addstudent->gender = $gender;
            //         $Addstudent->studenthouse = $studentHouseMain;
            //         $Addstudent->studentreligion = $religion;
            //         $Addstudent->studentfathername = $fathername;
            //         $Addstudent->studentfathernumber = $phone;
            //         $Addstudent->studentpresenthomeaddress = $address;
            //         $Addstudent->studentpermanenthomeaddress = $address;
            //         $Addstudent->dateOfBirth = $dateofbirth;
            //         $Addstudent->sessionstatus = 0;
            //         $Addstudent->admission_no = $allList[$i]['AdmNo'];
            //         $Addstudent->states = $states;
            //         $Addstudent->lga = $lga;
            //         $Addstudent->hometown = $hometown;
            //         $Addstudent->dateadmited = $dateAdmited;
            //         $Addstudent->save();
            
            //         //asign student role
            
            //         $user = User::find($createUser->id);
            
            //         $user->assignRole('Student');
        
        
        
            //             array_push($arrayList, $getStudentClass->id);
        
            //     }
        
            //         }






            // });




            // return "Success";

        
        if(Auth::guest()){
            
        $addpost = Addpost::where('status', 'Approved')->get();

        return view('pages.index')->with('addpost', $addpost);
            
        }else{
            return redirect('/home');
        }
    }

    public function addTerm(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'term' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'term field is empty');
        }

        $addTerm = Addpost::find(Auth::user()->schoolid);
        $addTerm->term = (int)$request->term;
        $addTerm->save();

        return back()->with('success', 'process successfull');
    }

    public function setUpSchool(){

        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('pages.schoolsetup', compact('schooldetails'));
    }

    public function updateSchoolInitial(Request $request){

        $schoolIdAsigned = $request->input('initialvalue');
        $schoolInitialValue = $request->input('schoolInitialValue');

        $schoolIdProcess = Addpost::where('id', Auth::user()->schoolid)->get();

        $id = $schoolIdProcess[0]['id'];

        $addSchoolInitial = Addpost::find($id);
        $addSchoolInitial->shoolinitial = strtoupper($schoolIdAsigned);
        $addSchoolInitial->save();

        $msg = "success";

        return response()->json(array("msg" => $schoolIdAsigned), 200);
    }

    public function addclasslist(Request $request){

        $classlist = $request->input('classlist');

        if (strlen($classlist) == "") {
            $msg = "failed";
        }else{
            $classlistarray = explode(",", $classlist);

            $classCount = count($classlistarray);
    
            for ($x = 0; $x <= $classCount-1; $x++) {
            //    $msg = $classlistarray[2];
               $classListdata = new Classlist;
               $classListdata->schoolid = Auth::user()->schoolid;
               $classListdata->classnamee = $classlistarray[$x];
               $classListdata->studentcount = "0";
               $classListdata->save();
              }
    
              $msg = "success";
    
            return response()->json(array("msg" => $msg), 200);
        }
    }

    public function addhouses(Request $request){

        $houselist = $request->input('houselist');

        $houselistarray = explode(",", $houselist);

        $houseCount = count($houselistarray);

        for ($x = 0; $x <= $houseCount-1; $x++) {
        //    $msg = $classlistarray[2];
           $housesListdata = new Addhouses;
           $housesListdata->schoolid = Auth::user()->schoolid;
           $housesListdata->housename = $houselistarray[$x];
           $housesListdata->save();
          }

          $msg = "success";


        return response()->json(array("msg" => $msg), 200);

    }

    public function addsection(Request $request){
        $sectionlist = $request->input('sectionlist');


        $sectionlistarray = explode(",", $sectionlist);

        $sectionCount = count($sectionlistarray);

        for ($x = 0; $x <= $sectionCount-1; $x++) {
        //    $msg = $classlistarray[2];
           $sectionListdata = new Addsection;
           $sectionListdata->schoolid = Auth::user()->schoolid;
           $sectionListdata->sectionname = $sectionlistarray[$x];
           $sectionListdata->save();
          }

        $msg = "success";


        return response()->json(array("msg" => $msg), 200);
    }

    public function addclublist(Request $request){

        $clublist = $request->input('clublist');

        $clublistarray = explode(",", $clublist);

        $clubCount = count($clublistarray);

        for ($x = 0; $x <= $clubCount-1; $x++) {
        //    $msg = $classlistarray[2];
           $clubListdata = new Addclub;
           $clubListdata->schoolid = Auth::user()->schoolid;
           $clubListdata->clubname = $clublistarray[$x];
           $clubListdata->save();
          }

        $msg = "success";


        return response()->json(array("msg" => $msg), 200);

    }

    public function addsession(Request $request){

        $validator = Validator::make($request->all(),[
            'schoolsessionSetter' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $updatesession = Addpost::find(Auth::user()->schoolid);
        $updatesession ->schoolsession = $request->input('schoolsessionSetter');
        $updatesession->save();

        $msg = "1";

        return response()->json(array("result" => $msg), 200);
    }

    public function grades(){

        $id = Auth::user()->schoolid;


        $userschool = Addpost::where('id', $id)->get();
        $classList = Classlist::where('schoolid', $id)->get();
        $addHouses = Addhouses::where('schoolid', $id)->get();
        $addSection = Addsection::where('schoolid', $id)->get();
        $addClub = AddClub::where('schoolid', $id)->get();
        $addgrades = Addgrades::where('schoolid', $id)->get();

        

        $studentDetails = array(
            'userschool' => $userschool,
            'addgrades' => $addgrades
        );

        // return $studentDetails['addgrades'];

        return view('pages.grades.grade')->with('studentDetails', $studentDetails);
    }

    public function submitMark(Request $request){

        $validatedData = $request->validate([
            'gpafor' => 'required',
            'grade' => 'required',
            'point' => 'required',
            'markfrom' => 'required',
            'markto' => 'required',
        ]);

        $addmarks = new Addgrades();
        $addmarks->gpafor = $request->input('gpafor');
        $addmarks->schoolid = Auth::user()->schoolid;
        $addmarks->gpaname = $request->input('grade');
        $addmarks->point = $request->input('point');
        $addmarks->marksfrom = $request->input('markfrom');
        $addmarks->marksto = $request->input('markto');
        $addmarks->save();

        return back()->with('success', 'record added successfully');
    }
    
    public function submitMark_sec(Request $request){

        // return $request->input();

        $validatedData = $request->validate([
            'gpafor' => 'required',
            'grademain' => 'required',
            'marksfrom' => 'required',
            'marksto' => 'required',
            'type' => 'required'
        ]);

        $schooldetails = Addpost::find(Auth::user()->schoolid);

        if ($schooldetails->schooltype == "Primary") {

            $addgrades_sec = Addgrades_sec::where(['schoolid'=>Auth::user()->schoolid, 'type'=>0, 'gpaname'=>$request->grademain])->get();
    
            if ($addgrades_sec->count() > 0) {
                return back()->with('error', 'duplicate entry');
            }

            $addgrades_sec = Addgrades_sec::where(['schoolid'=>Auth::user()->schoolid, 'type'=>0, 'marksfrom'=>$request->marksfrom, 'marksto'=>$request->marksto])->get();

            if ($addgrades_sec->count() > 0) {
                return back()->with('error', 'marks range already entered');
            }

            $addmarks = new Addgrades_sec();
            $addmarks->gpafor = $request->input('gpafor');
            $addmarks->schoolid = Auth::user()->schoolid;
            $addmarks->gpaname = $request->input('grademain');
            $addmarks->marksfrom = $request->input('marksfrom');
            $addmarks->marksto = $request->input('marksto');
            $addmarks->type = 0;
            $addmarks->point = $request->point;
            $addmarks->save();
            
        }else{
            if ($request->type == "2") {
                $validatedData = $request->validate([
                    'point' => 'required',
                ]);
    
                $addgrades_sec = Addgrades_sec::where(['schoolid'=>Auth::user()->schoolid, 'type'=>2, 'gpaname'=>$request->grademain])->get();
    
                if ($addgrades_sec->count() > 0) {
                    return back()->with('error', 'duplicate entry');
                }
    
                $addgrades_sec = Addgrades_sec::where(['schoolid'=>Auth::user()->schoolid, 'type'=>2, 'marksfrom'=>$request->marksfrom, 'marksto'=>$request->marksto])->get();
    
                if ($addgrades_sec->count() > 0) {
                    return back()->with('error', 'marks range already entered');
                }
    
                $addmarks = new Addgrades_sec();
                $addmarks->gpafor = $request->input('gpafor');
                $addmarks->schoolid = Auth::user()->schoolid;
                $addmarks->gpaname = $request->input('grademain');
                $addmarks->marksfrom = $request->input('marksfrom');
                $addmarks->marksto = $request->input('marksto');
                $addmarks->type = $request->type;
                $addmarks->point = $request->point;
                $addmarks->save();
    
            }else{
    
                $addgrades_sec = Addgrades_sec::where(['schoolid'=>Auth::user()->schoolid, 'type'=>1, 'gpaname'=>$request->grademain])->get();
    
                if ($addgrades_sec->count() > 0) {
                    return back()->with('error', 'duplicate entry');
                }
    
    
                $addgrades_sec = Addgrades_sec::where(['schoolid'=>Auth::user()->schoolid, 'type'=>2, 'marksfrom'=>$request->marksfrom, 'marksto'=>$request->marksto])->get();
    
                if ($addgrades_sec->count() > 0) {
                    return back()->with('error', 'marks range already entered');
                }
    
                $addmarks = new Addgrades_sec();
                $addmarks->gpafor = $request->input('gpafor');
                $addmarks->schoolid = Auth::user()->schoolid;
                $addmarks->gpaname = $request->input('grademain');
                $addmarks->point = "NA";
                $addmarks->marksfrom = $request->input('marksfrom');
                $addmarks->marksto = $request->input('marksto');
                $addmarks->type = $request->type;
                $addmarks->save();
    
            }
        }
        





        return back()->with('success', 'record added successfully');
    }

    public function deleteGrade(Request $request){

        $entryid = $request->input('entryId');    

        $deletemarks = Addgrades::find($entryid);
        $deletemarks->delete();

        return back()->with('success', 'record deleted successfully');
    }

    public function fetchtoschoolsetup(Request $request){

        $id = Auth::user()->schoolid;

        $classList = Classlist::where('schoolid', $id)->get();

        // $msg = "1";

        return response()->json($classList, 200);

    }
    
    public function tryOurDemo(Request $request){
        
        $validatedData = $request->validate([
            'fullname' => 'required',
            'emailaddress' => 'required',
            'phonenumber' => 'required|numeric|min:11',
            'schoolname' => 'required',
            'schoolsize' => 'required',
        ]);
        
        $emailaddress = $request->input('emailaddress');
        $fullname = $request->input('fullname');
        $phonenumber = $request->input('phonenumber');
        $schoolname = $request->input('schoolname');
        $schoolsize = $request->input('schoolsize');
        
        
        $to = "uhweka@gmail.com";
        $subject = "Request For a Demo with alpha-sim";
        $msg = "Hello my name is".$fullname." from".$schoolname ." I am requesting a demo account with alpha-sims. My school have a size of".$schoolsize."You can contact me on" .$phonenumber." or via email". $emailaddress."";
        $txt = wordwrap($msg,70);;
        $headers = "From:".$emailaddress. "\r\n" .
        "CC: somebodyelse@example.com";
        
        mail($to,$subject,$txt,$headers);
        
        return back()->with('success', 'details submitted. Our customer support will contact you shortly');
        
    }
    
    public function manageStaff(){

        $role = Role::all();

        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('secondary.managestaff.managestaff', compact('schooldetails'));
    }

    public function viewStaff($id)
    {
        $detUserDetails = User::find($id);

        $formClasses = FormTeachers::join('classlist_secs', 'classlist_secs.id','=','form_teachers.class_id')
            ->join('addsection_secs', 'addsection_secs.id','=','form_teachers.form_id')
            ->where('teacher_id', $id)
            ->select('form_teachers.*', 'classlist_secs.classname', 'addsection_secs.sectionname')->get();

        $teachersSubject = TeacherSubjects::join('addsubject_secs', 'addsubject_secs.id','=','teacher_subjects.subject_id')
                            ->join('addsection_secs', 'addsection_secs.id','=','teacher_subjects.section_id') 
                            ->join('classlist_secs', 'classlist_secs.id','=','teacher_subjects.classid')
                            ->where('user_id', $id)
                            ->select('teacher_subjects.*', 'addsubject_secs.subjectname', 'addsection_secs.sectionname', 'classlist_secs.classname')
                            ->get(); 

        return response()->json(['detUserDetails'=>$detUserDetails, 'formClasses'=>$formClasses,'teachersSubject'=>$teachersSubject ]); 
    }

    public function manageStaffRole(Request $request){

        $validator = Validator::make($request->all(),[
            'staffregnorole'=>'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $users = User::where(['id'=> $request->input('staffregnorole'), 'schoolid'=>Auth::user()->schoolid])->get();

        if (count($users) > 0) {
            return response()->json(['userdetails'=>$users]);
        }else{
            
            $users2 = User::where(['id'=> $request->input('staffregnorole'), 'schoolid'=>NULL, 'role'=>NULL])->get();
            
            if(count($users2) > 0){
                
                return response()->json(['userdetails'=>$users2]);
                
            }else{
                
                return response()->json(['none'=>'none']);
                
            }
        }
        
        
    }

    public function allocateroletostaff(Request $request){

        $validator = Validator::make($request->all(),[
            'systemnumberrole'=>'required|string',
            'roleselect'=>'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $user = User::find($request->systemnumberrole);
        $roles = Role::pluck('name')->toArray();
        $user->hasRole($roles);



        if ($user->hasRole($roles)) {
            return response()->json(['notallow'=>'notallow']);
        }

        $userrole = User::find($request->systemnumberrole);
        $userrole->assignRole($request->roleselect);

        $updaterole = User::find($request->input('systemnumberrole'));
        $updaterole->schoolid = Auth::user()->schoolid;
        $updaterole->save();

        return response()->json(['success'=>'success']);

        $checkstudentrole = User::where(['id'=>$request->input('systemnumberrole'), 'role'=>'Student', 'schoolid'=>Auth::user()->schoolid])->get();

        if (count($checkstudentrole) > 0) {
            return response()->json(['notallow'=>'notallow']);
        }

        $checkadminrole = User::where(['id'=>$request->input('systemnumberrole'), 'role'=>'Admin', 'schoolid'=>Auth::user()->schoolid])->get();

        if (count($checkadminrole) > 0) {
            return response()->json(['notallow'=>'notallow']);
        }

        $checksuperadminrole = User::where(['id'=>$request->input('systemnumberrole'), 'role'=>'SuperAdmin'])->get();

        if (count($checksuperadminrole) > 0) {
            return response()->json(['notallow'=>'notallow']);
        }

        return response()->json(['success'=>'success']);
    }

    public function manageStaffDetails()
    {
        $staffList = User::where('schoolid', Auth::user()->schoolid)->get();

        $staffListMain = array();

        for ($i=0; $i < count($staffList); $i++) { 

            $name = $staffList[$i]['firstname']." ".$staffList[$i]['middlename']." ".$staffList[$i]['lastname'];
            $systemNumber = $staffList[$i]['id'];
            $role = $staffList[$i]->getRoleNames()[0];
            $date = $staffList[$i]['updated_at'];

            $userObjs = (object) ['name' => $name, 'systemno'=>$systemNumber, 'role'=>$role, 'date'=>$date];
            if ($role != "Student") {
                array_push($staffListMain, $userObjs);
            }
            
        }

        $role = Role::all();

        return response()->json(['stafflist'=>$staffListMain, 'role'=>$role]);
    }


}
