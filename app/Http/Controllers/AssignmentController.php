<?php

namespace App\Http\Controllers;

use App\Addpost;
use App\Addsection_sec;
use App\Addstudent_sec;
use App\Addsubject_sec;
use App\AssignmentRemark;
use App\AssignmentSubmission;
use App\AssignmentTable;
use App\Classlist_sec;
use App\SubAssesmentModel;
use App\TeacherSubjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function index()
    {
        $schooldetails = Addpost::find(Auth::user()->schoolid);
        $getClassid = Addstudent_sec::where('usernamesystem', Auth::user()->id)->first();

        $getAssignments = AssignmentTable::join('addsubject_secs', 'addsubject_secs.id','=','assignment_tables.subjectid')
                                    ->join('classlist_secs', 'classlist_secs.id','=','assignment_tables.classid')
                                    ->join('addsection_secs', 'addsection_secs.id','=','assignment_tables.sectionid')
                                    ->select('assignment_tables.*', 'addsubject_secs.subjectname', 'classlist_secs.classname', 'addsection_secs.sectionname')
                                    ->where(['session'=>$schooldetails->schoolsession, 'term'=>$schooldetails->term, 'assignment_tables.classid'=>$getClassid->classid, 'assignment_tables.sectionid'=>$getClassid->studentsection])->get();

        return view('secondary.assignment.assignment', compact('schooldetails', 'getAssignments'));
    }

    public function assignment_teachers()
    {

        $schooldetails = Addpost::find(Auth::user()->schoolid);

       $getTeacherSubjects = TeacherSubjects::join('addsubject_secs', 'addsubject_secs.id','=','teacher_subjects.subject_id')
                            ->join('classlist_secs', 'classlist_secs.id','=','teacher_subjects.classid')
                            ->join('addsection_secs', 'addsection_secs.id','=','teacher_subjects.section_id')
                            ->select('teacher_subjects.*', 'addsubject_secs.subjectname', 'addsubject_secs.id as subjectid', 'classlist_secs.classname', 'classlist_secs.id as classid', 'addsection_secs.sectionname', 'addsection_secs.id as sectionid')
                            ->where(['user_id'=>Auth::user()->id])->get();

        return view('secondary.assignment.assignment_teacher', compact('schooldetails', 'getTeacherSubjects'));
        
    }

    public function assignment_view($id, $classid, $sectionid)
    {

        try {

            $checkClass = Classlist_sec::find($classid);
            if($checkClass==null){
                return back();
            }

            $checkSection = Addsection_sec::find($sectionid);
            if($checkSection==null){
                return back();
            }

            $schooldetails = Addpost::find(Auth::user()->schoolid);

            $subject = Addsubject_sec::find($id);
            if($subject==null){
                return back();
            }

           $getAssignments = AssignmentTable::join('addsubject_secs', 'addsubject_secs.id','=','assignment_tables.subjectid')
                                    ->join('classlist_secs', 'classlist_secs.id','=','assignment_tables.classid')
                                    ->join('addsection_secs', 'addsection_secs.id','=','assignment_tables.sectionid')
                                    ->select('assignment_tables.*', 'addsubject_secs.subjectname', 'classlist_secs.classname', 'addsection_secs.sectionname')
                                    ->where(['subjectid'=>$id, 'session'=>$schooldetails->schoolsession, 'term'=>$schooldetails->term, 'assignment_tables.classid'=>$classid])->get();
    
            return view('secondary.assignment.viewassignment_teachers', compact('schooldetails', 'subject', 'classid', 'sectionid', 'getAssignments'));
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
            return back();
        }


    }

    public function post_assignment(Request $request)
    {

        if($request->hasFile('assignmentfile')){

            $validated = $request->validate([
                'startdate' => 'required',
                'submissiondate' => 'required',
                'subjectid' => 'required',
                'classid' => 'required',
                'sectionid' => 'required',
                'description' => 'required',
                'assignmentfile' => 'required|image|mimes:jpeg,png,jpg,pdf,doc|max:4048'
            ]);

            $response = cloudinary()->upload($request->file('assignmentfile')->getRealPath())->getSecurePath();

            $schooldetails = Addpost::find(Auth::user()->schoolid);

            $postAssignment = AssignmentTable::create([
                'startdate'=>$request->startdate,
                'submissiondate'=>$request->submissiondate,
                'subjectid'=>$request->subjectid,
                'classid'=>$request->classid,
                'sectionid'=>$request->sectionid,
                'description'=>$request->description,
                'filelink'=>$response,
                'session'=>$schooldetails->schoolsession,
                'term'=>$schooldetails->term
            ]);

            return back()->with('success', 'File uploaded successfully');

        }else{


            $validated = $request->validate([
                'startdate' => 'required',
                'submissiondate' => 'required',
                'subjectid' => 'required',
                'classid' => 'required',
                'sectionid' => 'required',
                'description' => 'required',
            ]);


            $schooldetails = Addpost::find(Auth::user()->schoolid);

            $postAssignment = AssignmentTable::create([
                'startdate'=>$request->startdate,
                'submissiondate'=>$request->submissiondate,
                'subjectid'=>$request->subjectid,
                'classid'=>$request->classid,
                'sectionid'=>$request->sectionid,
                'description'=>$request->description,
                'session'=>$schooldetails->schoolsession,
                'term'=>$schooldetails->term
            ]);

            return back()->with('success', 'File uploaded successfully');



        }


    }

    public function submitAssignmentStudent(Request $request)
    {


        if($request->hasFile('filelink')){

            $validated = $request->validate([
                'subjectid' => 'required',
                'classid' => 'required',
                'sectionid' => 'required',
                'assignmenttext' => 'required',
                'filelink' => 'required|image|mimes:jpeg,png,jpg,pdf,doc|max:4048'
            ]);

            $schooldetails = Addpost::find(Auth::user()->schoolid);

            $response = cloudinary()->upload($request->file('filelink')->getRealPath())->getSecurePath();
    
            $submitAssignment = AssignmentSubmission::updateOrCreate(
                ['session'=>$schooldetails->schoolsession, 'term'=>$schooldetails->term, 'subjectid'=>$request->subjectid, 'classid'=>$request->classid, 'sectionid'=>$request->sectionid],
                ['session'=>$schooldetails->schoolsession, 
                'term'=>$schooldetails->term, 
                'subjectid'=>$request->subjectid, 
                'classid'=>$request->classid,
                'filelink'=>$response,
                'sectionid'=>$request->sectionid,
                'description'=>$request->assignmenttext]);
    
                return back()
                ->with('success', 'File uploaded successfully');

        }else{
            $validated = $request->validate([
                'subjectid' => 'required',
                'classid' => 'required',
                'sectionid' => 'required',
                'assignmenttext' => 'required',
            ]);

            $schooldetails = Addpost::find(Auth::user()->schoolid);
    
            $submitAssignment = AssignmentSubmission::updateOrCreate(
                ['session'=>$schooldetails->schoolsession, 'term'=>$schooldetails->term, 'subjectid'=>$request->subjectid, 'classid'=>$request->classid, 'sectionid'=>$request->sectionid, 'userid'=>Auth::user()->id],
                ['session'=>$schooldetails->schoolsession, 
                'term'=>$schooldetails->term, 
                'subjectid'=>$request->subjectid, 
                'classid'=>$request->classid,
                'sectionid'=>$request->sectionid,
                'description'=>$request->assignmenttext,
                'userid'=>Auth::user()->id]);
    
                return back()
                ->with('success', 'File uploaded successfully');
        }




    }

    public function delete($id)
    {
        $deleteassignment = AssignmentTable::find($id);
        $deleteassignment->delete();

        return back()->with('success', 'deleted successfully');
    }

    public function viewsubmissions($subjectid, $classid, $sectionid)
    {
        $schooldetails = Addpost::find(Auth::user()->schoolid);

        if(Auth::user()->hasRole('Student')){

            $submissions = AssignmentSubmission::join('classlist_secs', 'classlist_secs.id','=', 'assignment_submissions.classid')
                        ->join('addsection_secs', 'addsection_secs.id','=','assignment_submissions.sectionid')
                        ->join('addsubject_secs', 'addsubject_secs.id','=','assignment_submissions.subjectid')
                        ->join('users', 'users.id','=','assignment_submissions.userid')
                        ->where(['subjectid'=>$subjectid, 'assignment_submissions.classid'=>$classid, 'sectionid'=>$sectionid, 'session'=>$schooldetails->schoolsession, 'term'=>$schooldetails->term, 'userid'=>Auth::user()->id])
                        ->select('assignment_submissions.*', 'classlist_secs.classname', 'addsection_secs.sectionname', 'addsubject_secs.subjectname', 'users.firstname', 'users.lastname')->get();

            return view('secondary.assignment.viewsubmission', compact('schooldetails', 'submissions'));

        }else{


            $submissions = AssignmentSubmission::join('classlist_secs', 'classlist_secs.id','=', 'assignment_submissions.classid')
                        ->join('addsection_secs', 'addsection_secs.id','=','assignment_submissions.sectionid')
                        ->join('addsubject_secs', 'addsubject_secs.id','=','assignment_submissions.subjectid')
                        ->join('users', 'users.id','=','assignment_submissions.userid')
                        ->where(['subjectid'=>$subjectid, 'assignment_submissions.classid'=>$classid, 'sectionid'=>$sectionid, 'session'=>$schooldetails->schoolsession, 'term'=>$schooldetails->term])
                        ->select('assignment_submissions.*', 'classlist_secs.classname', 'addsection_secs.sectionname', 'addsubject_secs.subjectname', 'users.firstname', 'users.lastname')->get();

            return view('secondary.assignment.viewsubmission', compact('schooldetails', 'submissions'));

        }


    }

    public function remarkAssignment(Request $request)
    {
        $validated = $request->validate([
            'comment' => 'required',
            'submissionid' => 'required'
        ]);

        $addRemark = AssignmentRemark::updateOrCreate(
            ['submissionid'=>$request->submissionid],
            ['comment'=>$request->comment, 'submissionid'=>$request->submissionid, 'score'=>$request->score]
        );

        $updateStatus = AssignmentSubmission::find($request->submissionid);
        $updateStatus->status = 1;
        $updateStatus->save();

        return back()->with('success', 'Remart added successfully');
    }


}
