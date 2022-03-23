<?php

namespace App\Http\Controllers;


use App\Addpost;
use App\Addsection_sec;
use App\Addstudent_sec;
use App\Addsubject_sec;
use App\AssignmentSubmission;
use App\AssignmentTable;
use App\Classlist_sec;
use App\Services\AssignmentService;
use App\SubAssesmentModel;
use App\TeacherSubjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function index()
    {
        $schoolDetails = Addpost::find(Auth::user()->schoolid);
        $getClassId = Addstudent_sec::where('usernamesystem', Auth::user()->id)->first();

        $getAssignments = AssignmentTable::join('addsubject_secs', 'addsubject_secs.id', '=', 'assignment_tables.subjectid')
            ->join('classlist_secs', 'classlist_secs.id', '=', 'assignment_tables.classid')
            ->join('addsection_secs', 'addsection_secs.id', '=', 'assignment_tables.sectionid')
            ->select('assignment_tables.*', 'addsubject_secs.subjectname', 'classlist_secs.classname', 'addsection_secs.sectionname')
            ->where(['session' => $schoolDetails->schoolsession, 'term' => $schoolDetails->term, 'assignment_tables.classid' => $getClassId->classid, 'assignment_tables.sectionid' => $getClassId->studentsection])->get();

        return view('features.assignment.assignment', compact('schoolDetails', 'getAssignments'));
    }

    public function assignment_teachers()
    {

        $schoolDetails = Addpost::find(Auth::user()->schoolid);

        $getTeacherSubjects = TeacherSubjects::join('addsubject_secs', 'addsubject_secs.id', '=', 'teacher_subjects.subject_id')
            ->join('classlist_secs', 'classlist_secs.id', '=', 'teacher_subjects.classid')
            ->join('addsection_secs', 'addsection_secs.id', '=', 'teacher_subjects.section_id')
            ->select('teacher_subjects.*', 'addsubject_secs.subjectname', 'addsubject_secs.id as subjectid', 'classlist_secs.classname', 'classlist_secs.id as classid', 'addsection_secs.sectionname', 'addsection_secs.id as sectionid')
            ->where(['user_id' => Auth::user()->id])->get();

        return view('features.assignment.assignment_teacher', compact('schoolDetails', 'getTeacherSubjects'));
    }

    public function assignment_view($id, $classid, $sectionid)
    {

        try {

            $checkClass = Classlist_sec::find($classid);
            if ($checkClass == null) {
                return back();
            }

            $checkSection = Addsection_sec::find($sectionid);
            if ($checkSection == null) {
                return back();
            }

            $schoolDetails = Addpost::find(Auth::user()->schoolid);

            $subject = Addsubject_sec::find($id);
            if ($subject == null) {
                return back();
            }

            //get subassessments
            $assessments = SubAssesmentModel::join('assesment_models', 'assesment_models.id', '=', 'sub_assesment_models.catid')->where('sub_assesment_models.schoolid', Auth::user()->schoolid)->select('sub_assesment_models.*', 'assesment_models.name')->get();

           $getAssignments = AssignmentTable::join('addsubject_secs', 'addsubject_secs.id', '=', 'assignment_tables.subjectid')
                ->join('classlist_secs', 'classlist_secs.id', '=', 'assignment_tables.classid')
                ->join('addsection_secs', 'addsection_secs.id', '=', 'assignment_tables.sectionid')
                ->select('assignment_tables.*', 'addsubject_secs.subjectname', 'classlist_secs.classname', 'addsection_secs.sectionname')
                ->where(['subjectid' => $id, 'session' => $schoolDetails->schoolsession, 'term' => $schoolDetails->term, 'assignment_tables.classid' => $classid])->get();

            return view('features.assignment.viewassignment_teachers', compact('schoolDetails', 'subject', 'classid', 'sectionid', 'getAssignments', 'assessments'));
        } catch (\Throwable $th) {
            return back();
        }
    }

    public function post_assignment(Request $request)
    {

        try {
            $schoolDetails = Addpost::find(Auth::user()->schoolid);

            if ($request->hasFile('assignmentFile')) {

                $rules = [
                    'assignmentFile' => 'required|mimes:jpeg,png,jpg,pdf,doc|max:4048',
                    'sub_assesment_id' => 'required',
                    'startDate' => 'required',
                    'submissionDate' => 'required',
                    'subjectId' => 'required',
                    'classId' => 'required',
                    'sectionId' => 'required',
                    'description' => 'required',
                ];

                $customMessages = [
                    'required' => 'The :attribute field can not be blank.',
                    'mimes' => 'file must be an image(jpeg, png, jpg, doc, pdf)',
                    'max' => 'file must not be greater than 2mb'
                ];

                $this->validate($request, $rules, $customMessages);

                $response = cloudinary()->upload($request->file('assignmentFile')->getRealPath())->getSecurePath();



                $postAssignment = AssignmentTable::create([
                    'startdate' => $request->startDate,
                    'submissiondate' => $request->submissionDate,
                    'subjectid' => $request->subjectId,
                    'classid' => $request->classId,
                    'sectionid' => $request->sectionId,
                    'description' => $request->description,
                    'filelink' => $response,
                    'session' => $schoolDetails->schoolsession,
                    'term' => $schoolDetails->term,
                    'sub_assesment_id' => $request->sub_assesment_id
                ]);

                return back()->with('success', 'Assignment created successfully');
            } else {


                $validated = $request->validate([
                    'startDate' => 'required',
                    'submissionDate' => 'required',
                    'subjectId' => 'required',
                    'classId' => 'required',
                    'sectionId' => 'required',
                    'description' => 'required',
                    'sub_assesment_id' => 'required'

                ]);

                $postAssignment = AssignmentTable::create([
                    'startdate' => $request->startDate,
                    'submissiondate' => $request->submissionDate,
                    'subjectid' => $request->subjectId,
                    'classid' => $request->classId,
                    'sectionid' => $request->sectionId,
                    'description' => $request->description,
                    'session' => $schoolDetails->schoolsession,
                    'term' => $schoolDetails->term,
                    'sub_assesment_id' => $request->sub_assesment_id
                ]);

                return back()->with('success', 'Assignment created successfully');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
            return back();
        }
    }

    public function submitAssignmentStudent(Request $request)
    {


        try {
            if ($request->hasFile('filelink')) {


                $rules = [
                    'filelink' => 'required|mimes:jpeg,png,jpg,pdf,doc|max:4048',
                    'assignmenttext' => 'required',
                    'sectionid' => 'required',
                    'classid' => 'required',
                    'subjectid' => 'required',
                    'subjectid' => 'required'
                ];
    
                $customMessages = [
                    'required' => 'The :attribute field can not be blank.',
                    'mimes' => 'file must be an image(jpeg, png, jpg, doc, pdf)',
                    'max' => 'file must not be greater than 2mb'
                ];
    
    
    
                $schooldetails = Addpost::find(Auth::user()->schoolid);
    
                $getAssignment = AssignmentTable::find($request->assignment_id);
    
                //check if submission data has passed
                if(strtotime($getAssignment->submissiondate) - strtotime(date("Y-m-d")) < 0){
                    return back()
                    ->with('error', 'Submission date has passed');
                }
    
                $response = cloudinary()->upload($request->file('filelink')->getRealPath())->getSecurePath();
    
                $submitAssignment = AssignmentSubmission::updateOrCreate(
                    ['session' => $schooldetails->schoolsession, 'term' => $schooldetails->term, 'subjectid' => $request->subjectid, 'classid' => $request->classid, 'sectionid' => $request->sectionid],
                    [
                        'session' => $schooldetails->schoolsession,
                        'term' => $schooldetails->term,
                        'subjectid' => $request->subjectid,
                        'classid' => $request->classid,
                        'filelink' => $response,
                        'sectionid' => $request->sectionid,
                        'description' => $request->assignmenttext,
                        'userid' => Auth::user()->id,
                        'assignment_id' => $request->assignment_id
                    ]
                );
    
                return back()
                    ->with('success', 'Submitted successfully');
            } else {
                $validated = $request->validate([
                    'subjectid' => 'required',
                    'classid' => 'required',
                    'sectionid' => 'required',
                    'assignmenttext' => 'required',
                ]);
    
                $schooldetails = Addpost::find(Auth::user()->schoolid);
    
                $getAssignment = AssignmentTable::find($request->assignment_id);
    
                //check if submission data has passed
                if(strtotime($getAssignment->submissiondate) - strtotime(date("Y-m-d")) < 0){
                    return back()
                    ->with('error', 'Submission date has passed');
                }
    
                $submitAssignment = AssignmentSubmission::updateOrCreate(
                    ['session' => $schooldetails->schoolsession, 'term' => $schooldetails->term, 'subjectid' => $request->subjectid, 'classid' => $request->classid, 'sectionid' => $request->sectionid, 'userid' => Auth::user()->id],
                    [
                        'session' => $schooldetails->schoolsession,
                        'term' => $schooldetails->term,
                        'subjectid' => $request->subjectid,
                        'classid' => $request->classid,
                        'sectionid' => $request->sectionid,
                        'description' => $request->assignmenttext,
                        'userid' => Auth::user()->id,
                        'assignment_id' => $request->assignment_id
                    ]
                );
    
                return back()
                    ->with('success', 'Submitted successfully');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Error uploading file');
        }
    }

    public function delete($id)
    {
        $deleteAssignment = AssignmentTable::find($id);
        $deleteAssignment->delete();

        return back()->with('success', 'deleted successfully');
    }

    public function viewSubmissions($subjectid, $classid, $sectionid, $assignment_id)
    {
        $schooldetails = Addpost::find(Auth::user()->schoolid);

        if (Auth::user()->hasRole('Student')) {

           $submissions = AssignmentSubmission::join('classlist_secs', 'classlist_secs.id', '=', 'assignment_submissions.classid')
                ->join('addsection_secs', 'addsection_secs.id', '=', 'assignment_submissions.sectionid')
                ->join('addsubject_secs', 'addsubject_secs.id', '=', 'assignment_submissions.subjectid')
                ->join('users', 'users.id', '=', 'assignment_submissions.userid')
                ->leftJoin('assignment_remarks', 'assignment_remarks.submissionid','=','assignment_submissions.id')
                ->where(['subjectid' => $subjectid, 'assignment_submissions.classid' => $classid, 'assignment_submissions.assignment_id'=>$assignment_id, 'sectionid' => $sectionid, 'session' => $schooldetails->schoolsession, 'term' => $schooldetails->term, 'userid' => Auth::user()->id])
                ->select('assignment_submissions.*', 'classlist_secs.classname', 'addsection_secs.sectionname', 'addsubject_secs.subjectname', 'users.firstname', 'users.lastname', 'assignment_remarks.comment', 'assignment_remarks.score')->get();

            return view('features.assignment.viewsubmission', compact('schooldetails', 'submissions'));
        } else {


            $submissions = AssignmentSubmission::join('classlist_secs', 'classlist_secs.id', '=', 'assignment_submissions.classid')
                ->join('addsection_secs', 'addsection_secs.id', '=', 'assignment_submissions.sectionid')
                ->join('addsubject_secs', 'addsubject_secs.id', '=', 'assignment_submissions.subjectid')
                ->join('users', 'users.id', '=', 'assignment_submissions.userid')
                ->leftJoin('assignment_remarks', 'assignment_remarks.submissionid','=','assignment_submissions.id')
                ->where(['subjectid' => $subjectid, 'assignment_submissions.classid' => $classid, 'sectionid' => $sectionid, 'assignment_submissions.assignment_id'=>$assignment_id, 'session' => $schooldetails->schoolsession, 'term' => $schooldetails->term])
                ->select('assignment_submissions.*', 'classlist_secs.classname', 'addsection_secs.sectionname', 'addsubject_secs.subjectname', 'users.firstname', 'users.lastname', 'assignment_remarks.comment', 'assignment_remarks.score')->get();

            return view('features.assignment.viewsubmission', compact('schooldetails', 'submissions'));
        }
    }


    public function remarkAssignment(AssignmentService $assignmentService , Request $request)
    {
        $validated = $request->validate([
            'comment' => 'required',
            'submissionid' => 'required'
        ]);

        $addScoreToAssignment = $assignmentService->assignmentRemark($request);
        if ($addScoreToAssignment == "success") {
            return back()->with('success', 'Assignment assessed successfully');
        }else{
            return back()->with('error', 'there was an error assessing assignment');
        }

        
    }
}
