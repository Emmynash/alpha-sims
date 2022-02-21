<?php

namespace App\Repository\Result;

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
use App\AssessmentResultModel;
use App\AssessmentScoreResultModel;
use App\AssessmentTableTotal;
use App\CLassSubjects;
use App\ComputedAverages;
use App\ElectiveAdd;
use App\RecordMarks;
use App\ResultReadyModel;
use App\ResultSubjectsModel;
use App\SubAssesmentModel;
use App\TeacherSubjects;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ResultAverageProcess{

    public function processResultAverage(Request $request){
        
            $classid = $request->classid;
            $section = $request->section_id;
            $schooldata = Addpost::where('id', Auth::user()->schoolid)->first();
            $term = $schooldata->term;
            $schoolsession = $schooldata->schoolsession;

            DB::beginTransaction();

            try {
                
                    //get all students in the class
                    $getAllStudent = Addstudent_sec::where(['classid'=>$classid, 'studentsection'=>$section])->get();

                    $testarray = array();

                    if ($getAllStudent->count() > 0) {

                        for ($i=0; $i < $getAllStudent->count(); $i++) { 
                            
                            //get subjects
                           $classSubjects = CLassSubjects::join('addsubject_secs', 'addsubject_secs.id','=','c_lass_subjects.subjectid')->where(['c_lass_subjects.classid'=>$classid, 'c_lass_subjects.sectionid'=>$section])->select('c_lass_subjects.*', 'addsubject_secs.subjectname')->get();

                            

                            for ($j=0; $j < $classSubjects->count(); $j++) { 

                                

                                if($classSubjects[$j]->subjecttype == 1){

                                    $elective = ElectiveAdd::where(['subjectid'=>$classSubjects[$j]->subjectid, 'regno'=>$getAllStudent[$i]->id, 'classid'=>$classid])->get();

                                    if($elective->count() > 0){

                                        $createSubjectData = ResultSubjectsModel::updateOrCreate([
                                            'term'=>$term,
                                            'studentregno'=>$getAllStudent[$i]->id,
                                            'session'=>$schoolsession
                                        ],
                                        [
                                            'subjectname'=> $classSubjects[$j]->subjectname,
                                            'term'=>$term,
                                            'studentregno'=>$getAllStudent[$i]->id,
                                            'session'=>$schoolsession
                                        ]);
                    
                                        $getSubCategory = SubAssesmentModel::join('assesment_models', 'assesment_models.id','=','sub_assesment_models.catid')->select('sub_assesment_models.*', 'assesment_models.name')->where('sub_assesment_models.schoolid', Auth::user()->schoolid)->get();
                    
                                        for ($k=0; $k < $getSubCategory->count(); $k++) { 
                                            $getSubjectTotalMark = AssessmentTableTotal::where(['regno'=>$getAllStudent[$i]->id, 'subjectid'=>$classSubjects[$j]->subjectid, 'term'=>$term, 'session'=>$schoolsession, 'classid'=>$classid])->first();
                                            $addAssessment = AssessmentResultModel::updateOrcreate([
                                                'term'=>$term,
                                                'regno'=>$getAllStudent[$i]->id,
                                                'session'=>$schoolsession,
                                                'space_id'=>$createSubjectData->id
                                            ],
                                            [
                                                'assessmentcatname'=>$getSubCategory[$k]->name,
                                                'assessmentcatnamesub'=>$getSubCategory[$k]->subname,
                                                'term'=>$term,
                                                'regno'=>$getAllStudent[$i]->id,
                                                'session'=>$schoolsession,
                                                'total'=>$getSubjectTotalMark == NULL ? '0':$getSubjectTotalMark->totals,
                                                'space_id'=>$createSubjectData->id
                                            ]);
                    
                                            $getScore = RecordMarks::where(['subassessment_id'=>$getSubCategory[$k]->id, 'term'=>$term, 'student_id'=>$getAllStudent[$i]->id, 'session'=>$schoolsession])->first();
                    
                                            if($getScore != null){
                    
                                                $assessmentscoreresult = AssessmentScoreResultModel::updateOrcreate(
                                                    [
                                                        'assessment_id'=>$addAssessment->id,
                                                    ],
                                                    [
                                                    'assessment_id'=>$addAssessment->id,
                                                    'score'=>$getScore->scrores
                                                ]);
                                            }
                                        }

                                    }

                                }else{

                                
                                    try {
                                        $createSubjectData = ResultSubjectsModel::updateOrCreate(
                                                [
                                                'term'=>$term,
                                                'studentregno'=>$getAllStudent[$i]->id,
                                                'session'=>$schoolsession,
                                                'subjectname'=> $classSubjects[$j]->subjectname,
                                                'subjectid'=>$classSubjects[$j]->id
                                                ],[
                                                'subjectname'=> $classSubjects[$j]->subjectname,
                                                'term'=>$term,
                                                'studentregno'=>$getAllStudent[$i]->id,
                                                'session'=>$schoolsession,
                                                'subjectid'=>$classSubjects[$j]->id
                                            ]
                                        );
                                        
                                        
                                    } catch (\Throwable $th) {
                                        //throw $th;
                                        return $th;
                                    }
                
                                    $getSubCategory = SubAssesmentModel::join('assesment_models', 'assesment_models.id','=','sub_assesment_models.catid')->select('sub_assesment_models.*', 'assesment_models.name')->where('sub_assesment_models.schoolid', Auth::user()->schoolid)->get();
                
                                    for ($k=0; $k < $getSubCategory->count(); $k++) { 
                                        $getSubjectTotalMark = AssessmentTableTotal::where(['regno'=>$getAllStudent[$i]->id, 'subjectid'=>$classSubjects[$j]->subjectid, 'term'=>$term, 'session'=>$schoolsession, 'classid'=>$classid])->first();
                                        $getSubjectAverage = AssessmentTableTotal::where(['subjectid'=>$classSubjects[$j]->subjectid, 'term'=>$term, 'session'=>$schoolsession, 'classid'=>$classid])->sum('totals');
                                        $getSubjectStudentCount = AssessmentTableTotal::where(['subjectid'=>$classSubjects[$j]->subjectid, 'term'=>$term, 'session'=>$schoolsession, 'classid'=>$classid])->get();
                                            $addAssessment = AssessmentResultModel::updateOrcreate([
                                                'assessmentcatname'=>$getSubCategory[$k]->name,
                                                'assessmentcatnamesub'=>$getSubCategory[$k]->subname,
                                                'term'=>$term,
                                                'regno'=>$getAllStudent[$i]->id,
                                                'session'=>$schoolsession,
                                                'space_id'=>$createSubjectData->id
                                            ],[
                                                'assessmentcatname'=>$getSubCategory[$k]->name,
                                                'assessmentcatnamesub'=>$getSubCategory[$k]->subname,
                                                'term'=>$term,
                                                'regno'=>$getAllStudent[$i]->id,
                                                'session'=>$schoolsession,
                                                'total'=>$getSubjectTotalMark == NULL ? '0':$getSubjectTotalMark->totals,
                                                'grade'=>$getSubjectTotalMark == NULL ? 'N.A':$getSubjectTotalMark->grade,
                                                'average'=>$getSubjectAverage/$getSubjectStudentCount->count(),
                                                'space_id'=>$createSubjectData->id
                                            ]);
                
                                        $getScore = RecordMarks::where(['subassessment_id'=>$getSubCategory[$k]->id, 'term'=>$term, 'student_id'=>$getAllStudent[$i]->id, 'session'=>$schoolsession])->first();
                
                                        if($getScore != null){
                
                                            $assessmentscoreresult = AssessmentScoreResultModel::updateOrcreate([
                                                'assessment_id'=>$addAssessment->id,
                                            ],[
                                                'assessment_id'=>$addAssessment->id,
                                                'score'=>$getScore->scrores
                                            ]);
                                        }
                                    }



                                }

                            }

                            //process result averages
                            $assessmentTableTotalsSum = AssessmentTableTotal::where(['regno'=>$getAllStudent[$i]->id, 'term'=>$term, 'session'=>$schoolsession, 'sectionid'=>$section])->sum('totals');
                            $assessmentTableTotals = AssessmentTableTotal::where(['regno'=>$getAllStudent[$i]->id, 'term'=>$term, 'session'=>$schoolsession, 'sectionid'=>$section])->get();

                            $createAverage = ComputedAverages::updateOrcreate([
                                'session'=>$schoolsession,
                                'regno'=>$getAllStudent[$i]->id,
                                'term'=>$term
                            ],[
                                'examstotal'=>$assessmentTableTotalsSum,
                                'studentaverage'=>$assessmentTableTotalsSum/count($assessmentTableTotals),
                                'session'=>$schoolsession,
                                'regno'=>$getAllStudent[$i]->id,
                                'term'=>$term
                            ]);

                        }

                    }

                DB::commit();
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return $e;
            }

            

            return $testarray;
       

    }

    public function processResultAveragesds(Request $request)
    {



        DB::transaction(function() use ($request) {
            $classid = $request->classid;
            $section = $request->section_id;
            $schooldata = Addpost::where('id', Auth::user()->schoolid)->first();
            $term = $schooldata->term;
            $schoolsession = $schooldata->schoolsession;
            
            try {



         


                $checkaverage = ResultAverage::where(['classid'=>$classid, 'term'=>$term, 'session'=>$schoolsession, 'section_id'=>$section])->get();
        
                if (count($checkaverage) > 0) {
        
                    for ($i=0; $i < count($checkaverage); $i++) { 
                        $deleteAverage = ResultAverage::find($checkaverage[$i]['id']);
                        $deleteAverage->delete();
                    }
        
                    $resultReady = ResultReadyModel::find($request->notif_id);
                    $resultReady->status = 0;
                    $resultReady->save();
        
                    return 'already';
                }
            
                $studentregnumberarray = Addstudent_sec::where(['classid'=>$classid, 'schoolsession'=>$schoolsession, 'studentsection'=>$section])->pluck('id')->toArray(); // get id/regno of students in class
            
                // return response()->json(['studentregnumberarray'=>$studentregnumberarray]);
            
                for ($i=0; $i < count($studentregnumberarray); $i++) { 
            
                    $singleregno = $studentregnumberarray[$i];

                    //get student subjects id

                    $studentsSubjects = CLassSubjects::where(['classid'=>$classid, 'sectionid'=>$section, 'schoolid'=>Auth::user()->schoolid, 'subjecttype'=>2])->pluck('subjectid')->toArray(); //get all student core subjects
                    $getStudentElective = ElectiveAdd::where(['regno'=>$singleregno, 'classid'=>$classid, 'sectionid'=>$section])->pluck('subjectid')->toArray(); // get all student's elective subjects
                    
                    $studentmarks = Addmark_sec::where(['classid'=>$classid, 'term'=>$term, 'regno'=>$singleregno, 'session'=>$schoolsession, 'section'=>$section])->pluck('totalmarks')->toArray();
            
                    $scoresarraysingle = array();
            
            
                    $coursesum = array_sum($studentmarks);
    
                    $allsubjectcount = count($studentsSubjects) + count($getStudentElective);
        
                    if ($coursesum > 0 && $allsubjectcount > 0) {
                        
        
                        $averagevalue = $coursesum/$allsubjectcount;
        
            
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
            
                    $processposition = ResultAverage::where(['classid'=>$classid, 'term'=>$term, 'session'=>$schoolsession, 'section_id'=>$section])->orderBy('average', 'desc')->get();
                    
                    $positiondeterminantarray = array();
            
                for ($i=0; $i < count($processposition); $i++) { 
                    $id = $processposition[$i]['average'];
                    array_push($positiondeterminantarray, $id);
                }
            
                for ($i=0; $i < count($processposition); $i++) { 
            
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
                    
                    for ($i=0; $i < count($studentregnumberarray); $i++) { 
            
                        $fetchAllStudentAverageMarkAndProcess = ResultAverage::where(['regno'=> $studentregnumberarray[$i], 'session'=>$schoolsession, 'section_id'=>$section, 'classid'=>$classid])->sum('average');
            
                        $promomarks = $fetchAllStudentAverageMarkAndProcess / 2;

                        $addtopromoaverageTable = PromotionAverage_sec::updateOrCreate(
                            ['schoolid'=>Auth::user()->schoolid, 'regno'=>$studentregnumberarray[$i], 'session'=>$schoolsession],
                            ['schoolid'=>Auth::user()->schoolid, 'regno'=>$studentregnumberarray[$i], 'session'=>$schoolsession, 'promomarks'=>$promomarks]
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
}


