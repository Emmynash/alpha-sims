<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Addpost;
use App\User;
use App\Classlist_sec;
use App\Addstudent;
use App\Addteachers_sec;
use App\Addstudent_sec;
use App\Addsubject_sec;
use App\CalenderModel;
use App\Services\Imageupload;
use App\TeacherSubjects;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

        
        if (Auth::user()->role == "SuperAdmin") { // check if the user is a super admin
            // return "dsdsd"; 
            return redirect('/superadmin');
        }

// ------------------------check if user school exist or has been approved----------
        $userSchool = Addpost::find(Auth::user()->schoolid);
        if ($userSchool == null) {
            return view('home')->with("userschool", $userSchool);
        }elseif($userSchool->status == "Pending"){
            return view('home')->with("userschool", $userSchool);
        }
// ----------------------------------------------------------------------------------
        $user = User::find(Auth::user()->id);

        if ($user->hasRole('HeadOfSchool')) {
            return $this->headOfSchoolAccount();
        }
        if ($user->hasRole('Teacher')) {
            return $this->teachersAccount();
        }

        if ($user->hasRole('Student')) {
            return $this->studentAccount();
        }

        if ($user->hasRole('Bursar')) {
            return $this->bursarAccount();  
        }

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

        if($user->hasRole('Admin')){
            $addstudent = Addstudent::where('schoolid', Auth::user()->schoolid)->get();
            return view('pages.index_dash', compact('userSchool', 'classList', 'addHouses', 'addSection', 'addClub', 'addstudent', 'addteachers', 'addsubject', 'addgrades'));
        }
        
    }

    public function uploadProfilePix(Imageupload $imageUpload, Request $request){
        $rules = [
            'image' => 'image|max:2048|mimes:jpeg,png,jpg|required',
            'key' => 'required',
        ];
    
        $customMessages = [
            'required' => 'The :attribute field can not be blank.',
            'mimes' => 'file must be an image(jpeg, png, jpg)',
            'max' => 'file must not be greater than 2mb'
        ];
    
        $this->validate($request, $rules, $customMessages);

        try {
            $uploadRes = $imageUpload->imageUpload($request);
            if ($uploadRes == "Success") {
                return back()->with('success', "Process was successful");
            } else {
                return back()->with('error', "Process failed");
            }
        } catch (\Throwable $th) {
            return back()->with('error', "Process failed");
        }

    }
    

    public function teachersAccount()//redirects to teachers account for primary schools
    {
        try {

            $userSchool = Addpost::find(Auth::user()->schoolid);
            if ($userSchool->schooltype == "Secondary") {

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
                    if ($getFormClass[0]['subject'] == "") {
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

            }else{

                $formTeacher = Addteachers_sec::join('classlist_secs', 'classlist_secs.id','=','addteachers_secs.formteacher')->select('addteachers_secs.*', 'classlist_secs.classname')->where('systemid', Auth::user()->id)->first();

                $getTeacherDetails = Addteachers_sec::join('addposts', 'addposts.id','=','addteachers_secs.schoolid')
                                    ->where(['addteachers_secs.schoolid'=>Auth::user()->schoolid, 'addteachers_secs.systemid'=>Auth::user()->id])
                                    ->select('addteachers_secs.*', 'addposts.schoolname')->first();
                
                $getTeacherId = Addteachers_sec::where('systemid', Auth::user()->id)->first();
                $subjectTeacherOffer = TeacherSubjects::join('addsection_secs', 'addsection_secs.id','=','teacher_subjects.section_id')
                                        ->select('teacher_subjects.*', 'addsection_secs.sectionname')
                                        ->where('user_id', Auth::user()->id)->get();
                
                $schooldetails = Addpost::find(Auth::user()->schoolid);
    
                return view('secondary.teachers.teacher_dash',compact('getTeacherDetails', 'formTeacher', 'subjectTeacherOffer', 'schooldetails'));

            }
            
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function studentAccount() // redirects to student account primary school
    {
        try {
            $userSchool = Addpost::find(Auth::user()->schoolid);
            if ($userSchool == "Primary") {
                $schoolid = Auth::user()->schoolid;
                $addstudentsec = Addstudent_sec::leftjoin('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
                                  ->join('addposts', 'addposts.id','=','addstudent_secs.schoolid')
                                  ->join('addsection_secs', 'addsection_secs.id','=','addstudent_secs.studentsection') 
                                  ->where(['addstudent_secs.usernamesystem'=> Auth::user()->id, 'addstudent_secs.schoolid'=>Auth::user()->schoolid])
                                  ->select('addstudent_secs.*', 'classlist_secs.classname', 'addsection_secs.sectionname', 'addposts.schoolname')->first();
                  $addsubjects = Addsubject_sec::where('classid', $addstudentsec->classid)->get();
                  $schooldetails = Addpost::find(Auth::user()->schoolid);
    
                  return view('secondary.student.student_dash', compact('addstudentsec', 'addsubjects', 'schooldetails'));
            }else{
                $schoolid = Auth::user()->schoolid;

                $addstudentsec = Addstudent_sec::join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
                                 ->join('addposts', 'addposts.id','=','addstudent_secs.schoolid')
                                 ->join('addsection_secs', 'addsection_secs.id','=','addstudent_secs.studentsection') 
                                 ->where(['addstudent_secs.usernamesystem'=> Auth::user()->id, 'addstudent_secs.schoolid'=>Auth::user()->schoolid])
                                 ->select('addstudent_secs.*', 'classlist_secs.classname', 'addsection_secs.sectionname', 'addposts.schoolname')->first();
 
                 
                 $classid = $addstudentsec->classid;
                 $addsubjects = Addsubject_sec::where('classid', $classid)->get();
                 $datemain = Carbon::now();
                 $attDate = $datemain->toDateString();

                 $schooldetails = Addpost::find(Auth::user()->schoolid);

 
                 $mainStudentDetails = array(
                     'studentsDetailsMain'=> $addstudentsec,
                     'addsubjects' => $addsubjects
                 );
 
                 return view('secondary.student.student_dash', compact('schooldetails', 'addstudentsec', 'addsubjects'))->with('mainStudentDetails', $mainStudentDetails);
            }
            
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }
    }

    public function bursarAccount() // redirects to bursar account
    {
        try {
            
            $userSchool = Addpost::find(Auth::user()->schoolid);
            if($userSchool->schooltype == "Secondary"){
                
                    return view('secondary.accounting.dashboard');
                
            }else{

                $getSchool = User::join('addposts', 'addposts.id','=','users.schoolid')
            ->where('users.id', Auth::user()->id)
            ->select('users.*', 'addposts.schoolname')->first();

            return view('pages.accounting.bursar', compact('getSchool'));

            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function headOfSchoolAccount()
    {
        try {
            $userSchool = Addpost::find(Auth::user()->schoolid);
            if ($userSchool->schooltype == "Secondary") {
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
            }else{
                $addstudent = Addstudent_sec::where('schoolid', Auth::user()->schoolid)->get();
                $addteachers = Addteachers_sec::where('schoolid', Auth::user()->schoolid)->get();
                $addstudent = Addstudent_sec::where('schoolid', Auth::user()->schoolid)->get();
                $addsubject_secs_main = Addsubject_sec::where('schoolid', Auth::user()->schoolid)->pluck('subjectname')->toArray();
                $addsubject = array_unique($addsubject_secs_main);
                $classList = Classlist_sec::where('schoolid', Auth::user()->schoolid)->get();
                $events = CalenderModel::orderBy('created_at', 'DESC')->get();
                return view('pages.index_dash', compact('userSchool', 'classList', 'addstudent', 'addteachers', 'addsubject'));
            }

        } catch (\Throwable $th) {
            //throw $th;

            return $th;
        }
    }


}
