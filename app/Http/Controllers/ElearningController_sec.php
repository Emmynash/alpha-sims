<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Addstudent_sec;
use App\Addteachers_sec;
use App\Classlist_sec;
use App\elearning;
use App\User;
use App\Http\Resources\StudentResource;
use App\Http\Resources\SubjectsResource;
use App\Http\Resources\ChatResource;
use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Addsubject_sec;
use App\videomodel;
use App\Addassignment;

class ElearningController_sec extends Controller
{
    public function index(){

        $classlist_sec = Classlist_sec::where("schoolid", Auth::user()->schoolid)->get();
        $assignments = DB::table('addassignments')
                       ->leftjoin('classlist_secs', 'classlist_secs.id','=','addassignments.classid')
                       ->where('addassignments.schoolid', Auth::user()->schoolid)
                       ->select('addassignments.*', 'classlist_secs.classname')->paginate(10);

        $alldetails=array(
            'classlist_sec'=>$classlist_sec,
            'assignments'=>$assignments
        );

        // return $alldetails['assignments'];

        return view('secondary.elearning_sec')->with("alldetails", $alldetails);
    }
    
        public function submitAssignment(Request $request){

        $validatedData = $request->validate([
            'assignmentforclass' => 'required',
            'mainassignment' => 'required',
            'datefrom' => 'required',
            'dateto' => 'required',
        ]);

        $explodedatefrom = explode('-', $request->input('datefrom'));

        $fromyear = $explodedatefrom[0];
        $frommonth = $explodedatefrom[1];
        $fromday = $explodedatefrom[2];

        $explodedateto = explode('-', $request->input('dateto'));

        $toyear = $explodedateto[0];
        $tomonth = $explodedateto[1];
        $today = $explodedateto[2];

        if ($fromyear > $toyear) {
            return back()->with("error", "Date from year must be lower that date to year. Invalid selection.");
        }


        $addassignment = new Addassignment();
        $addassignment->classid = $request->input('assignmentforclass');
        $addassignment->datefrom = $request->input('datefrom');
        $addassignment->dateto = $request->input('dateto');
        $addassignment->content = $request->input('mainassignment');
        $addassignment->type = "Assignment";
        $addassignment->schoolid = Auth::user()->schoolid;
        $addassignment->save();

        return back()->with("success", "Assignment added successfully...");

    }

    public function deleteAssignment(Request $request){

        $validatedData = $request->validate([
            'deleteid' => 'required',
        ]);

        $deleteasignment = Addassignment::find($request->input('deleteid'));
        $deleteasignment->delete();
        
        return back();




    }
    
    public function notifications(Request $request){
        $schoolid = $request->route()->parameter('schoolid');
        
        $assignments = DB::table('addassignments')
                       ->leftjoin('classlist_secs', 'classlist_secs.id','=','addassignments.classid')
                       ->where('addassignments.schoolid', $schoolid)
                       ->select('addassignments.*', 'classlist_secs.classname')->get();
        
        return $assignments;
        
    }
    
    public function getProfileDetailsStusent(Request $request){
        $userid = $request->route()->parameter('userid');
        
        $userdetails = DB::table('addstudent_secs')
                       ->join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
                       ->join('addsection_secs', 'addsection_secs.id', '=', 'addstudent_secs.studentsection')
                       ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
                       ->join('addposts', 'addposts.id','=','addstudent_secs.schoolid')
                       ->where('usernamesystem', $userid)
                       ->select('addstudent_secs.*', 'classlist_secs.classname', 'users.id as userid', 'users.firstname', 'users.middlename', 'users.lastname', 'users.profileimg')->get();
                       
                return $userdetails;
        
        
    }

    public function fetchAllStudents(Request $request){
        // $studentusername = $request->get('studentusername');
        $classiduser = $request->route()->parameter('userid');


        

        $getrole = User::where('id', $classiduser)->get();

        if ($getrole[0]['role'] == "Student") {
            $getclassid = Addstudent_sec::where('usernamesystem', $classiduser)->get();
            $studentidmain = $getclassid[0]['classid'];

            $studentlist = DB::table('addstudent_secs')
            ->join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
            ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
            ->where(['addstudent_secs.classid'=> $studentidmain])
            ->select('addstudent_secs.*', 'classlist_secs.classname', 'users.firstname', 'users.middlename', 'users.lastname', 'users.profileimg', 'users.id as userid')
            ->get();

            // $collection = collect($studentlist);

            return json_encode($studentlist);
            
            
        }elseif($getrole[0]['role'] == "Teacher"){

            $teacherclass = Addteachers_sec::where('systemid', $classiduser)->get();

            $teachersclass = $teacherclass[0]['teachclass'];

            $studentlist = DB::table('addstudent_secs')
            ->join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
            ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
            ->where(['addstudent_secs.classid'=> $teachersclass])
            ->select('addstudent_secs.*', 'classlist_secs.classname', 'users.firstname', 'users.middlename', 'users.lastname', 'users.profileimg', 'users.id as userid')
            ->get();
            
             return json_encode($studentlist);
        }
        

        // return StudentResource::collection($studentlist);
    }
    
