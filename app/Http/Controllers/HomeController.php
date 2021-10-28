<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Addpost;
use App\User;
use App\Classlist;
use App\Classlist_sec;
use App\Addhouses;
use App\Addsection;
use App\AddClub;
use App\Addstudent;
use App\Addsubject;
use App\Addteachers;
use App\Addgrades;
use App\Addteachers_sec;
use App\Addstudent_sec;
use App\Addsubject_sec;
use App\CalenderModel;
use App\TeacherSubjects;
use App\TeacherSubjectPris;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        Log::info('This is some useful information.');

        
        if (Auth::user()->role == "SuperAdmin") {
            return redirect('/superadmin');
        }

        $id = Auth::user()->schoolid;

        $userschool = Addpost::where('id', $id)->get();

        if (count($userschool) < 1) {

            return view('home')->with("userschool", $userschool);
        }elseif($userschool[0]['status'] == "Pending"){
            // return $userschool;
            return view('home')->with("userschool", $userschool);
        }

        if ($userschool[0]['schooltype'] == "Primary") {
                $classList = Classlist_sec::where('schoolid', $id)->get();
                $addHouses = User::where('id', $id)->get();
                $addSection = User::where('id', $id)->get();
                $addClub = User::where('id', $id)->get();
                $addteachers = Addteachers_sec::where(['schoolid' => $id])->get();
                $addsubject = Addsubject_sec::where('schoolid', $id)->get();
                $addgrades = Addgrades::where('schoolid', $id)->get();
                // $message = Message::where(['schoolid'=> Auth::user()->schoolid, 'senderid'=>Auth::user()->id])->get();
                
                $datemain = Carbon::now();
                $attDate = $datemain->toDateString();

                $dateExplode = explode("-", $attDate);
                $monthdateOnly = $dateExplode[0]."-".$dateExplode[1];
                // return $monthdateOnly;
                
                

                $studentAttendance = DB::table('studentattendances')
                                    ->join('addstudents', 'addstudents.id','=','studentattendances.regnumber')
                                    ->select('studentattendances.*', 'addstudents.id as adnum')
                                    ->where(['studentattendances.schoolid' => Auth::user()->schoolid, 'studentattendances.systemid' => Auth::user()->id, 'studentattendances.monthtoday'=>$monthdateOnly])->get();
                    // return $studentAttendance;
                
                $idf = $studentAttendance->toJson();
                $studentAttendancemain = json_decode($idf, true);

                $todayMonth = '';
                $monthcount = '';
                $daysarray = array();

                if (count($studentAttendance) > 0) {
                    $monthlyDate = $studentAttendancemain[0]['monthtoday'];

                    $monthlyMain = explode('-', $monthlyDate);

                    $mainValue = $monthlyMain[1];

                    $jan = array("month" => "01", "days" => "31");
                    $feb = array("month" => "02", "days" => "29");
                    $mar = array("month" => "03", "days" => "31");
                    $april = array("month" => "04", "days" => "30");
                    $may = array("month" => "05", "days" => "30");
                    $june = array("month" => "06", "days" => "31");
                    $july = array("month" => "07", "days" => "31");
                    $august = array("month" => "08", "days" => "31");
                    $sept = array("month" => "09", "days" => "30");
                    $october = array("month" => "10", "days" => "31");
                    $nov = array("month" => "11", "days" => "30");
                    $dec = array("month" => "12", "days" => "31");

                    $month = array($jan,$feb,$mar,$april,$may,$june,$july,$august,$sept,$october,$nov,$dec);

                    // return $month;



                    for ($i=0; $i < count($month); $i++) { 
                        $monthMain = $month[$i]["month"];
                        // echo $monthMain;
                        if ($monthMain == $mainValue) {
                            $todayMonth = $monthMain;
                            $monthcount = $month[$i]["days"];
                        } 
                    }

                    

                    for ($i=0; $i < count($studentAttendancemain); $i++) { 

                        $datetoday = $studentAttendancemain[$i]['datetoday'];

                        $datetodayexplode = explode('-', $datetoday);

                        $attendanceRegNum = $datetodayexplode[2];
                        array_push($daysarray, $attendanceRegNum);
                        // echo $datetoday;
                    }

                }

                

                // return $daysarray;
                $user = User::find(Auth::user()->id);
               $user->hasRole('Teacher');

                // if ($user->hasRole('Teacher')) {

                    

                //     // $classidTeacher = $addteachers[0]['classid'];

                //     // $addstudents = DB::table('addstudents')
                //     //                 ->join('users', 'users.id', '=', 'addstudents.usernamesystem')
                //     //                 ->join('addhouses', 'addhouses.id', '=', 'addstudents.studenthouse')
                //     //                 ->select('addstudents.*', 'users.firstname', 'users.middlename', 'users.lastname', 'addhouses.housename')
                //     //                 ->where(['addstudents.schoolid'=> $id, 'addstudents.classid' => $classidTeacher])->get();
                    
                //     // $subjects = DB::table('addsubjects')
                //     //           ->join("classlists", "classlists.id","=","addsubjects.classid")
                //     //           ->where("teacherid", Auth::user()->id)
                //     //           ->select("addsubjects.*", "classlists.classnamee", "classlists.studentcount")->get();

                //     return $subjects = TeacherSubjectPris::join('addsubjects', 'addsubjects.id','=','teacher_subject_pris.subject_id')
                //               ->join('classlists', 'classlists.id','=', 'teacher_subject_pris.classid')
                //               ->select('teacher_subject_pris.*', 'addsubjects.subjectname', 'addsubjects.subjectcode', 'classlists.classnamee')
                //               ->where('teacher_subject_pris.user_id', Auth::user()->id)->get();
                    
                //     $addteacher = Addteachers::leftjoin("classlists", "classlists.id","=","addteachers.formteacher")
                //                 ->leftjoin("addsections", "addsections.id","=","addteachers.formsection")
                //                 ->join('addposts', 'addposts.id','=','addteachers.schoolid')
                //                 ->where("addteachers.systemid", Auth::user()->id)
                //                 ->select("addteachers.*", "classlists.classnamee", "addsections.sectionname", 'addposts.schoolname', 'addposts.schooltype')->first();
                
                                    
                //     return view('pages.teacher.teacher_dash', compact('subjects', 'addteacher'));

                // } 



                $user = User::find(Auth::user()->id);
                $user->hasRole('Teacher');
            
            if ($user->hasRole('Teacher')) {

                $schoolid = Auth::user()->schoolid;

                $getFormClass = Addteachers_sec::where('systemid', Auth::user()->id)->get();

                if ($getFormClass->count() <1) {
                    $formTeacher = "";
                }else{
                    if ($getFormClass[0]['formteacher'] == "") {
                        $formTeacher = "";
                    }else{
                        $formClass = Classlist_sec::where('id', $getFormClass[0]['formteacher'])->get();
    
                        $formTeacher = $formClass[0]['classname'];
                    }

                }



                if ($getFormClass->count() <1) {
                    $allocatedSubject = [];
                }else{
                    if ($getFormClass[0]['subject'] == "") {//ewrkejkwjekwjekwjekwjekwe
                        $allocatedSubject = [];
                    }else{
                        $allocatedSubject = $getFormClass[0]['teachclass'];
    
                        $studentsInClass = DB::table('addstudent_secs')
                                            ->join('users', 'users.id','=','addstudent_secs.usernamesystem') 
                                            ->where('classid', $allocatedSubject)
                                            ->select('addstudent_secs.*', 'users.firstname', 'users.middlename', 'users.lastname')->get();
    
    
                    }
                }



                $getTeacherDetails = Addteachers_sec::join('addposts', 'addposts.id','=','addteachers_secs.schoolid')
                                    ->where(['addteachers_secs.schoolid'=>$schoolid, 'addteachers_secs.systemid'=>Auth::user()->id])
                                    ->select('addteachers_secs.*', 'addposts.schoolname')->first();
                

                
                $getTeacherId = Addteachers_sec::where('systemid', Auth::user()->id)->first();
                

                
                $subjectTeacherOffer = TeacherSubjects::join('addsection_secs', 'addsection_secs.id','=','teacher_subjects.section_id')
                                        ->select('teacher_subjects.*', 'addsection_secs.sectionname')
                                        ->where('user_id', Auth::user()->id)->get();
                
                $schooldetails = Addpost::find(Auth::user()->schoolid);

                

                return view('secondary.teachers.teacher_dash',compact('getTeacherDetails', 'formTeacher', 'subjectTeacherOffer', 'schooldetails'));
            }




                $user = User::find(Auth::user()->id);
                $user->hasRole('Student');
                
                if($user->hasRole('Student')) {

                    $addstudentprocess = DB::table('addstudents')
                    ->join('users', 'users.id', '=', 'addstudents.usernamesystem')
                    ->join('addhouses', 'addhouses.id', '=', 'addstudents.studenthouse')
                    ->join('classlists', 'classlists.id', '=', 'addstudents.classid')
                    ->join('addposts', 'addposts.id', '=', 'addstudents.schoolid')
                    ->select('addstudents.*', 'users.firstname', 'users.middlename', 'users.lastname', 'users.id as userid', 'classlists.classnamee', 'addposts.schoolname', 'users.profileimg', 'users.role')
                    ->where(['addstudents.schoolid'=> $id, 'addstudents.usernamesystem' => Auth::user()->id])->get();

                    if (count($addstudentprocess) > 0) {
                        $idf = $addstudentprocess->toJson();
                        $addstudent = json_decode($idf, true)[0];

                        // $addstudent = Addstudent::where('schoolid', $id)->get();

                        $addsubject = Addsubject::where(['schoolid' => $id, 'classid' => $addstudent['classid']])->get();
            
                        $studentDetails = array(
                            'userschool' => $userschool,
                            'classList' => $classList,
                            'addHouses' => $addHouses,
                            'addSection' => $addSection,
                            'addClub' => $addClub,
                            'addStudent' => $addstudent,
                            'addteachers' => $addteachers,
                            'addsubject' => $addsubject,
                            'addgrades' => $addgrades,
                            'todayMonth' => $todayMonth,
                            'monthcount' => $monthcount,
                            'daysarray' => $daysarray
                        );
                        // return $studentDetails['daysarray'];
                    }else{
            
                        $addstudent = Addstudent::where('schoolid', $id)->get();
            
                        $studentDetails = array(
                            'userschool' => $userschool,
                            'classList' => $classList,
                            'addHouses' => $addHouses,
                            'addSection' => $addSection,
                            'addClub' => $addClub,
                            'addStudent' => $addstudent,
                            'addteachers' => $addteachers,
                            'addsubject' => $addsubject,
                            'addgrades' => $addgrades
                        );
                        // return $studentDetails['addgrades'][0];
                        
                        
                    }
                    return view('pages.index_dash')->with('studentDetails', $studentDetails);

                }

                $user = User::find(Auth::user()->id);
                $user->hasRole('Bursar');
                
                if ($user->hasRole('Bursar')) {

                    return view('pages.accounting.bursar');
                    
                }

                


                $user = User::find(Auth::user()->id);
                $user->hasRole('Supervisor');

                if($user->hasRole('Supervisor')){
                    
                   
                    
                    return view('pages.supervisor_dash');
                    
                }
                $user = User::find(Auth::user()->id);
                $user->hasRole('Admin');

                if($user->hasRole('Admin')){
                    
                    $addstudent = Addstudent::where('schoolid', $id)->get();
            
                        $studentDetails = array(
                            'userschool' => $userschool,
                            'classList' => $classList,
                            'addHouses' => $addHouses,
                            'addSection' => $addSection,
                            'addClub' => $addClub,
                            'addStudent' => $addstudent,
                            'addteachers' => $addteachers,
                            'addsubject' => $addsubject,
                            'addgrades' => $addgrades
                        );
                    
                    return view('pages.index_dash')->with('studentDetails', $studentDetails);
                    
                }

                $user = User::find(Auth::user()->id);
                
                if ($user->hasRole('HeadOfSchool')) {
                    
                    $addstudent = Addstudent_sec::where('schoolid', $id)->get();
            
                        $studentDetails = array(
                            'userschool' => $userschool,
                            'classList' => $classList,
                            'addHouses' => $addHouses,
                            'addSection' => $addSection,
                            'addClub' => $addClub,
                            'addStudent' => $addstudent,
                            'addteachers' => $addteachers,
                            'addsubject' => $addsubject,
                            'addgrades' => $addgrades
                        );
                    
                    return view('pages.index_dash')->with('studentDetails', $studentDetails);
                }

                $user = User::find(Auth::user()->id);
                $user->hasanyRole(Role::all());

                if (!$user->hasanyRole(Role::all())) {
                    return view('pages.noroleacount.noroledash');
                }





                
        }elseif($userschool[0]['schooltype'] == "Secondary"){

            
                $user = User::find(Auth::user()->id);
                $user->hasRole('Student');

            if ($user->hasRole('Student')) {
                $schoolid = Auth::user()->schoolid;

               $addstudentsec = Addstudent_sec::join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
                                ->join('addposts', 'addposts.id','=','addstudent_secs.schoolid')
                                ->join('addsection_secs', 'addsection_secs.id','=','addstudent_secs.studentsection') 
                                ->where(['addstudent_secs.usernamesystem'=> Auth::user()->id, 'addstudent_secs.schoolid'=>Auth::user()->schoolid])
                                ->select('addstudent_secs.*', 'classlist_secs.classname', 'addsection_secs.sectionname', 'addposts.schoolname')->first();

                


                // $idf = $addstudentsec->toJson();
                // $studentsDetailsMain = json_decode($idf, true)[0];
                $classid = $addstudentsec->classid;

                $addsubjects = Addsubject_sec::where('classid', $classid)->get();


                $datemain = Carbon::now();
                $attDate = $datemain->toDateString();

                $dateExplode = explode("-", $attDate);
                $monthdateOnly = $dateExplode[0]."-".$dateExplode[1];

                $studentAttendance = DB::table('student_ats')
                                    ->join('addstudent_secs', 'addstudent_secs.id','=','student_ats.regnumber')
                                    ->select('student_ats.*', 'addstudent_secs.id as adnum')
                                    ->where(['student_ats.schoolid' => Auth::user()->schoolid, 'student_ats.systemid' => Auth::user()->id, 'student_ats.monthtoday'=>$monthdateOnly])->get();
                
                $idf = $studentAttendance->toJson();
                $studentAttendancemain = json_decode($idf, true);

                // return $studentAttendance;

                $todayMonth = '';
                $monthcount = '';
                $daysarray = array();

                if (count($studentAttendance) > 0) {
                    $monthlyDate = $studentAttendancemain[0]['monthtoday'];

                    $monthlyMain = explode('-', $monthlyDate);

                    $mainValue = $monthlyMain[1];

                    $jan = array("month" => "01", "days" => "31");
                    $feb = array("month" => "02", "days" => "29");
                    $mar = array("month" => "03", "days" => "31");
                    $april = array("month" => "04", "days" => "30");
                    $may = array("month" => "05", "days" => "31");
                    $june = array("month" => "06", "days" => "30");
                    $july = array("month" => "07", "days" => "31");
                    $august = array("month" => "08", "days" => "31");
                    $sept = array("month" => "09", "days" => "30");
                    $october = array("month" => "10", "days" => "31");
                    $nov = array("month" => "11", "days" => "30");
                    $dec = array("month" => "12", "days" => "31");

                    $month = array($jan,$feb,$mar,$april,$may,$june,$july,$august,$sept,$october,$nov,$dec);

                    // return $month;



                    for ($i=0; $i < count($month); $i++) { 
                        $monthMain = $month[$i]["month"];
                        // echo $monthMain;
                        if ($monthMain == $mainValue) {
                            $todayMonth = $monthMain;
                            $monthcount = $month[$i]["days"];
                        } 
                    }

                    

                    for ($i=0; $i < count($studentAttendancemain); $i++) { 

                        $datetoday = $studentAttendancemain[$i]['datetoday'];

                        $datetodayexplode = explode('-', $datetoday);

                        $attendanceRegNum = $datetodayexplode[2];
                        array_push($daysarray, $attendanceRegNum);
                        // echo $datetoday;
                    }

                }

                $mainStudentDetails = array(
                    'studentsDetailsMain'=> $addstudentsec,
                    'addsubjects' => $addsubjects,
                    'todayMonth' => $todayMonth,
                    'monthcount' => $monthcount,
                    'daysarray' => $daysarray
                );

                return view('secondary.student.student_dash')->with('mainStudentDetails', $mainStudentDetails);
            }

                $user = User::find(Auth::user()->id);
                $user->hasRole('Teacher');
            
            if ($user->hasRole('Teacher')) {

                $schoolid = Auth::user()->schoolid;

                $getFormClass = Addteachers_sec::where('systemid', Auth::user()->id)->get();

                if ($getFormClass->count() <1) {
                    $formTeacher = "";
                }else{
                    if ($getFormClass[0]['formteacher'] == "") {
                        $formTeacher = "";
                    }else{
                        $formClass = Classlist_sec::where('id', $getFormClass[0]['formteacher'])->get();
    
                        $formTeacher = $formClass[0]['classname'];
                    }

                }



                if ($getFormClass->count() <1) {
                    $allocatedSubject = [];
                }else{
                    if ($getFormClass[0]['subject'] == "") {//ewrkejkwjekwjekwjekwjekwe
                        $allocatedSubject = [];
                    }else{
                        $allocatedSubject = $getFormClass[0]['teachclass'];
    
                        $studentsInClass = DB::table('addstudent_secs')
                                            ->join('users', 'users.id','=','addstudent_secs.usernamesystem') 
                                            ->where('classid', $allocatedSubject)
                                            ->select('addstudent_secs.*', 'users.firstname', 'users.middlename', 'users.lastname')->get();
    
    
                    }
                }



                $getTeacherDetails = Addteachers_sec::join('addposts', 'addposts.id','=','addteachers_secs.schoolid')
                                    ->where(['addteachers_secs.schoolid'=>$schoolid, 'addteachers_secs.systemid'=>Auth::user()->id])
                                    ->select('addteachers_secs.*', 'addposts.schoolname')->first();
                

                
                $getTeacherId = Addteachers_sec::where('systemid', Auth::user()->id)->first();
                

                
                $subjectTeacherOffer = TeacherSubjects::join('addsection_secs', 'addsection_secs.id','=','teacher_subjects.section_id')
                                        ->select('teacher_subjects.*', 'addsection_secs.sectionname')
                                        ->where('user_id', Auth::user()->id)->get();
                

                $schooldetails = Addpost::find(Auth::user()->schoolid);

                return view('secondary.teachers.teacher_dash',compact('getTeacherDetails', 'formTeacher', 'subjectTeacherOffer', 'schooldetails'));
            }

                $user = User::find(Auth::user()->id);
                $user->hasRole('Librarian');
            
            if ($user->hasRole('Librarian')) {

                $addbook = DB::table('addbooks')->where('schoolid', Auth::user()->schoolid)->sum('quantity');
                $available = DB::table('addbooks')->where('schoolid', Auth::user()->schoolid)->sum('available');
                $borrowed = DB::table('addbooks')->where('schoolid', Auth::user()->schoolid)->sum('borrowed');
                $librarians = User::where(['schoolid'=>Auth::user()->schoolid, 'role'=>'Librarian'])->get();
                
                // Addbook::where('schoolid', Auth::user()->schoolid)->get();

                $alldetails = array(
                    'addbook'=>$addbook,
                    'available'=>$available,
                    'borrowed'=>$borrowed,
                    'librarians'=>$librarians
                );

                // return $alldetails['librarians'];

                return view('secondary.library_dash')->with('alldetails', $alldetails);
            }

                $user = User::find(Auth::user()->id);
                $user->hasRole('Bursar');

            if ($user->hasRole('Bursar')) {
                

                return view('secondary.accounting.dashboard');

            }

            $addteachers_secs = Addteachers_sec::where('schoolid', Auth::user()->schoolid)->get();
            $addstudent_secs = Addstudent_sec::where('schoolid', Auth::user()->schoolid)->get();
            $addsubject_secs_main = Addsubject_sec::where('schoolid', Auth::user()->schoolid)->pluck('subjectname')->toArray();
            $addsubject_secs = array_unique($addsubject_secs_main);
            $classlist_sec = Classlist_sec::where('schoolid', Auth::user()->schoolid)->get();
            $events = CalenderModel::orderBy('created_at', 'DESC')->get();

            $detailsArray = array(
                "addteachers_secs"=>$addteachers_secs,
                "addstudent_secs"=>$addstudent_secs,
                "addsubject_secs"=>$addsubject_secs,
                "classlist_sec"=>$classlist_sec
            );

            
            
            return view('secondary.index_sec', compact('events'))->with('detailsArray', $detailsArray);
        }


        
    }

    public function uploadProfilePix(Request $request){
        $validatedData = $request->validate([
            'profilepix' => 'image|max:200|mimes:jpeg,png,jpg|required'
        ]);

        $realImage = $request->file('profilepix');
        $imageSize = getimagesize( $realImage);
        $widthOfImage = $imageSize[0];
        $heightOfImage = $imageSize[1];

        // if($widthOfImage != $heightOfImage){
        //     return back()->with('error', 'invalid image dimension');
        // }

        if ($request->hasFile('profilepix')) {

            //get file name with extension
            $profilepixExt = $request->file('profilepix')->getClientOriginalName();

            //get just file names
            $fileNameProfile = pathinfo($profilepixExt, PATHINFO_FILENAME);

            //get just extensions
            $extensionProfilepix = $request->file('profilepix')->getClientOriginalExtension();

            //file name to store
            $profileFinal = $fileNameProfile."_".time().$extensionProfilepix;

            //upload image
            $pathProfile = $request->file('profilepix')->storeAs('public/schimages', $profileFinal);

        }

        $uploadProfileImage = User::find(Auth::user()->id);
        $uploadProfileImage->profileimg = $profileFinal;
        $uploadProfileImage->save();

        return back()->with('success', 'profile image uploaded');

    }
    
    public function uploadProfilePixwithout(Request $request){
        $validatedData = $request->validate([
            'profilepix' => 'image|max:200|mimes:jpeg,png,jpg|required'
        ]);

        $realImage = $request->file('profilepix');
        $imageSize = getimagesize( $realImage);
        $widthOfImage = $imageSize[0];
        $heightOfImage = $imageSize[1];

        if($widthOfImage != $heightOfImage){
            return back()->with('error', 'invalid image dimension');
        }

        if ($request->hasFile('profilepix')) {

            //get file name with extension
            $profilepixExt = $request->file('profilepix')->getClientOriginalName();

            //get just file names
            $fileNameProfile = pathinfo($profilepixExt, PATHINFO_FILENAME);

            //get just extensions
            $extensionProfilepix = $request->file('profilepix')->getClientOriginalExtension();

            //file name to store
            $profileFinal = $fileNameProfile."_".time().$extensionProfilepix;

            //upload image
            $pathProfile = $request->file('profilepix')->storeAs('public/schimages', $profileFinal);

        }

        $uploadProfileImage = User::find(Auth::user()->id);
        $uploadProfileImage->profileimg = $profileFinal;
        $uploadProfileImage->save();

        $addstudent= User::where('id', Auth::user()->id)->get();


        return response()->json(['success'=>$addstudent[0]['profileimg']]);

    }
}
