<?php

namespace App\Repository\Result;

use App\Addgrades_sec;
use App\Addmark_sec;
use App\Addpost;
use App\Classlist_sec;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GetSubjectPosition{


    public function addResultMain(Request $request)
    {
        $checkifidexists = $request->input('markidstudent');
        $studentId = $request->input('studentregno');
        $examsmarks = $request->input('examsmarksentered');
        $ca1marks = $request->input('ca1marksentered');
        $ca2marks = $request->input('ca2marksentered');
        $ca3marks = $request->input('ca3marksentered');
        $attendancemarks = "NA";
        $selectedclassidMain = $request->input('classidmain');
        $subjectbyclassidMain = $request->input('subjectid');
        $schooltermMain = $request->input('currentterm');
        $studentshiftMain = "NA";
        $studentsectionMain = $request->input('studentsection');
        $sessionquery = $request->input('currentsessionform');

        


        if ($examsmarks < 0 && $ca1marks < 0 && $ca2marks < 0 && $ca3marks < 0) {
            $msg = "Failed";
            return response()->json(['empty' => $msg], 200);
        }

        $getClassDetails = Classlist_sec::find($selectedclassidMain);

        $schooldetails = Addpost::find(Auth::user()->schoolid);

        if ($schooldetails->schooltype == "Primary") {
            $studentgradeprocess = Addgrades_sec::where(['schoolid'=> Auth::user()->schoolid, 'type'=>0])->get();
        }else{
            $studentgradeprocess = Addgrades_sec::where(['schoolid'=> Auth::user()->schoolid, 'type'=>$getClassDetails->classtype])->get();
        }

        if (count($studentgradeprocess) < 5) {
            $msg = "grades";
            return response()->json(['msg' => $msg], 200);
        }

        $totalmarks = $examsmarks + $ca1marks + $ca2marks + $ca3marks;

        $schooldetails = Addpost::find(Auth::user()->schoolid);

        if ($schooldetails->schooltype == "Primary") {
            $studentgradeprocess = Addgrades_sec::where(['schoolid'=> Auth::user()->schoolid, 'type'=>0])->get();
        }else{
            $studentgradeprocess = Addgrades_sec::where(['schoolid'=> Auth::user()->schoolid, 'type'=>$getClassDetails->classtype])->get();
        }

        $gradeFInal = "";
        $point = "0";

        for ($i=0; $i < count($studentgradeprocess); $i++) {
            if (($totalmarks >= $studentgradeprocess[$i]['marksfrom'] && $totalmarks<= $studentgradeprocess[$i]['marksto']) || ($totalmarks >= $studentgradeprocess[$i]['marksto'] && $totalmarks<= $studentgradeprocess[$i]['marksfrom'])) {
                $gradeFInal = $studentgradeprocess[$i]['gpaname'];
                $point = $studentgradeprocess[$i]['point'] == "NA" ? "0":$studentgradeprocess[$i]['point'];
            }
        }

        Addmark_sec::updateOrCreate(
            ['regno'=>$studentId, 'schoolid'=>Auth::user()->schoolid, 'classid'=>$selectedclassidMain, 'term'=>$request->input('currentterm'), 'session'=>$sessionquery, 'subjectid' => $subjectbyclassidMain],
            ['regno' => $studentId,
            'schoolid' => Auth::user()->schoolid,
            'classid' => $selectedclassidMain,
            'subjectid' => $subjectbyclassidMain,
            'exams' => $examsmarks,
            'ca1' => $ca1marks,
            'ca2' => $ca2marks,
            'ca3' => $ca3marks,
            'totalmarks' => $totalmarks,
            'grades' => $gradeFInal,
            'term' => $schooltermMain,
            'session' => $sessionquery,
            'shift' => $studentshiftMain,
            'points' => $point,
            'section' => $studentsectionMain]
        );

        $this->getStudentPosition($request);

    }



    public function getStudentPosition(Request $request)
    {

        $selectedclassidMain = $request->input('classidmain');
        $subjectbyclassidMain = $request->input('subjectid');
        $studentsectionMain = $request->input('studentsection');
        $sessionquery = $request->input('currentsessionform');

        DB::beginTransaction();
            
        try {
            $getstudentposition = Addmark_sec::where(['schoolid'=>Auth::user()->schoolid, 'classid'=>$selectedclassidMain, 'session'=>$sessionquery, 'subjectid' => $subjectbyclassidMain, 'term'=>$request->input('currentterm'), 'section'=>$studentsectionMain])->orderBy('totalmarks', 'desc')->get();
            $subjectscrorearray = array();
            
            for ($i=0; $i < count($getstudentposition); $i++) { 
                $score = (int)$getstudentposition[$i]['totalmarks'];
                    array_push($subjectscrorearray, $score);
            }

            for ($i=0; $i < count($getstudentposition); $i++) { 

                $mainScore = (int)$getstudentposition[$i]['totalmarks'];
                $mainScoreId = $getstudentposition[$i]['id'];
                $positiongotten = array_search($mainScore, $subjectscrorearray);
                $newPosition = $positiongotten + 1;

                DB::table('addmark_secs')->where('id',$mainScoreId)->update(array(
                    'position'=>$newPosition
                ));

            }

            DB::commit();
            // all good
            return $subjectscrorearray;
            
        } catch (\Exception $e) {
            DB::rollback();

            return $e;
            // something went wrong
        }
        
    }

}