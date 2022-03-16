<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classlist_sec;
use App\Addsection_sec;
use App\Addsubject_sec;
use App\Addmark_sec;
use App\Addpost;
use App\Addgrades_sec;
use Validator;
use App\ResultAverage;
use App\Addstudent_sec;
use App\PromotionAverage_sec;
use App\Addteachers_sec;
use App\AssesmentModel;
use App\AssessmentTableTotal;
use App\CLassSubjects;
use App\ElectiveAdd;
use App\RecordMarks;
use App\Repository\Result\GetSubjectPosition;
use App\SubAssesmentModel;
use App\SubjectScoreAllocation;
use App\TeacherSubjects;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddstudentmakrsController_secs extends Controller
{

    private $addpost;
    private $addsubject_sec;
    private $addmark_sec;

    public function __construct(Addpost $addpost, Addsubject_sec $addsubject_sec, Addmark_sec $addmark_sec)
    {

        $this->addpost = $addpost;
        $this->addsubject_sec = $addsubject_sec;
        $this->addmark_sec = $addmark_sec;
    }

    public function index()
    {

        $addpost = $this->addpost->where('id', Auth::user()->schoolid)->first();

        if (Auth::user()->hasRole('Teacher')) {
            $teachersSubjects = TeacherSubjects::where('user_id', Auth::user()->id)->pluck('subject_id');

            $arrayOfSubjects = array();

            for ($i = 0; $i < count($teachersSubjects); $i++) {

                $addsubject_sec = Addsubject_sec::join('classlist_secs', 'classlist_secs.id', '=', 'addsubject_secs.classid')
                    ->where('addsubject_secs.id', $teachersSubjects[$i])
                    ->select("classlist_secs.classname", "classlist_secs.id")->first();

                array_push($arrayOfSubjects, $addsubject_sec);
            }

            $arrayOfClassesMain = array_unique($arrayOfSubjects);

            //    return view('secondary.teachers.addmarks.studentmarks', compact('addpost', 'arrayOfClassesMain'));
            $schooldetails = Addpost::find(Auth::user()->schoolid);

            return view('secondary.teachers.addmarks.studentmarksreact', compact('schooldetails'));
        }


        // return view('secondary.adminside.markmanage_secs', compact('addpost'));

        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('secondary.adminside.managemarkreact', compact('schooldetails'));
    }

    public function fetchstudentssubject(Request $request, $classid, $sectionid)
    {

        $classAllocatedSubject = CLassSubjects::where(['classid' => $classid, 'sectionid' => $sectionid])->pluck('subjectid')->toArray();
        $subjectsmain = array();
        for ($i = 0; $i < count($classAllocatedSubject); $i++) {
            $subjectlistsingle = Addsubject_sec::find($classAllocatedSubject[$i]);
            array_push($subjectsmain, $subjectlistsingle);
        }
        return response()->json(['subjectlist' => $subjectsmain]);
    }

    public function fetchsubjectdetails(Request $request)
    {

        //----------------------------------------------------------------------------------------------------//
        //                                  fetch all marks for each subject                                  //
        //----------------------------------------------------------------------------------------------------//

        $subjectlist = $this->addsubject_sec->where(['id' => $request->input('subjectid')])->get();
        return response()->json(['subjectdetails' => $subjectlist]);
    }

    public function getallstudentsandmarks(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'selected_class' => 'required',
                'selected_subject' => 'required',
                'selected_term' => 'required',
                'currentsession' => 'required',
                'selected_section' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['response' => "feilds"]);
            }

            $session = $request->input('currentsession');
            $classId = $request->input('selected_class');
            $subjectbyclassid = $request->input('selected_subject');
            $schoolterm = $request->input('selected_term');
            $studentsection = $request->input('selected_section');

            // fetch all regno for all marks

            $checksubjecttype = CLassSubjects::where(['subjectid' => $subjectbyclassid, 'classid' => $classId, 'sectionid' => $studentsection])->first();

            if ($checksubjecttype->subjecttype == 2) {

                $a = $this->addmark_sec->where(['schoolid' => Auth::user()->schoolid, 'classid' => $classId, 'subjectid' => $subjectbyclassid, 'term' => $schoolterm, 'section' => $studentsection, 'session' => $session])->take('regno');

                $studentlist = DB::table('addstudent_secs')
                    ->join('users', 'users.id', '=', 'addstudent_secs.usernamesystem')
                    ->leftJoin('assessment_table_totals', function ($join) use ($subjectbyclassid, $schoolterm) {
                        $join->on('assessment_table_totals.regno', '=', 'addstudent_secs.id');
                        $join->where(['assessment_table_totals.subjectid' => $subjectbyclassid, 'assessment_table_totals.term' => $schoolterm]);
                    })
                    ->select('addstudent_secs.*', 'users.firstname', 'users.middlename', 'users.lastname', 'assessment_table_totals.totals', 'assessment_table_totals.grade', 'assessment_table_totals.id as markid', 'assessment_table_totals.position')
                    ->where(['addstudent_secs.classid' => $classId, 'addstudent_secs.schoolsession' => $session, 'addstudent_secs.studentsection' => $studentsection])->get();

                $assessment = AssesmentModel::where('schoolid', Auth::user()->schoolid)->pluck('id')->toArray();

                for ($i = 0; $i < count($assessment); $i++) {
                }


                return response()->json(['studentlist' => $studentlist, 'assessment' => $assessment], 200);
            } else {

                $a = $this->addmark_sec->where(['schoolid' => Auth::user()->schoolid, 'classid' => $classId, 'subjectid' => $subjectbyclassid, 'term' => $schoolterm, 'section' => $studentsection, 'session' => $session])->take('regno');

                $studentlist = Addstudent_sec::join('users', 'users.id', '=', 'addstudent_secs.usernamesystem')
                    ->leftJoin('assessment_table_totals', function ($join) use ($subjectbyclassid, $schoolterm) {
                        $join->on('assessment_table_totals.regno', '=', 'addstudent_secs.id');
                        $join->where(['assessment_table_totals.subjectid' => $subjectbyclassid, 'assessment_table_totals.term' => $schoolterm]);
                    })
                    ->select('addstudent_secs.*', 'users.firstname', 'users.middlename', 'users.lastname', 'assessment_table_totals.totals', 'assessment_table_totals.grade', 'assessment_table_totals.id as markid')
                    ->where(['addstudent_secs.classid' => $classId, 'addstudent_secs.schoolsession' => $session, 'addstudent_secs.studentsection' => $studentsection])->get();

                $mainList = array();

                $checkElective = ElectiveAdd::where(['classid' => $classId, 'sectionid' => $studentsection, 'subjectid' => $subjectbyclassid])->pluck('regno')->toArray();

                for ($i = 0; $i < count($studentlist); $i++) {

                    if (in_array($studentlist[$i]['id'], $checkElective)) {
                        array_push($mainList, $studentlist[$i]);
                    }
                }

                return response()->json(['studentlist' => collect($mainList), 'a' => $a], 200);
            }
        } catch (\Throwable $th) {
            // return response()->json(['error'=>$th]);
            return $th;
        }
    }

    public function addmarksmiain(GetSubjectPosition $getSubjectPosition, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'classidmain' => 'required',
            'currentsessionform' => 'required',
            'currentterm' => 'required',
            'studentregno' => 'required',
            'subjectid' => 'required'
        ]);

        try {
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->keys()]);
            }
            $getSubjectPosition->addResultMain($request);

            return response()->json(['success' => "success"], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }
    }


    public function fetchStudentSections($id)
    {

        //$id subject id

        try {
            if (Auth::user()->role == "Teacher") {

                $getTeachersSubject = TeacherSubjects::where(['user_id' => Auth::user()->id, 'subject_id' => $id])->pluck('section_id')->toArray();

                $sectionsArray = array();

                for ($i = 0; $i < count($getTeachersSubject); $i++) {

                    $getSection = Addsection_sec::find($getTeachersSubject[$i]);

                    if ($getSection != null) {
                        array_push($sectionsArray, $getSection);
                    }
                }

                if (count($sectionsArray) < 1) {
                    return response()->json(['schoolsection' => 'notallocatedtoyou']);
                } else {
                    return response()->json(['schoolsection' => $sectionsArray]);
                }
            }

            $schoolsection = Addsection_sec::where('schoolid', Auth::user()->schoolid)->get();

            return response()->json(['schoolsection' => $schoolsection]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => $th]);
        }
    }

    public function getSchoolBasicDetails()
    {
        $schooldetails = Addpost::find(Auth::user()->schoolid);

        $classlist = Classlist_sec::where(['schoolid' => Auth::user()->schoolid, 'status' => 1])->get();

        $subjects = Addsubject_sec::where('schoolid', Auth::user()->schoolid)->get();

        $schoolsection = Addsection_sec::where('schoolid', Auth::user()->schoolid)->get();

        // $subjectScore = SubjectScoreAllocation::where('schoolid', Auth::user()->schoolid)->first();

        $assessment = AssesmentModel::where('schoolid', Auth::user()->schoolid)->get();




        return response()->json(['classlist' => $classlist, 'subjects' => $subjects, 'schoolsection' => $schoolsection, 'schooldetails' => $schooldetails, 'assessment' => $assessment]);
    }

    public function fetchsubassessment($studentid, $subjectid)
    {
        try {

            $subassessment = SubAssesmentModel::where(['status' => 1, 'catid' => $id])->get();

            return response()->json(['subassessment' => $subassessment]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['msg' => $th]);
        }
    }

    public function addStudentRecord(Request $request)
    {

        try {

            $schooldetails = Addpost::find(Auth::user()->schoolid);
            $subjectWithMarks = $request->toArray();

            try {
                $errorArray = array();

                for ($i = 0; $i < count($subjectWithMarks); $i++) {

                    $assessments = SubAssesmentModel::find($subjectWithMarks[$i]['subAssId']);

                    if ((int)$subjectWithMarks[$i]['score'] > (int)$assessments->maxmarks) {
                        array_push($errorArray, "value entered for ".$assessments->subname." is above the required");
                    }
                }

                if (count($errorArray) > 0) {

                    return response()->json(['response' => $errorArray, 'code' => 400], 200);
                }
            } catch (\Throwable $th) {
                //throw $th;

                return response()->json(['response' => $th, 'code' => 400], 400);
            }

            // $checkEnteredRecord = RecordMarks::where([])->sum('');

            for ($i = 0; $i < count($subjectWithMarks); $i++) {



                $getAssessmentId = SubAssesmentModel::find($subjectWithMarks[$i]['subAssId']);

                // return response()->json(['response' => "Process was successful", 'data'=>$getAssessmentId, 'code' => 200], 200);

                $recordMarks = RecordMarks::updateOrcreate(
                    [
                        'subjectid' => $subjectWithMarks[$i]['subjectId'], 'session' => $schooldetails->schoolsession, 'term' => $schooldetails->term,
                        'section_id' => $subjectWithMarks[$i]['sectionId'], 'student_id' => $subjectWithMarks[$i]['studentId'], 'assesment_id' => $getAssessmentId->catid, 'subassessment_id' => $subjectWithMarks[$i]['subAssId']
                    ],
                    [
                        'subjectid' => $subjectWithMarks[$i]['subjectId'], 'session' => $schooldetails->schoolsession, 'term' => $schooldetails->term,
                        'section_id' => $subjectWithMarks[$i]['sectionId'], 'student_id' => $subjectWithMarks[$i]['studentId'], 'scrores' => $subjectWithMarks[$i]['score'],
                        'class_id' => $subjectWithMarks[$i]['classId'], 'school_id' => Auth::user()->schoolid, 'assesment_id' => $getAssessmentId->catid, 'subassessment_id' => $subjectWithMarks[$i]['subAssId']
                    ]
                );


                $getSubjecttoal = RecordMarks::where(['subjectid' => $subjectWithMarks[$i]['subjectId'], 'session' => $schooldetails->schoolsession, 'term' => $schooldetails->term, 'section_id' => $subjectWithMarks[$i]['sectionId'], 'student_id' => $subjectWithMarks[$i]['studentId']])->sum('scrores');

                //get student grade.
                $getGrade = Addgrades_sec::where('schoolid', Auth::user()->schoolid)->get();

                $gradeFinal = '';
                for ($l = 0; $l < count($getGrade); $l++) {
                    if ($getGrade[$l]->marksfrom <= $getSubjecttoal && $getSubjecttoal <= $getGrade[$l]->marksto) {
                        $gradeFinal = $getGrade[$l]->gpaname;
                    }
                }



                //add values to record table
                $addTotalMarks = AssessmentTableTotal::updateOrcreate(
                    [
                        'regno' => $subjectWithMarks[$i]['studentId'], 'schoolid' => Auth::user()->schoolid, 'classid' => $subjectWithMarks[$i]['classId'], 'subjectid' => $subjectWithMarks[$i]['subjectId'],
                        'term' => $schooldetails->term, 'session' => $schooldetails->schoolsession, 'sectionid' => $subjectWithMarks[$i]['sectionId']
                    ],
                    [
                        'regno' => $subjectWithMarks[$i]['studentId'], 'schoolid' => Auth::user()->schoolid,
                        'catid' => $getAssessmentId->catid, 'classid' => $subjectWithMarks[$i]['classId'], 'subjectid' => $subjectWithMarks[$i]['subjectId'],
                        'totals' => $getSubjecttoal, 'term' => $schooldetails->term, 'session' => $schooldetails->schoolsession, 'sectionid' => $subjectWithMarks[$i]['sectionId'], 'grade' => $gradeFinal
                    ]
                );



                $getAllTotalMarks = AssessmentTableTotal::where([
                    'schoolid' => Auth::user()->schoolid,
                    'classid' => $subjectWithMarks[$i]['classId'], 'subjectid' => $subjectWithMarks[$i]['subjectId'], 'term' => $schooldetails->term, 'session' => $schooldetails->schoolsession, 'sectionid' => $subjectWithMarks[$i]['sectionId'],
                ])->orderBy('totals', 'desc')->get();



                $subjectscrorearray = array();

                for ($j = 0; $j < count($getAllTotalMarks); $j++) {
                    $score = (int)$getAllTotalMarks[$j]['totals'];
                    array_push($subjectscrorearray, $score);
                }

                for ($k = 0; $k < count($getAllTotalMarks); $k++) {
                    $mainScore = (int)$getAllTotalMarks[$k]['totals'];
                    $mainScoreId = $getAllTotalMarks[$k]['id'];
                    // return response()->json(['response' => "Process was successful", 'data' => $getAllTotalMarks, 'code' => 200], 200);
                    $positiongotten = array_search($mainScore, $subjectscrorearray);
                    $newPosition = $positiongotten + 1;
                    DB::table('assessment_table_totals')->where('id', $mainScoreId)->update(array(
                        'position' => $newPosition
                    ));
                }
            }

            return response()->json(['response' => "Process was successful", 'data' => $subjectscrorearray, 'code' => 200], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => $th, 'code' => 400], 400);
        }


















        try {
            // return response()->json(['response' => "Process was successful", "data" => $request[0], 'code' => 200], 200);



            $schooldetails = Addpost::find(Auth::user()->schoolid);

            for ($i = 0; $i < $request->count(); $i++) {

                $getAssessmentId = SubAssesmentModel::find($request[$i]->subAssId);

                $recordMarks = RecordMarks::updateOrcreate(
                    [
                        'subjectid' => $request[$i]->subjectId, 'session' => $schooldetails->schoolsession, 'term' => $schooldetails->term,
                        'section_id' => $request[$i]->sectionId, 'student_id' => $request[$i]->studentId, 'assesment_id' => $getAssessmentId->catId, 'subassessment_id' => $request[$i]->subAssId
                    ],
                    [
                        'subjectid' => $request[$i]->subjectId, 'session' => $schooldetails->schoolsession, 'term' => $schooldetails->term,
                        'section_id' => $request[$i]->sectionId, 'student_id' => $request[$i]->studentId, 'scrores' => $request[$i]->score,
                        'class_id' => $request[$i]->classId, 'school_id' => Auth::user()->schoolid, 'assesment_id' => $getAssessmentId->catId, 'subassessment_id' => $request[$i]->subAssId
                    ]
                );








                $getAllTotalMarks = AssessmentTableTotal::where([
                    'schoolid' => Auth::user()->schoolid,
                    'classid' => $request[$i]->classId, 'subjectid' => $request[$i]->subjectId, 'term' => $schooldetails->term, 'session' => $schooldetails->schoolsession, 'sectionid' => $request[$i]->sectionId,
                ])->orderBy('totals', 'desc')->get();

                $subjectscrorearray = array();

                for ($j = 0; $j < count($getAllTotalMarks); $j++) {
                    $score = (int)$getAllTotalMarks[$j]['totals'];
                    array_push($subjectscrorearray, $score);
                }
                for ($k = 0; $k < count($getAllTotalMarks); $k++) {
                    $mainScore = (int)$getAllTotalMarks[$k]['totals'];
                    $mainScoreId = $getAllTotalMarks[$k]['id'];
                    $positiongotten = array_search($mainScore, $subjectscrorearray);
                    $newPosition = $positiongotten + 1;
                    DB::table('assessment_table_totals')->where('id', $mainScoreId)->update(array(
                        'position' => $newPosition
                    ));
                }
            }

            return response()->json(['response' => "Process was successful", 'code' => 200], 200);


            //check if the value entered is within range of allocated marks
            $checkRange = SubAssesmentModel::find($request->subassessment_id);

            if ($request->scrores > $checkRange->maxmarks) {
                return response()->json(['response' => "marks entered must be within the allocated range...", 'code' => 409], 200);
            }


            $recordMarks = RecordMarks::updateOrcreate(
                [
                    'subjectid' => $request->subjectid, 'session' => $schooldetails->schoolsession, 'term' => $schooldetails->term,
                    'section_id' => $request->section_id, 'student_id' => $request->student_id, 'assesment_id' => $request->assesment_id, 'subassessment_id' => $request->subassessment_id
                ],
                [
                    'subjectid' => $request->subjectid, 'session' => $schooldetails->schoolsession, 'term' => $schooldetails->term,
                    'section_id' => $request->section_id, 'student_id' => $request->student_id, 'scrores' => $request->scrores,
                    'class_id' => $request->class_id, 'school_id' => Auth::user()->schoolid, 'assesment_id' => $request->assesment_id, 'subassessment_id' => $request->subassessment_id
                ]
            );

            //compile subject total
            $getSubjecttoal = RecordMarks::where(['subjectid' => $request->subjectid, 'session' => $schooldetails->schoolsession, 'term' => $schooldetails->term, 'section_id' => $request->section_id, 'student_id' => $request->student_id])->sum('scrores');
            //get student grade.
            $getGrade = Addgrades_sec::where('schoolid', Auth::user()->schoolid)->get();
            $gradeFinal = '';
            for ($i = 0; $i < count($getGrade); $i++) {
                if ($getGrade[$i]->marksfrom <= $getSubjecttoal && $getSubjecttoal <= $getGrade[$i]->marksto) {
                    $gradeFinal = $getGrade[$i]->gpaname;
                }
            }

            //add values to record table
            $addTotalMarks = AssessmentTableTotal::updateOrcreate(
                [
                    'regno' => $request->student_id, 'schoolid' => Auth::user()->schoolid, 'classid' => $request->class_id, 'subjectid' => $request->subjectid,
                    'term' => $schooldetails->term, 'session' => $schooldetails->schoolsession, 'sectionid' => $request->section_id
                ],
                [
                    'regno' => $request->student_id, 'schoolid' => Auth::user()->schoolid,
                    'catid' => $request->assesment_id, 'classid' => $request->class_id, 'subjectid' => $request->subjectid,
                    'totals' => $getSubjecttoal, 'term' => $schooldetails->term, 'session' => $schooldetails->schoolsession, 'sectionid' => $request->section_id, 'grade' => $gradeFinal
                ]
            );
            DB::beginTransaction();
            try {
                //calculate student position
                $getAllTotalMarks = AssessmentTableTotal::where([
                    'schoolid' => Auth::user()->schoolid,
                    'classid' => $request->class_id, 'subjectid' => $request->subjectid, 'term' => $schooldetails->term, 'session' => $schooldetails->schoolsession, 'sectionid' => $request->section_id,
                ])->orderBy('totals', 'desc')->get();
                $subjectscrorearray = array();
                for ($i = 0; $i < count($getAllTotalMarks); $i++) {
                    $score = (int)$getAllTotalMarks[$i]['totals'];
                    array_push($subjectscrorearray, $score);
                }
                for ($i = 0; $i < count($getAllTotalMarks); $i++) {
                    $mainScore = (int)$getAllTotalMarks[$i]['totals'];
                    $mainScoreId = $getAllTotalMarks[$i]['id'];
                    $positiongotten = array_search($mainScore, $subjectscrorearray);
                    $newPosition = $positiongotten + 1;
                    DB::table('assessment_table_totals')->where('id', $mainScoreId)->update(array(
                        'position' => $newPosition
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
            return response()->json(['response' => "Process was successful", 'code' => 200], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => $th, 'code' => 400], 200);
        }
    }

    public function getScoreRecord(Request $request)
    {

        try {
            $getScoreRecord = RecordMarks::join('assesment_models', 'assesment_models.id', '=', 'record_marks.assesment_id')
                ->join('sub_assesment_models', 'sub_assesment_models.id', '=', 'record_marks.subassessment_id')
                ->where(['record_marks.subjectid' => $request->selected_subject, 'record_marks.class_id' => $request->selected_class, 'record_marks.term' => $request->selected_term, 'record_marks.session' => $request->currentsession, 'student_id' => $request->userid])
                ->select('record_marks.*', 'assesment_models.name', 'sub_assesment_models.subname')->get();

            return response()->json(['response' => $getScoreRecord, 'code' => 200], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }
    }
}