    //api function
    public function ConfirmStudentMobile(Request $request){
        
        // return $request->phonenumber;
        
        $classiduser = $request->phonenumber;
        
        // return $classiduser;
        
        $user = User::where('phonenumber', $classiduser)->get();
        
        // return $user[0]['id'];
        
        if($user[0]['role'] == "Student"){
            
            // $phone = User::find(77)->addstudents;
            
            // return $user[0]['id'];
            
            $userid = $user[0]['id'];
            
            $addstudentmain = DB::table('addstudent_secs')
                              ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
                              ->join('addposts', 'addposts.id','=','addstudent_secs.schoolid')
                              ->where(['addstudent_secs.usernamesystem'=>$userid])
                              ->select('addstudent_secs.*', 'users.firstname', 'users.id as systemidmain', 'users.role', 'users.middlename', 'users.lastname', 'users.phonenumber', 'users.profileimg', 'addposts.schoolname')->get();
                              
                              return json_encode($addstudentmain);
            
            // return new StudentResource($addstudentmain);
            
        }elseif($user[0]['role'] == "Teacher"){
            
                        $userid = $user[0]['id'];
            
            $addstudentmain = DB::table('addteachers_secs')
                              ->join('users', 'users.id','=','addteachers_secs.systemid')
                              ->join('addposts', 'addposts.id','=','addteachers_secs.schoolid')
                              ->where(['addteachers_secs.systemid'=>$userid])
                              ->select('addteachers_secs.*', 'users.firstname', 'addteachers_secs.teachclass as classid', 'users.id as systemidmain', 'users.role', 'users.middlename', 'users.lastname', 'users.phonenumber', 'users.profileimg', 'addposts.schoolname')->get();
                              
                              return json_encode($addstudentmain);
            
        }
        
        
        
        
    }

    public function fetchAllSubjectRoom(Request $request){

        $userId = $request->route()->parameter('userid');

        $getrole = User::where('id', $userId)->get();
        
        // return $getrole;
        
        
        if ($getrole[0]['role'] == "Student") {
            
            

            $getclassid = Addstudent_sec::where('usernamesystem', $getrole[0]['id'])->get();
            $studentidmain = $getclassid[0]['id'];
            $schoolIdStudent = $getclassid[0]['schoolid'];

            // $subjectRooms = DB::table('addsubject_secs')
            // ->join('addteachers_secs', 'addteachers_secs.teachclass','=','addsubject_secs.id')
            // ->join('users', 'users.id','=','addteachers_secs.systemid')
            // ->where(['addsubject_secs.classid'=> $studentidmain])
            // ->select('addsubject_secs.*', 'addteachers_secs.*', 'users.firstname', 'users.middlename', 'users.lastname', 'users.profileimg', 'users.id as userid')
            // ->get();
            
            $new = DB::table('addstudent_secs')
                   ->join('addposts', 'addposts.id','=','addstudent_secs.schoolid')
                   ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
                   ->join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
                   ->join('addsection_secs', 'addsection_secs.id','=','addstudent_secs.studentsection')
                   ->where(['addstudent_secs.id'=>$studentidmain])
                   ->select('addstudent_secs.*', 'addposts.schoolname', 'addposts.schoolsession', 'classlist_secs.classname', 'addsection_secs.sectionname', 'users.firstname', 'users.middlename', 'users.lastname')->get();
            return $new;

            // $new = DB::table('addteachers_secs')
            // ->join('addsubject_secs', 'addsubject_secs.id','=','addteachers_secs.subject')
            // ->join('users', 'users.id','=','addteachers_secs.systemid')
            // ->where(['addteachers_secs.teachclass'=>$studentidmain, 'addteachers_secs.schoolid'=> $schoolIdStudent])
            // ->select('addteachers_secs.*', 'addsubject_secs.*', 'users.firstname', 'users.middlename', 'users.lastname', 'users.id as userid', 'users.profileimg')
            // ->get();

            // // return new SubjectsResource($new);
            // return $new;

        }elseif ($getrole[0]['role']=="Teacher") {

            $getteachersubject = Addteachers_sec::where('systemid', $userId)->get();
            $teacherssubject = $getteachersubject[0]['schoolid'];
            $subjectid = $getteachersubject[0]['subject'];
            
             $new = DB::table('addsubject_secs')
                                       ->join('classlist_secs', 'classlist_secs.id','=','addsubject_secs.classid')
                                       ->where('teacherid', $getteachersubject[0]['id'])
                                       ->select('addsubject_secs.*', 'classlist_secs.classname', 'classlist_secs.studentcount')->get();


            // $new = DB::table('addsubject_secs')->get();
            // $new = Addsubject_sec::where(['schoolid'=> $teacherssubject, 'id'=>$subjectid])->get();

            return $new;

        }else{
            return "none";
        }


        
    }
    
    
    public function getallsubjects(Request $request){
        
        $schoolid = $request->route()->parameter('schoolid');
        
        $classlist = Classlist_sec::where('schoolid', $schoolid)->get();
        
        $arrayClasses = array();
        
        for ($i=0; $i < count($classlist); $i++) {
            
            array_push($arrayClasses, $classlist[$i]["classname"]."-".$classlist[$i]["id"]);
            
        }
        
        return $arrayClasses;
        
    }
    
