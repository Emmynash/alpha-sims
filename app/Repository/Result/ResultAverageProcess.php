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
use App\CLassSubjects;
use App\ElectiveAdd;
use App\ResultReadyModel;
use App\TeacherSubjects;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ResultAverageProcess{

    public function processResultAverage(Request $request)
    {



        DB::transaction(function() use ($request) {
            $classid = $request->classid;
            $section = $request->section_id;
            $schooldata = Addpost::where('id', Auth::user()->schoolid)->first();
            $term = $schooldata->term;
            $schoolsession = $schooldata->schoolsession;
            
            try {



                // DB::table('result_averages')->where(['classid'=>$classid, 'term'=>$term, 'session'=>$schoolsession, 'section_id'=>$section])->delete();


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
                
                if ($request->input('processterm') == "3") {
                    
                    for ($i=0; $i < count($studentregnumberarray); $i++) { 
            
                        $fetchAllStudentAverageMarkAndProcess = ResultAverage::where(['regno'=> $studentregnumberarray[$i], 'session'=>$schoolsession, 'section_id'=>$section])->sum('average');
            
                        $promomarks = $fetchAllStudentAverageMarkAndProcess / 3;
            
                        $addtopromoaverageTable = new PromotionAverage_sec();
                        $addtopromoaverageTable->schoolid = Auth::user()->schoolid;
                        $addtopromoaverageTable->regno = $studentregnumberarray[$i];
                        $addtopromoaverageTable->session = $schoolsession;
                        $addtopromoaverageTable->promomarks = $promomarks;
                        $addtopromoaverageTable->save();
                    
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


