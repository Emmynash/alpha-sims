<?php

namespace App\Http\Controllers;

use App\Addgrades_sec;
use App\Addpost;
use App\Addsection_sec;
use App\Addstudent_sec;
use App\Addsubject_sec;
use App\AssesmentModel;
use App\AssessmentTableTotal;
use App\AssignmentRemark;
use App\AssignmentSubmission;
use App\AssignmentTable;
use App\Classlist_sec;
use App\RecordMarks;
use App\SubAssesmentModel;
use App\TeacherSubjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

            //get subassessments
            $assessments = SubAssesmentModel::join('assesment_models', 'assesment_models.id','=','sub_assesment_models.catid')->where('sub_assesment_models.schoolid', Auth::user()->schoolid)->select('sub_assesment_models.*', 'assesment_models.name')->get();

           $getAssignments = AssignmentTable::join('addsubject_secs', 'addsubject_secs.id','=','assignment_tables.subjectid')
                                    ->join('classlist_secs', 'classlist_secs.id','=','assignment_tables.classid')
                                    ->join('addsection_secs', 'addsection_secs.id','=','assignment_tables.sectionid')
                                    ->select('assignment_tables.*', 'addsubject_secs.subjectname', 'classlist_secs.classname', 'addsection_secs.sectionname')
                                    ->where(['subjectid'=>$id, 'session'=>$schooldetails->schoolsession, 'term'=>$schooldetails->term])->get();
    
            return view('secondary.assignment.viewassignment_teachers', compact('schooldetails', 'subject', 'classid', 'sectionid', 'getAssignments', 'assessments'));
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
            return back();
        }


    }

    public function post_assignment(Request $request)
    {

        if($request->hasFile('assignmentfile')){

            // $validated = $request->validate([
            //     'startdate' => 'required',
            //     'submissiondate' => 'required',
            //     'subjectid' => 'required',
            //     'classid' => 'required',
            //     'sectionid' => 'required',
            //     'description' => 'required',
            //     'assignmentfile' => 'required|image|mimes:jpeg,png,jpg,pdf,doc|max:4048',
            //     'sub_assesment_id' => 'required'
            // ]);

            $rules = [
                'assignmentfile' => 'required|mimes:jpeg,png,jpg,pdf,doc|max:4048',
                'sub_assesment_id' => 'required',
                'startdate' => 'required',
                'submissiondate' => 'required',
                'subjectid' => 'required',
                'classid' => 'required',
                'sectionid' => 'required',
                'description' => 'required',
            ];
        
            $customMessages = [
                'required' => 'The :attribute field can not be blank.',
                'mimes' => 'file must be an image(jpeg, png, jpg, doc, pdf)',
                'max' => 'file must not be greater than 2mb'
            ];
        
            $this->validate($request, $rules, $customMessages);

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
                'term'=>$schooldetails->term,
                'sub_assesment_id'=>$request->sub_assesment_id
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
                'sub_assesment_id' => 'required'
                
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
                'term'=>$schooldetails->term,
                'sub_assesment_id'=>$request->sub_assesment_id
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
                'description'=>$request->assignmenttext,
                'userid'=>Auth::user()->id,
                'assignment_id'=>$request->assignment_id]);
    
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
                'userid'=>Auth::user()->id,
                'assignment_id'=>$request->assignment_id]);
    
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

        $submissions = AssignmentSubmission::join('classlist_secs', 'classlist_secs.id','=', 'assignment_submissions.classid')
                     ->join('addsection_secs', 'addsection_secs.id','=','assignment_submissions.sectionid')
                     ->join('addsubject_secs', 'addsubject_secs.id','=','assignment_submissions.subjectid')
                     ->join('users', 'users.id','=','assignment_submissions.userid')
                     ->leftjoin('assignment_remarks', 'assignment_remarks.submissionid','=','assignment_submissions.id')
                     ->where(['subjectid'=>$subjectid, 'assignment_submissions.classid'=>$classid, 'sectionid'=>$sectionid, 'session'=>$schooldetails->schoolsession, 'term'=>$schooldetails->term])
                     ->select('assignment_submissions.*', 'classlist_secs.classname', 'assignment_remarks.comment', 'assignment_remarks.score', 'addsection_secs.sectionname', 'addsubject_secs.subjectname', 'users.firstname', 'users.lastname')->get();

        return view('secondary.assignment.viewsubmission', compact('schooldetails', 'submissions'));
    }


    public function remarkAssignment(Request $request)
    {
        $validated = $request->validate([
            'comment' => 'required',
            'submissionid' => 'required'
        ]);

        // return back()->with('info', 'Module under maintainance. Will be available soon');

        $getAssignment = AssignmentTable::find($request->assignment_id);

        if($getAssignment->sub_assesment_id != "0"){

            $schoolDetails = Addpost::find(Auth::user()->schoolid);

            $addRemark = AssignmentRemark::updateOrCreate(
                ['submissionid'=>$request->submissionid],
                ['comment'=>$request->comment, 'submissionid'=>$request->submissionid, 'score'=>$request->score, 'assesment_id'=>$getAssignment->sub_assesment_id]
            );
    
            $updateStatus = AssignmentSubmission::find($request->submissionid);
            $updateStatus->status = 1;
            $updateStatus->save();
    
            $user_student = Addstudent_sec::where('usernamesystem', $updateStatus->userid)->first();

            // getAddmarks data
            // $subjectid = '';
            // $section_id = '';
            // $schoolsession = Auth::user()->schoolid;
            // $student_id = $user_student->id;
            // $scrores = '';
            // $class_id = '';

            $assessment_model = SubAssesmentModel::where('id', $getAssignment->sub_assesment_id)->first();

            $recordMarks = RecordMarks::updateOrcreate(
                ['subjectid'=>$updateStatus->subjectid, 'session'=>$updateStatus->session, 'term'=>$updateStatus->term,
                'section_id'=>$user_student->studentsection, 'student_id'=>$user_student->id, 'assesment_id'=>$assessment_model->catid, 'subassessment_id'=>$getAssignment->sub_assesment_id],
                ['subjectid'=>$updateStatus->subjectid, 'session'=>$updateStatus->session, 'term'=>$updateStatus->term,
                'section_id'=>$user_student->studentsection, 'student_id'=>$user_student->id, 'scrores'=>$request->score, 
                'class_id'=>$getAssignment->classid, 'school_id'=>Auth::user()->schoolid, 'assesment_id'=>$assessment_model->catid, 'subassessment_id'=>$getAssignment->sub_assesment_id]);


                //compile subject total
                $getSubjecttoal = RecordMarks::where(['subjectid'=>$updateStatus->subjectid, 'session'=>$updateStatus->session, 'term'=>$updateStatus->term, 'section_id'=>$user_student->studentsection, 'student_id'=>$user_student->id])->sum('scrores');
                //get student grade.
                $getGrade = Addgrades_sec::where('schoolid', Auth::user()->schoolid)->get();
                $gradeFinal = '';
                for ($i=0; $i < count($getGrade); $i++) { 
                    if ($getSubjecttoal >= (int)$getGrade[$i]->marksfrom && $getSubjecttoal <= (int)$getGrade[$i]->marksto) {
                        $gradeFinal = $getGrade[$i]->gpaname;
                    }
                }
                //add values to record table
                $addTotalMarks = AssessmentTableTotal::updateOrcreate(
                    ['regno'=>$user_student->id, 'schoolid'=>Auth::user()->schoolid, 'classid'=>$getAssignment->classid, 'subjectid'=>$updateStatus->subjectid,
                    'term' =>$updateStatus->term, 'session'=>$updateStatus->session, 'sectionid'=>$user_student->studentsection],
                    ['regno'=>$user_student->id, 'schoolid'=>Auth::user()->schoolid,
                    'catid'=>$assessment_model->catid, 'classid'=>$getAssignment->classid, 'subjectid'=>$updateStatus->subjectid,
                    'totals'=>$getSubjecttoal, 'term' =>$updateStatus->term, 'session'=>$updateStatus->session, 'sectionid'=>$user_student->studentsection, 'grade'=>$gradeFinal]);
                    DB::beginTransaction();
                    try {
                    //calculate student position
                    $getAllTotalMarks = AssessmentTableTotal::where(['schoolid'=>Auth::user()->schoolid,
                                        'classid'=>$getAssignment->classid, 'subjectid'=>$updateStatus->subjectid, 'term' =>$updateStatus->term, 'session'=>$updateStatus->session, 'sectionid'=>$user_student->studentsection,])->orderBy('totals', 'desc')->get();
                        $subjectscrorearray = array();
                        for ($i=0; $i < count($getAllTotalMarks); $i++) { 
                            $score = (int)$getAllTotalMarks[$i]['totals'];
                                array_push($subjectscrorearray, $score);
                        }
                        for ($i=0; $i < count($getAllTotalMarks); $i++) { 
                            $mainScore = (int)$getAllTotalMarks[$i]['totals'];
                            $mainScoreId = $getAllTotalMarks[$i]['id'];
                            $positiongotten = array_search($mainScore, $subjectscrorearray);
                            $newPosition = $positiongotten + 1;
                            DB::table('assessment_table_totals')->where('id',$mainScoreId)->update(array(
                                'position'=>$newPosition
                            ));
                        }
                        DB::commit();
                        // all good
                        // return $subjectscrorearray;
                        
                    } catch (\Exception $e) {
                        DB::rollback();
                        return $e;
                        // something went wrong
                    }
            

            return back()->with('success', 'Remart added successfully');

        }else{
            $schoolDetails = Addpost::find(Auth::user()->schoolid);

            $addRemark = AssignmentRemark::updateOrCreate(
                ['submissionid'=>$request->submissionid],
                ['comment'=>$request->comment, 'submissionid'=>$request->submissionid, 'score'=>$request->score, 'assesment_id'=>$getAssignment->sub_assesment_id]
            );

            return back()->with('success', 'Remart added successfully');
        }

        return back()->with('success', 'Remart added successfully');
    }


}