    public function getallStudentsClass(Request $request){
        
        $classid = $request->route()->parameter('classid');
        
        
        $studentlist = DB::table('addstudent_secs')
                       ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
                       ->where('classid', $classid)
                       ->select('addstudent_secs.*', 'users.firstname', 'users.middlename', 'users.lastname', 'users.id as userid', 'users.profileimg')->get();
        
        
        // $studentlist = Addstudent_sec::where('classid', $classid)->get();
        
        return $studentlist;
        
    }
    
    public function getsubjecteachclass(Request $request){
        $classid = $request->route()->parameter('classid');
        
        $getAllSubjectClass = Addsubject_sec::where('classid', $classid)->get();
        
        return $getAllSubjectClass;
        
    }

    public function sendChat(Request $request){

        $message = $request->input('message');
        $recieverid = $request->input('chatid');
        $senderid = $request->input('senderid');
        $chattype = $request->input('chattypes');

        $datemain = Carbon::now();
        $date = Carbon::parse($datemain, 'UTC');
        $datemainnow = $date->isoFormat('h:mm a');
        $chattime = $datemainnow;
        $chatdate = $date->isoFormat('MMMM Do, YYYY');
        $schoolid = User::where('id', $senderid)->get();

        $eLearning = new elearning();
        $eLearning->schoolid = $schoolid[0]['id'];
        $eLearning->senderid = $senderid;
        $eLearning->receiverid = $recieverid;
        $eLearning->message = $message;
        $eLearning->chattype = $chattype;
        $eLearning->chattime = $chattime;
        $eLearning->chatdate = $chatdate;
        $eLearning->status = 1;
        $eLearning->save();

        return new ChatResource($eLearning);
    }

    public function getAllChats(Request $request){

        $loggeninuserid = $request->route()->parameter('loggeninuserid');

        $receiver = $request->route()->parameter('receiver');

        $chatype = $request->route()->parameter('chatype');

        if ($chatype == "single") {

            $elearning = elearning::where(['senderid'=> $loggeninuserid, 'receiverid'=>$receiver, 'chattype'=>$chatype])
                                ->orWhere(function($query) use ($loggeninuserid, $receiver, $chatype)
                                {
                                    $query->where(['senderid'=> $receiver, 'receiverid'=>$loggeninuserid, 'chattype'=>$chatype]);
                                })
                                ->get();
                        
            return ChatResource::collection($elearning);

        }else{

            $elearning = DB::table('elearnings')
                            ->join('users', 'users.id','=','elearnings.senderid')
                            ->where(['receiverid'=>$receiver, 'chattype'=>$chatype])
                            ->select('elearnings.*', 'users.firstname', 'users.middlename', 'users.lastname')->get();
        }

        
        return new ChatResource($elearning);
    }
    
    //----------------------------------------------------------------------
    //                         vudeo codes
    //----------------------------------------------------------------------
    
