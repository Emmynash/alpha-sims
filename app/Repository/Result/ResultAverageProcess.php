<?php

namespace App\Repository\Result;

use Illuminate\Http\Request;
use App\Addmark_sec;
use App\Addpost;
use Carbon\Carbon;
use App\ResultAverage;
use App\Addstudent_sec;
use App\PromotionAverage_sec;
use App\AssessmentResultModel;
use App\AssessmentScoreResultModel;
use App\AssessmentTableTotal;
use App\CLassSubjects;
use App\ComputedAverages;
use App\ElectiveAdd;
use App\Models\ClassAverage;
use App\Models\StudentAverage;
use App\RecordMarks;
use App\ResultReadyModel;
use App\ResultSubjectsModel;
use App\SubAssesmentModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ResultAverageProcess
{

    public function processResultAverage(Request $request)
    {


        $classid = $request->classid;
        $section = $request->section_id;
        $schooldata = Addpost::where('id', Auth::user()->schoolid)->first();
        $term = $schooldata->term;
        $schoolsession = $schooldata->schoolsession;



        DB::beginTransaction();

        try {


            // $getSubCategory = SubAssesmentModel::join('assesment_models', 'assesment_models.id', '=', 'sub_assesment_models.catid')->select('sub_assesment_models.*', 'assesment_models.name')->where('sub_assesment_models.schoolid', Auth::user()->schoolid)->get();

            $schoolsession = DB::table('addposts')->where('id', Auth::user()->schoolid)->first()->schoolsession;


            DB::table('addstudent_secs')->where(['classid' => $classid, 'studentsection' => $section])->orderBy('id')->chunk(50, function ($students) use ($classid, $section, $term, $schoolsession) {



                foreach ($students as $student) {

                    $getSubjectAverage = DB::table('assessment_table_totals')->where(['term' => $term, 'session' => $schoolsession, 'classid' => $classid, 'regno' => $student->id])->pluck('totals')->toArray();

                    if (count($getSubjectAverage) > 0) {
                        $studentAverage =  StudentAverage::updateOrCreate(
                            ["regNo" => $student->id, "session" => $schoolsession, "term" => $term, 'section'=>$section],
                            ["regNo" => $student->id, "session" => $schoolsession, "term" => $term, "classid" => $classid, 'section'=>$section, "average" => array_sum($getSubjectAverage) / count($getSubjectAverage), 'examsTotal'=>array_sum($getSubjectAverage)]
                        );
                    } else {
                        $studentAverage =  StudentAverage::updateOrCreate(
                            ["regNo" => $student->id, "session" => $schoolsession, "term" => $term, 'section'=>$section],
                            ["regNo" => $student->id, "session" => $schoolsession, "term" => $term, "classid" => $classid, 'section'=>$section, "average" => 0, 'examsTotal'=>0]
                        );
                    }
                    
                    
                }
            });


            $StudentExamsTotal = StudentAverage::where(["session" => $schoolsession, "term" => $term, "classid" => $classid, 'section'=>$section])->sum('examsTotal');

           
            $getStudentsArray = Addstudent_sec::where(['classid' => $classid, 'studentsection'=>$section, 'schoolid'=>Auth::user()->schoolid])->pluck('id');

            // $scoresGrandTotal = DB::table('assessment_table_totals')
            //                     ->whereIn('regno', $getStudentsArray) 
            //                     ->sum('totals');

            $subjectCount = CLassSubjects::where(['classid'=>$classid, 'sectionId'=>$section])->get();

            // $sum = array_sum($computeAverage);

            $multiply = (count($getStudentsArray))*count($subjectCount);

            $divide = $StudentExamsTotal/$multiply;

            // return $divide;


            if ($StudentExamsTotal > 0) {

                ClassAverage::updateOrcreate([
                    'session' => $schoolsession,
                    'term' => $term,
                    'classid' => $classid,
                    'sectionId' => $section
                ], [
                    'average' => $divide,
                    'session' => $schoolsession,
                    'term' => $term,
                    'classid' => $classid,
                    'sectionId' => $section
                ]);
            } else {
                ClassAverage::updateOrcreate([
                    'session' => $schoolsession,
                    'term' => $term,
                    'classid' => $classid,
                    'sectionId' => $section
                ], [
                    'average' => 0,
                    'session' => $schoolsession,
                    'term' => $term,
                    'classid' => $classid,
                    'sectionId' => $section
                ]);
            }


            //change status of result ready model 
            $resultReady = ResultReadyModel::find($request->notif_id);
            $resultReady->status = 1;
            $resultReady->updated_at = Carbon::now()->toDateTimeString();
            $resultReady->save();


            DB::commit();

            return "success";
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            // return $e;

            return $e;
        }
    }

    public function processResultAveragesds(Request $request)
    {



        DB::transaction(function () use ($request) {
            $classid = $request->classid;
            $section = $request->section_id;
            $schooldata = Addpost::where('id', Auth::user()->schoolid)->first();
            $term = $schooldata->term;
            $schoolsession = $schooldata->schoolsession;

            try {






                $checkaverage = ResultAverage::where(['classid' => $classid, 'term' => $term, 'session' => $schoolsession, 'section_id' => $section])->get();

                if (count($checkaverage) > 0) {

                    for ($i = 0; $i < count($checkaverage); $i++) {
                        $deleteAverage = ResultAverage::find($checkaverage[$i]['id']);
                        $deleteAverage->delete();
                    }

                    $resultReady = ResultReadyModel::find($request->notif_id);
                    $resultReady->status = 0;
                    $resultReady->save();

                    return 'already';
                }

                $studentregnumberarray = Addstudent_sec::where(['classid' => $classid, 'schoolsession' => $schoolsession, 'studentsection' => $section])->pluck('id')->toArray(); // get id/regno of students in class

                // return response()->json(['studentregnumberarray'=>$studentregnumberarray]);

                for ($i = 0; $i < count($studentregnumberarray); $i++) {

                    $singleregno = $studentregnumberarray[$i];

                    //get student subjects id

                    $studentsSubjects = CLassSubjects::where(['classid' => $classid, 'sectionid' => $section, 'schoolid' => Auth::user()->schoolid, 'subjecttype' => 2])->pluck('subjectid')->toArray(); //get all student core subjects
                    $getStudentElective = ElectiveAdd::where(['regno' => $singleregno, 'classid' => $classid, 'sectionid' => $section])->pluck('subjectid')->toArray(); // get all student's elective subjects

                    $studentmarks = Addmark_sec::where(['classid' => $classid, 'term' => $term, 'regno' => $singleregno, 'session' => $schoolsession, 'section' => $section])->pluck('totalmarks')->toArray();

                    $scoresarraysingle = array();


                    $coursesum = array_sum($studentmarks);

                    $allsubjectcount = count($studentsSubjects) + count($getStudentElective);

                    if ($coursesum > 0 && $allsubjectcount > 0) {


                        $averagevalue = $coursesum / $allsubjectcount;


                        $resultAverageAdd = new ResultAverage();
                        $resultAverageAdd->regno = $singleregno;
                        $resultAverageAdd->systemnumber = "0";
                        $resultAverageAdd->schoolid = Auth::user()->schoolid;
                        $resultAverageAdd->classid = $classid;
                        $resultAverageAdd->term = $term;
                        $resultAverageAdd->session = $schoolsession;
                        $resultAverageAdd->sumofmarks = $coursesum;
                        $resultAverageAdd->average = $averagevalue;
                        $resultAverageAdd->position = "0";
                        $resultAverageAdd->section_id = $section;
                        $resultAverageAdd->save();

                        // return $resultAverageAdd;
                    }
                }

                $processposition = ResultAverage::where(['classid' => $classid, 'term' => $term, 'session' => $schoolsession, 'section_id' => $section])->orderBy('average', 'desc')->get();

                $positiondeterminantarray = array();

                for ($i = 0; $i < count($processposition); $i++) {
                    $id = $processposition[$i]['average'];
                    array_push($positiondeterminantarray, $id);
                }

                for ($i = 0; $i < count($processposition); $i++) {

                    $mainScore = $processposition[$i]['average'];
                    $mainScoreId = $processposition[$i]['id'];

                    $positiongotten = array_search($mainScore, $positiondeterminantarray);

                    $updateposition = ResultAverage::find($mainScoreId);
                    $updateposition->position = $positiongotten + 1;
                    $updateposition->save();
                }

                //change status of result ready model 
                $resultReady = ResultReadyModel::find($request->notif_id);
                $resultReady->status = 1;
                $resultReady->save();

                if ($term == "3") {

                    for ($i = 0; $i < count($studentregnumberarray); $i++) {

                        $fetchAllStudentAverageMarkAndProcess = ResultAverage::where(['regno' => $studentregnumberarray[$i], 'session' => $schoolsession, 'section_id' => $section, 'classid' => $classid])->sum('average');

                        $promomarks = $fetchAllStudentAverageMarkAndProcess / 2;

                        $addtopromoaverageTable = PromotionAverage_sec::updateOrCreate(
                            ['schoolid' => Auth::user()->schoolid, 'regno' => $studentregnumberarray[$i], 'session' => $schoolsession],
                            ['schoolid' => Auth::user()->schoolid, 'regno' => $studentregnumberarray[$i], 'session' => $schoolsession, 'promomarks' => $promomarks]
                        );
                    }
                }



                return "success";
            } catch (\Throwable $th) {
                //throw $th;

                return $th;
            }
        });
    }

    public function deleteGeneratedResult(Request $request)
    {

        $classid = $request->classid;
        $section = $request->section_id;
        $schooldata = Addpost::where('id', Auth::user()->schoolid)->first();
        $term = $schooldata->term;
        $schoolsession = $schooldata->schoolsession;

        //get all students in the class
        $getAllStudent = Addstudent_sec::where(['classid' => $classid, 'studentsection' => $section])->get();

        DB::beginTransaction();

        try {

            for ($i = 0; $i < count($getAllStudent); $i++) {

                DB::table('student_averages')->where(["regNo" => $getAllStudent[$i]->id, "session" => $schoolsession, "term" => $term])->delete();
            }

            DB::table('class_averages')->where([
                'session' => $schoolsession,
                'term' => $term,
                'classid' => $classid,
                'sectionId' => $section
            ])->delete();

            //change status of result ready model 
            $resultReady = ResultReadyModel::find($request->notif_id);
            $resultReady->status = 0;
            $resultReady->updated_at = Carbon::now()->toDateTimeString();
            $resultReady->save();

            DB::commit();
            // all good
            return 'success';
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }
    }
}
