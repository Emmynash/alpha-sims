<?php

namespace App\Services;

use App\Addgrades_sec;
use App\Addpost;
use App\Addstudent_sec;
use App\AssessmentTableTotal;
use App\AssignmentRemark;
use App\AssignmentSubmission;
use App\AssignmentTable;
use App\RecordMarks;
use App\SubAssesmentModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AssignmentService{

    public function assignmentRemark(Request $request)
    {
        try {

            $getAssignment = AssignmentTable::find($request->assignment_id);
            $schoolDetails = Addpost::find(Auth::user()->schoolid);

        if ($getAssignment->sub_assesment_id != "0") {



            $addRemark = AssignmentRemark::updateOrCreate(
                ['submissionid' => $request->submissionid],
                ['comment' => $request->comment, 'submissionid' => $request->submissionid, 'score' => $request->score, 'assesment_id' => $getAssignment->sub_assesment_id]
            );

            $updateStatus = AssignmentSubmission::find($request->submissionid);
            $updateStatus->status = 1;
            $updateStatus->save();

            $user_student = Addstudent_sec::where('usernamesystem', $updateStatus->userid)->first();


            $assessment_model = SubAssesmentModel::where('id', $getAssignment->sub_assesment_id)->first();

            $recordMarks = RecordMarks::updateOrcreate(
                [
                    'subjectid' => $updateStatus->subjectid, 'session' => $updateStatus->session, 'term' => $updateStatus->term,
                    'section_id' => $user_student->studentsection, 'student_id' => $user_student->id, 'assesment_id' => $assessment_model->catid, 'subassessment_id' => $getAssignment->sub_assesment_id
                ],
                [
                    'subjectid' => $updateStatus->subjectid, 'session' => $updateStatus->session, 'term' => $updateStatus->term,
                    'section_id' => $user_student->studentsection, 'student_id' => $user_student->id, 'scrores' => $request->score,
                    'class_id' => $getAssignment->classid, 'school_id' => Auth::user()->schoolid, 'assesment_id' => $assessment_model->catid, 'subassessment_id' => $getAssignment->sub_assesment_id
                ]
            );


            //compile subject total
            $getSubjecttoal = RecordMarks::where(['subjectid' => $updateStatus->subjectid, 'session' => $updateStatus->session, 'term' => $updateStatus->term, 'section_id' => $user_student->studentsection, 'student_id' => $user_student->id])->sum('scrores');
            //get student grade.
            $getGrade = Addgrades_sec::where('schoolid', Auth::user()->schoolid)->get();
            $gradeFinal = '';
            for ($i = 0; $i < count($getGrade); $i++) {
                if ($getSubjecttoal >= (int)$getGrade[$i]->marksfrom && $getSubjecttoal <= (int)$getGrade[$i]->marksto) {
                    $gradeFinal = $getGrade[$i]->gpaname;
                }
            }
            //add values to record table
            $addTotalMarks = AssessmentTableTotal::updateOrcreate(
                [
                    'regno' => $user_student->id, 'schoolid' => Auth::user()->schoolid, 'classid' => $getAssignment->classid, 'subjectid' => $updateStatus->subjectid,
                    'term' => $updateStatus->term, 'session' => $updateStatus->session, 'sectionid' => $user_student->studentsection
                ],
                [
                    'regno' => $user_student->id, 'schoolid' => Auth::user()->schoolid,
                    'catid' => $assessment_model->catid, 'classid' => $getAssignment->classid, 'subjectid' => $updateStatus->subjectid,
                    'totals' => $getSubjecttoal, 'term' => $updateStatus->term, 'session' => $updateStatus->session, 'sectionid' => $user_student->studentsection, 'grade' => $gradeFinal
                ]
            );
            DB::beginTransaction();
            try {
                //calculate student position
                $getAllTotalMarks = AssessmentTableTotal::where([
                    'schoolid' => Auth::user()->schoolid,
                    'classid' => $getAssignment->classid, 'subjectid' => $updateStatus->subjectid, 'term' => $updateStatus->term, 'session' => $updateStatus->session, 'sectionid' => $user_student->studentsection,
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


            return "success";
        } else {


            

            $addRemark = AssignmentRemark::updateOrCreate(
                ['submissionid' => $request->submissionid],
                ['comment' => $request->comment, 'submissionid' => $request->submissionid, 'score' => $request->score, 'assesment_id' => $getAssignment->sub_assesment_id]
            );

            return "success";
        }
            
        } catch (\Throwable $th) {
            return "failed";
        }
    }

}