    public function downloadsVideos(){

        $chatdown = DB::table('videomodels')
        ->join('users', 'users.id','=','videomodels.uploader')
        ->where(['videomodels.schoolid'=>Auth::user()->schoolid])
        ->select('videomodels.*', 'users.profileimg')->paginate(5);
        // return response()->json(['data'=>$chatdown]);

        // return $chatdown;

        $classes = Classlist_sec::where('schoolid', Auth::user()->schoolid)->get();
        $addsubject = DB::table('addsubject_secs')
                        ->join('classlist_secs', 'classlist_secs.id','=','addsubject_secs.classid') 
                        ->where('addsubject_secs.schoolid', Auth::user()->schoolid)
                        ->select('addsubject_secs.*', 'classlist_secs.classname')->get();

        $videodetails = array(
            "classes"=>$classes,
            "addsubject"=>$addsubject
        );

        // return $videodetails['addsubject'];

        return view('secondary.downloads_videos')->with('videodetails', $videodetails);
    }

    public function addVideos(Request $request){

        $validator = Validator::make($request->all(),[
            'videoforclass' => 'required',
            'videoforsubject' => 'required',
            'videotitle' => 'required',
            'videourl' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $datemain = Carbon::now();
        $date = Carbon::parse($datemain, 'UTC');
        $datemainnow = $date->isoFormat('h:mm a');
        $chattime = $datemainnow;
        $chatdate = $date->isoFormat('MMMM Do, YYYY');

        //convert to the appropriate link

        $youtubelink = $request->input('videourl');
        $explodedLink = explode('/', $youtubelink);

        if (in_array("embed", $explodedLink)) {
            $newlinktodatabase = $youtubelink;
            
        }else{
            return response()->json(['errorurl'=>'errorurl']);
        }
        // } else {
        //     $watchside = $explodedLink[3];
        //     $watchexplode = explode('?', $watchside);
        //     $withlink = $watchexplode[1];
        //     //get videoId
        //     $extractId = explode('=', $withlink);
        //     $videoId = $extractId[1];
        //     $newlinktodatabase = "https://www.youtube.com/embed/".$videoId;
        // }

        $duplicateCheck = videomodel::where('videourl', $newlinktodatabase)->get();

        $duplicateTitleCheck = videomodel::where('videourl', $request->input('videourl'))->get();

        if (count($duplicateCheck)>0) {
            return response()->json(['duplicateurl'=>'dupurl']);
        }

        if (count($duplicateTitleCheck)>0) {
            return response()->json(['duplicatetitle'=>'duptitle']);
        }


        $videomodel = new videomodel();
        $videomodel->schoolid = Auth::user()->schoolid;
        $videomodel->classid = $request->input('videoforclass');
        $videomodel->uploader = Auth::user()->id;
        $videomodel->videourl = $newlinktodatabase;
        $videomodel->datuploaded = $chatdate;
        $videomodel->subjectid = $request->input('videoforsubject');
        $videomodel->title = $request->input('videotitle');
        $videomodel->save();

        return response()->json(['create'=>1]);
        

    }

    public function ftechAllVieosStudent(){

        // $mydata =  videomodel::paginate(5);

        $chatdown = DB::table('videomodels')
        ->join('users', 'users.id','=','videomodels.uploader')
        ->join('classlist_secs', 'classlist_secs.id','=','videomodels.classid')
        ->join('addsubject_secs', 'addsubject_secs.id','=','videomodels.subjectid')
        ->where(['videomodels.schoolid'=>Auth::user()->schoolid])
        ->select('videomodels.*', 'users.profileimg', 'users.firstname', 'classlist_secs.classname', 'addsubject_secs.subjectcode')->paginate(5);
        return response()->json(['data'=>$chatdown]);

    }
    
     public function ftechAllpdfStudent(){

        $chatdown = DB::table('addpdfs')
        ->join('users', 'users.id','=','addpdfs.addedbyid')
        ->join('classlist_secs', 'classlist_secs.id','=','addpdfs.classid')
        ->join('addsubject_secs', 'addsubject_secs.id','=','addpdfs.subjectid')
        ->where(['addpdfs.schoolid'=>Auth::user()->schoolid])
        ->select('addpdfs.*', 'users.profileimg', 'users.firstname', 'classlist_secs.classname', 'addsubject_secs.subjectcode')->paginate(12);
        return response()->json(['data'=>$chatdown]);

    }
}
