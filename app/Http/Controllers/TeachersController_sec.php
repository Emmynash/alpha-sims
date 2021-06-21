<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Addstudent_sec;
use App\Addstudent;
use App\Classlist_sec;
use App\Addhouse_sec;
use App\Addsection_sec;
use App\Addclub_sec;
use App\Addmark_sec;
use App\Addpost;
use App\Addteachers_sec;
use App\Addsubject_sec;
use App\TeacherSubjects;
use App\FormTeachers;
use App\ConfirmSubjectRecordEntered;
use App\ResultReadyModel;
use App\ResultReadySubject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class TeachersController_sec extends Controller
{

    private $classlist_sec;
    private $addsection_sec;
    private $addpost;
    private $user;
    private $addstudent_sec;
    private $addteachers_sec;
    private $addsubject_sec;
    private $teacherSubjects;
    private $formTeachers;

    function __construct(Classlist_sec $classlist_sec, Addsection_sec $addsection_sec, Addpost $addpost, User $user, Addstudent_sec $addstudent_sec, Addstudent $addstudent, Addteachers_sec $addteachers_sec, Addsubject_sec $addsubject_sec, TeacherSubjects $teacherSubjects, FormTeachers $formTeachers)
    {
        $this->classlist_sec = $classlist_sec;
        $this->addsection_sec = $addsection_sec;
        $this->addpost = $addpost;
        $this->user = $user; 
        $this->addstudent_sec = $addstudent_sec;
        $this->addstudent = $addstudent;
        $this->addteachers_sec = $addteachers_sec;
        $this->addsubject_sec = $addsubject_sec;
        $this->teacherSubjects = $teacherSubjects;
        $this->formTeachers = $formTeachers;

    }


    public function index(){

        $schooldetails = Addpost::find(Auth::user()->schoolid);
        
        return view('secondary.teachers.addteachersreact', compact('schooldetails'));
    }

    public function fetchDataForAddTeachersPage()
    {
        try {
            $schoolId = Auth::user()->schoolid;

            $classesAll = $this->classlist_sec->where(['schoolid'=> Auth::user()->schoolid, 'status'=>1])->get();
            $addsection_sec = $this->addsection_sec->where('schoolid', Auth::user()->schoolid)->get();
            $addschool = $this->addpost->where('id', Auth::user()->schoolid)->get();
            $addsubject_sec = DB::table('addsubject_secs')
                    ->join('classlist_secs', 'classlist_secs.id','=','addsubject_secs.classid')
                    ->leftJoin('addsection_secs', 'addsection_secs.id','=','addsubject_secs.subjectsectione')
                    ->select('addsubject_secs.*', 'classlist_secs.classname', 'addsection_secs.sectionname')
                    ->where('addsubject_secs.schoolid', $schoolId,)->get();
    
            $getAllTeachersWithSubject = TeacherSubjects::join('users', 'users.id','=','teacher_subjects.user_id')
                                        ->join('addsubject_secs', 'addsubject_secs.id','=','teacher_subjects.subject_id')
                                        ->join('classlist_secs', "classlist_secs.id",'=','teacher_subjects.classid')
                                        ->leftJoin('addsection_secs', 'addsection_secs.id','=','teacher_subjects.section_id')
                                        ->where('school_id', Auth::user()->schoolid)
                                        ->select('teacher_subjects.*', 'addsubject_secs.subjectname', 'classlist_secs.classname', 'addsection_secs.sectionname', 'users.firstname', 'users.middlename', 'users.lastname')->get();

            $getAllTeachers = Addteachers_sec::join('users', 'users.id','=','addteachers_secs.systemid')
                              ->where('addteachers_secs.schoolid', Auth::user()->schoolid)
                              ->select('addteachers_secs.*', 'users.firstname', 'users.middlename', 'users.lastname')->get();

            $getFormMasters = FormTeachers::join('users', 'users.id','=','form_teachers.teacher_id')
                            ->join('addsection_secs', 'addsection_secs.id','=','form_teachers.form_id')
                            ->join('classlist_secs','classlist_secs.id','=','form_teachers.class_id')
                            ->where('form_teachers.school_id', Auth::user()->schoolid)
                            ->select('form_teachers.*', 'classlist_secs.classname', 'addsection_secs.sectionname', 'users.firstname', 'users.middlename', 'users.lastname')->get();

            $houses = Addhouse_sec::where('schoolid', Auth::user()->schoolid)->get();

            $clubs = Addclub_sec::where('schoolid', Auth::user()->schoolid)->get();
    
    
            return response()->json(['classesAll'=>$classesAll, 'addsection_sec'=>$addsection_sec, 'addsubject_sec'=>$addsubject_sec, 'getAllTeachersWithSubject'=>$getAllTeachersWithSubject, 'getFormMasters'=>$getFormMasters, 'houses'=>$houses, 'clubs'=>$clubs, 'getAllTeachers'=>$getAllTeachers]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response'=>'error']);
        }
    }

    public function confirmTeacherRegNumber(Request $request){
        
        $validator = Validator::make($request->all(),[
            'mastersystemnumber' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['response'=>$validator->errors()->keys()]);
        }

        $userdetailfetch = $this->user->where('id', $request->input('mastersystemnumber'))->get();
        // check if this system number is for a student
        // $addstudent_sec = $this->addstudent_sec->where('usernamesystem', $request->input('mastersystemnumber'))->get();
        // $addstudentPrimary = $this->addstudent->where('usernamesystem', $request->input('mastersystemnumber'))->get();
        
        // if(count($addstudentPrimary) > 0){
        //     return response()->json(['exist'=>'noaccount']);
        // }

        $roles = $userdetailfetch[0]->getRoleNames();

        if ($roles->count() > 0) {

            if ($roles[0] == "Teacher") {
                $userschoolid = $userdetailfetch[0]->schoolid;

                if ($userschoolid != Auth::user()->schoolid) {

                    return response()->json(['response'=>'noaccount']);

                }

                return response()->json(['userdetailfetch'=>$userdetailfetch]);
            }else {
                return response()->json(['response'=>'noaccount']);
            }
        }else {
            return response()->json(['userdetailfetch'=>$userdetailfetch]);
        }

        return response()->json(['userdetailfetch'=>$userdetailfetch], 200);
    }

    public function allocateFormMaster(Request $request){

        $validator = Validator::make($request->all(),[
            'formsection' => 'required',
            'formteacherclass' => 'required',
            'systemidformmaster' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['response'=>"fields"]);
        }

        $formCheck = $this->formTeachers->where('teacher_id', (int)$request->systemidformmaster)->get();

        if ($formCheck->count() > 0) {
            return response()->json(['response'=>'exist']);
        }

        $teacherCheck = $this->addteachers_sec->where(['systemid'=> $request->input('systemidformmaster')])->get();

        if (count($teacherCheck) > 0) {

            $addFormMaster = new FormTeachers();
            $addFormMaster->teacher_id = (int)$request->systemidformmaster;
            $addFormMaster->class_id = (int)$request->formteacherclass;
            $addFormMaster->form_id = (int)$request->formsection;
            $addFormMaster->school_id = (int)Auth::user()->schoolid;
            $addFormMaster->save();

            return response()->json(['response'=>'done']);
        }

        $addFormMaster = new FormTeachers();
        $addFormMaster->teacher_id = (int)$request->systemidformmaster;
        $addFormMaster->class_id = (int)$request->formteacherclass;
        $addFormMaster->form_id = (int)$request->formsection;
        $addFormMaster->school_id = (int)Auth::user()->schoolid;
        $addFormMaster->save();

        //update user role
        $teacherDetail = $this->user->where('id', $request->input('systemidformmaster'))->first();

        $id = $teacherDetail->id;

        $updateRole = $this->user->find($id);
        $updateRole->role = "Teacher";
        $updateRole->schoolid = Auth::user()->schoolid;
        $updateRole->save();

        return response()->json(['response'=>'done']);
    }


    public function unAsignASubject(Request $request)
    {

        try {

            $getSubjectToRemoveFromTeacher = TeacherSubjects::find($request->tableid);
            $getSubjectToRemoveFromTeacher->delete();
            return response()->json(['response'=>'success']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response'=>'error']);
        }
        
    }

    public function allocateSubjectTeacher(Request $request){



        $validator = Validator::make($request->all(),[
            'subject_id' => 'required',
            'user_id' => 'required',
            'section' => 'required',
            'allocatedclass' => 'required'
        ]);
        

        if ($validator->fails()) {
            return response()->json(['response'=>'fields']);
        }

            
        $getTeacherRegNo = $this->addteachers_sec->where('systemid', $request->user_id)->get();


        if($getTeacherRegNo->count() < 1){

            $addformmaster = new Addteachers_sec();
            $addformmaster->schoolid = Auth::user()->schoolid;
            $addformmaster->systemid = $request->input('user_id');
            $addformmaster->save();

            $updateRole = User::find($request->user_id);
            $updateRole->role = "Teacher";
            $updateRole->schoolid = Auth::user()->schoolid;
            $updateRole->save();

            $user = User::find($request->user_id);

            $user->assignRole('Teacher');

        }

           $teacherSubjectCheck = $this->teacherSubjects->where(['user_id' => $request->user_id, "subject_id" => $request->subject_id, 'section_id'=>$request->section, 'classid'=>$request->allocatedclass])->get();

            if ($teacherSubjectCheck->count() < 1) {
                
                $requestData = $request->except(['_token', 'allocatedclass', 'subject_id', 'user_id']);

                $getTeacherRegNoMain = $this->addteachers_sec->where('systemid', $request->user_id)->get();

    
                try {


                    $getclassid = $this->addsubject_sec->where('id', $request->subject_id)->first();

                    $addTeacher = new TeacherSubjects();
                    $addTeacher ->user_id = (int)$request->user_id;
                    $addTeacher->school_id = (int)Auth::user()->schoolid;
                    $addTeacher->subject_id = (int)$request->subject_id;
                    $addTeacher->classid = (int)$request->allocatedclass;
                    $addTeacher->usernamesystem=(int)$getTeacherRegNoMain[0]->id;
                    $addTeacher->section_id = $request->section;
                    $addTeacher->save();

                    $user = User::find($request->user_id);

                    $user->assignRole('Teacher');

                    return response()->json(['response'=>'success']);

                } catch (\Throwable $th) {
                    return $th;
                }

            }else{
    
                return response()->json(['response'=>'exist']);
            }

    }

    public function fetchTeacherSubject($userid)
    {

        try {
            
            $teacherSubjects = TeacherSubjects::join('addsubject_secs', 'addsubject_secs.id','=','teacher_subjects.subject_id')
                            ->join('classlist_secs', 'classlist_secs.id', 'teacher_subjects.classid')
                            ->leftjoin('addsection_secs', 'addsection_secs.id','=','teacher_subjects.section_id')
                            ->where('teacher_subjects.user_id', $userid)
                            ->select('teacher_subjects.*', 'classlist_secs.classname', 'addsubject_secs.subjectname', 'addsection_secs.sectionname')->get();

            return response()->json(['response'=>$teacherSubjects]);

        } catch (\Throwable $th) {
            //throw $th;

            return response()->json(['response'=>$th]);
        }
        
    }

    public function confirmTeacherRegNumber2(Request $request){

        $validator = Validator::make($request->all(),[
            'allocationsubject' => 'required|string', //id of subject to allocate
            'systemidstudentalloc' => 'required|string' //teacher user table id
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $userdetailfetch = $this->user->where('id', $request->input('systemidstudentalloc'))->get();

        $addstudent_sec = $this->addstudent_sec->where('usernamesystem', $request->input('systemidstudentalloc'))->get();
        
        $addstudentPrimary = $this->addstudent->where('usernamesystem', $request->input('systemidstudentalloc'))->get();
        
        if(count($addstudentPrimary) > 0){
            return response()->json(['exist'=>'noaccount']);
        }

        if (count($userdetailfetch) > 0) {

            if (count($addstudent_sec) > 0) {
                return response()->json(['exist'=>'noaccount']);
            }else{
                return response()->json(['create'=>$userdetailfetch]);
            }
            
        }else{
            return response()->json(['noaccount'=>'noaccount']);
        }

        return response()->json($userdetailfetch, 200);
    }

    public function teacherEditProfile(){

        $teachersDetails = $this->addteachers_sec->where(['schoolid' => Auth::user()->schoolid, 'systemid' => Auth::user()->id])->first();

        return view('secondary.teachers.editprofile_teachers', compact('teachersDetails'));
    }

    public function addEdited(Request $request){

        $validatedData = $request->validate([
            'firstnameedit' => 'required',
            'middlenameedit' => 'required',
            'lastnameedit' => 'required',
            'emailnameedit' => 'required',
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

        $updateteachers = Addteachers_sec::find($request->input('entryid'));
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

    public function resultremark()
    {
        $teacherSubject = TeacherSubjects::join('addsubject_secs', 'addsubject_secs.id','=','teacher_subjects.subject_id')
                        ->leftjoin("classlist_secs", 'classlist_secs.id','=','addsubject_secs.classid')
                        ->leftjoin('addsection_secs', 'addsection_secs.id','=','addsubject_secs.subjectsectione')
                        ->select('teacher_subjects.*','classlist_secs.id as classid', 'classlist_secs.classname', 'addsubject_secs.id as sub', 'addsection_secs.sectionname', 'addsection_secs.id as sectionid' )
                        ->where('user_id', Auth::user()->id)->get();

        $schooldetaild = Addpost::find(Auth::user()->schoolid);

        $getEnteredSubjects = ConfirmSubjectRecordEntered::where(['schoolid'=>Auth::user()->schoolid, "term"=>$schooldetaild->term, "session"=>$schooldetaild->schoolsession])->pluck('subject_id');

        $arrayOfSubjectId = array();

        for ($i=0; $i < $getEnteredSubjects->count(); $i++) { 
            array_push($arrayOfSubjectId, $getEnteredSubjects[$i]);
        }

        return view('secondary.teachers.resultremark.resultremark', compact('teacherSubject', 'arrayOfSubjectId'));
        
    }

    public function resultremarkpost(Request $request)
    {
        $schooldetaild = Addpost::find(Auth::user()->schoolid);


        // return $request;

        if ($request->section_id == null) {

            //get count of students in the class since the subject is general

            $getCount = Addstudent_sec::where(['classid'=>$request->classid, 'schoolsession'=>$schooldetaild->schoolsession])->get();

            $getMarks = Addmark_sec::where(['term'=>$schooldetaild->term, 'session'=>$schooldetaild->schoolsession, 'classid'=>$request->classid, 'subjectid'=>$request->subject_id])->get();

            if (count($getMarks) == count($getCount) ) {

                $enterRecord = new ConfirmSubjectRecordEntered();
                $enterRecord->session = $schooldetaild->schoolsession;
                $enterRecord->term = $schooldetaild->term;
                $enterRecord->subject_id = $request->subject_id;
                $enterRecord->schoolid = Auth::user()->schoolid;
                $enterRecord->user_id = Auth::user()->id;
                $enterRecord->classid = $request->classid;
                $enterRecord->save();
                
                return back();
            }else{
                return back()->with('error', 'result entered not complete yet...');
            }
            
        }else {

            //get count of students in the class since the subject is by class and section

            $getCount = Addstudent_sec::where(['classid'=>$request->classid, 'schoolsession'=>$schooldetaild->schoolsession, 'studentsection'=>$request->section_id])->get();

            $getMarks = Addmark_sec::where(['term'=>$schooldetaild->term, 'session'=>$schooldetaild->schoolsession, 'classid'=>$request->classid, 'subjectid'=>$request->subject_id, 'section'=>$request->section_id])->get();

            if (count($getMarks) == count($getCount) ) {

                $enterRecord = new ConfirmSubjectRecordEntered();
                $enterRecord->session = $schooldetaild->schoolsession;
                $enterRecord->term = $schooldetaild->term;
                $enterRecord->subject_id = $request->subject_id;
                $enterRecord->schoolid = Auth::user()->schoolid;
                $enterRecord->user_id = Auth::user()->id;
                $enterRecord->classid = $request->classid;
                $enterRecord->save();
                
                return back();
            }else{
                return back()->with('error', 'result entered not complete yet...');
            }
            
        }


    }

    public function formTeacherMain()
    {

        $formClass = FormTeachers::where('teacher_id', Auth::user()->id)->first();

        if ($formClass == NULL) {
            return back()->with('error', 'you are not a form teacher.');
        }

        $schooldetaild = Addpost::find(Auth::user()->schoolid);

        $getEnteredSubjects = ConfirmSubjectRecordEntered::where(['schoolid'=>Auth::user()->schoolid, "term"=>$schooldetaild->term, "session"=>$schooldetaild->schoolsession])->pluck('subject_id');

        $arrayOfSubjectId = array();

        for ($i=0; $i < $getEnteredSubjects->count(); $i++) { 
            array_push($arrayOfSubjectId, $getEnteredSubjects[$i]);
        }

        

        return view('secondary.teachers.formteacher', compact('formClass', 'arrayOfSubjectId'));
    }

    public function confirmSubjectRecordEntered(Request $request)
    {
        $classid = $request->classid;
        $schooldata = Addpost::where('id', Auth::user()->schoolid)->first();
        $term = $schooldata->term;
        $schoolsession = $schooldata->schoolsession;

        $checkSubjects = Addsubject_sec::where('classid', $classid)->get();

        $eachsubjectconfirm = ConfirmSubjectRecordEntered::where(['session'=>$schoolsession, 'term'=>$term, 'classid'=>$classid])->get();

        if ($checkSubjects->count() != $eachsubjectconfirm->count()) {
            return back()->with('error', 'Student marks for each subject not fully entered');
        }

        $checkConfirm = ResultReadyModel::where(['schoolid'=>Auth::user()->schoolid, 'classid'=>$classid, 'term'=>$term, 'sectionid'=>$request->sectionid, 'session'=>$schoolsession])->get();

        if ($checkConfirm->count() > 0) {
            return back()->with('error', 'Process already done');
        }


        $addconfirmation = new ResultReadyModel();
        $addconfirmation->schoolid = Auth::user()->schoolid;
        $addconfirmation->classid = $classid;
        $addconfirmation->term = $term;
        $addconfirmation->session = $schoolsession;
        $addconfirmation->sectionid= $request->sectionid;
        $addconfirmation->status = 0;
        $addconfirmation->save();

        return back()->with('success', 'process was successfull');
        
    }

    public function form_teacher_sec_index(Request $request)
    {
        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('secondary.teachers.addformmastersreact', compact('schooldetails'));
    }
}
