<?php

namespace App\Http\Controllers;

use App\Addpost;
use App\Addsection_sec;
use App\Addstudent_sec;
use App\Addsubject_sec;
use App\AssesmentModel;
use App\AssessmentTableTotal;
use App\Classlist_sec;
use App\CLassSubjects;
use App\ElectiveAdd;
use App\Models\ClassAverage;
use App\Models\HeadOfchoolComment;
use App\Models\StudentAverage;
use App\MotoList;
use App\RecordMarks;
use App\SubAssesmentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResultGenerationController extends Controller
{
    public function generateSingleResult(Request $request)
    {

        $validatedData = $request->validate([
            'classid' => 'required',
            'term' => 'required',
            'student_reg_no' => 'required',
            'session' => 'required',
        ]);
        // return $request;

        $classid = $request->input('classid');
        $term = $request->input('term');
        $regNo = $request->input('student_reg_no');
        $schoolsession = $request->input('session');
        $section = $request->input('section');

        $addschool = Addpost::find(Auth::user()->schoolid);
        $getClass = Classlist_sec::find($classid);
        

        $studentData = Addstudent_sec::join('users', 'users.id','=','addstudent_secs.usernamesystem')
                    ->select('addstudent_secs.*', 'users.firstname', 'users.middlename', 'users.lastname')
                    ->where(['addstudent_secs.id'=>$regNo])->first();

        $getSection = Addsection_sec::find($section);

        $nextTermBegins = '';
        $termName='';
        if ($addschool->term == 1) {
            $nextTermBegins = '<i style="font-style: normal; font-weight: bold;">' . $addschool->secondtermbegins . '</i>';
            $termName = 'First';
        } elseif ($addschool->term == 2) {
            $nextTermBegins = '<i style="font-style: normal; font-weight: bold;">' . $addschool->thirdtermbegins . '</i>';
            $termName = 'Second';
        } elseif ($addschool->term == 3) {
            $nextTermBegins = '<i style="font-style: normal; font-weight: bold;">' . $addschool->firsttermstarts . '</i>';
            $termName = 'Third';
        } else {
            $nextTermBegins = '<i style="font-style: normal; font-weight: bold;">NAN</i>';
        }

        $nextTermEnds = '';
        if ($addschool->term == 1) {
            $nextTermEnds = '<i style="font-style: normal; font-weight: bold;">' . $addschool->secondtermends . '</i>';
        } elseif ($addschool->term == 2) {
            $nextTermEnds = '<i style="font-style: normal; font-weight: bold;">' . $addschool->thirdtermends . '</i>';
        } elseif ($addschool->term == 3) {
            $nextTermEnds = '<i style="font-style: normal; font-weight: bold;">' . $addschool->firsttermends . '</i>';
        } else {
            $nextTermEnds = '<i style="font-style: normal; font-weight: bold;">NAN</i>';
        }



        $motolistbeha = MotoList::leftjoin('add_moto_secs', 'add_moto_secs.moto_id','=','moto_lists.id')
        ->select("moto_lists.*", 'add_moto_secs.moto_score')
        ->where(['moto_lists.schoolid' => Auth::user()->schoolid, 'moto_lists.category' => 'behaviour', 'add_moto_secs.student_id'=>$regNo, 'add_moto_secs.session'=>$schoolsession, 'add_moto_secs.term'=>$term])->get();

        $motolistSkill = MotoList::leftjoin('add_moto_secs', 'add_moto_secs.moto_id','=','moto_lists.id')
        ->select("moto_lists.*", 'add_moto_secs.moto_score')
        ->where(['moto_lists.schoolid' => Auth::user()->schoolid, 'moto_lists.category' => 'skills', 'add_moto_secs.student_id'=>$regNo, 'add_moto_secs.session'=>$schoolsession, 'add_moto_secs.term'=>$term])->get();

        $motoBe = array();
        // return $this->getSubjectScores($term, $studentData->id, $schoolsession, $classid, $studentData->studentsection);

        foreach ($motolistbeha as $key => $value) {
            $motob = '
                <tr>
                    <td style="font-size: 14px;">'.$value->name.'</td>
                    <td style="font-size: 14px;">'.$value->moto_score.'</td>
                </tr>
            ';

            array_push($motoBe, $motob);
        }

        $motoSkill = array();

        foreach ($motolistSkill as $key => $value) {
            $motob = '
                <tr>
                    <td style="font-size: 14px;">'.$value->name.'</td>
                    <td style="font-size: 14px;">'.$value->moto_score.'</td>
                </tr>
            ';

            array_push($motoSkill, $motob);
        }

        $assessment = AssesmentModel::where('schoolid', Auth::user()->schoolid)->orderBy('order', 'DESC')->get();


        $assessmentHeadCompiled = array();
        for ($i=0; $i < count($assessment); $i++) { 
            $assementHead = '<th colspan='.$this->getSubAssessmentCount($assessment[$i]->id).'>'.$assessment[$i]->name.'</th>';
            array_push($assessmentHeadCompiled, $assementHead);
        }

        
        $formTeacherComment = $addschool->getStudentComment($regNo, $classid, $term, $schoolsession);

            $commentMain = '';
            if($formTeacherComment != null){
                $commentMain = $formTeacherComment->comments;
            }else{
                $commentMain = "Nill";
            }

            // return $this->getStudentGrandTotal($term, $classid, $section, $regNo, $schoolsession);

        $printPdf = 
        '<style type="text/css" media="screen">
        .outer {margin:-10 auto}
        .outer > * {
          display:inline-block;
          vertical-align:middle;
        }
        .one {width:29%;}
        .two {width:70%;}

        .studentDetails {margin:0 auto}
        .studentDetails > * {
          display:inline-block;
          vertical-align:middle;
        }

        .studentDetailsone {width:49.5%;}
        .studentDetailstwo {width:49.5%;}

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .remark > * {
            display:inline-block;
            vertical-align:middle;
        }

        .page-break {
            page-break-after: always;
        }

        .fontSizeSubject {
            font-size: 14px;
        }
        
        </style>
        <div class="page-break">
        <div class="outer">
        <div class="one">
          <center><img src='.$addschool->schoolLogo.' width="100px" height="100px"></center>
        </div>
        <div class="two">
            <center><p style="margin: 0; font-size: 30px;">'.$addschool->schoolname.'</p></center>
            <center><p style="margin: 0;">'.$addschool->schooladdress.', '.$addschool->schooladdress.'</p></center>
            <center><p style="margin: 0;">Termly Report Sheet</p></center>
        </div>
        </div>
        <br>
        <div class="studentDetails">
            <div class="studentDetailsone">
                <table style="width: 100%;">
                    <tr>
                        <td>Name of Student:</td>
                        <td>'.$studentData->firstname." ".$studentData->middlename." ".$studentData->lastname.'</td>
                    </tr>
                    <tr>
                        <td>Class:</td>
                        <td>'.$getClass->classname.$getSection->sectionname.'</td>
                    </tr>
                    <tr>
                        <td>Next term resumes:</td>
                        <td>'.$nextTermBegins.'</td>
                    </tr>
                    <tr>
                        <td>Sex</td>
                        <td>'.$studentData->gender.'</td>
                    </tr>
                </table>
            </div>
            <div class="studentDetailstwo" style="">
                <table style="width: 100%;">
                    <tr>
                        <td>Term:</td>
                        <td>'.$termName.'</td>
                    </tr>
                    <tr>
                        <td>Admission No:</td>
                        <td>'.$studentData->admission_no.'</td>
                    </tr>
                    <tr>
                        <td>No in Class:</td>
                        <td>'.count($getSection->getClassCount($classid, $schoolsession, $getSection->id)).'</td>
                    </tr>
                    <tr>
                        <td>Session:</td>
                        <td>'.$schoolsession.'</td>
                    </tr>
                </table>
            </div>
        </div>
        <p style="text-align: center;">ACADEMIC RECORDS</p>
        <div>
            <table style="width: 100%;">
                <tr>
                    <th>Subjects</th>
                    '
                    .implode(" ",$assessmentHeadCompiled).
                    '
                    <th>Total</th>
                    <th>Average</th>
                    <th>Grade</th>
                    <th>Pos</th>
                </tr>
                <tr>
                    <th></th>
                    '.implode(" ",$this->getSubAssessment()).' 
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    '.implode(" ",$this->getSubjectScores($term, $studentData->id, $schoolsession, $classid, $section)).'
                </tr>
                
            </table>
        </div>
        <br>
        <div style="width: 100%;">
            <i style="font-style:normal; padding: 8px;">Grand Total: '.$this->getStudentGrandTotal($term, $classid, $section, $regNo, $schoolsession).'</i>
            <i style="font-style:normal; padding: 8px;">Student/Pupil Average: '.round($this->getStudentAverge($term, $classid, $studentData->id, $schoolsession, 2)).'</i>
            <i style="font-style:normal; padding: 8px;">Class Average: '.round($this->getClassAverge($term, $classid, $schoolsession, $section, 2)).'</i>
            <i style="font-style:normal; padding: 8px;">Position: Nill</i>
        </div>
        <br>
        <p style="text-align: center; margin-top: -10px">RATINGS</p>
        <div class="studentDetails" style="margin: -2px">
            <div class="studentDetailsone">
                <div style="width: 95%; margin: 3px auto;">
                    <i style="font-size: 13px; font-style: normal;">Excellent = <b>5</b>,</i>
                    <i style="font-size: 13px; font-style: normal;">Very good = <b>4</b>,</i>
                    <i style="font-size: 13px; font-style: normal;">Good = <b>3</b>,</i>
                    <i style="font-size: 13px; font-style: normal;">Average = <b>2</b>,</i>
                    <i style="font-size: 13px; font-style: normal;">Fair = <b>1</b></i>
                </div>
                <table style="width: 100%;">
                    <tr>
                        <th style="font-size: 14px;">BEHAVIOUR AND ACTIVITIES</th>
                        <th style="font-size: 14px;">Marks(1-5)</th>
                    </tr>
                    
                    '.implode(" ",$motoBe).'
                </table>
            </div>
            <div class="studentDetailstwo">
                <table style="width: 100%;">
                    <tr>
                        <th style="font-size: 14px;">SKILLS</th>
                        <th style="font-size: 14px;">Marks(1-5)</th>
                    </tr>
                    '.implode(" ",$motoSkill). '
                </table>
            </div>
        </div>
        <br>
        <div style="width: 100%; margin-bottom: 5px; margin-top: -11px;">
            <p style="padding: 0px; margin: 0;">FORM TEACHER\'S REMARK: '.$commentMain.'</p>
            <div style="height: 1px; width: 100%; background-color: black;"></div>
        </div>
        <div style="width: 100%; margin-bottom: 10px;">
            <p style="padding: 0px; margin: 0;">HEAD OF SCHOOL\'S COMMENT: '.$this->getHeadOfSchoolComment($this->getStudentAverge($term, $studentData->id, $schoolsession, $classid, $section)).'</p>
            <div style="height: 1px; width: 100%; background-color: black;"></div>
        </div>
        <div style="width: 100%; margin-bottom: 8px;">
            <p style="padding: 0px; margin: 0;">HEAD OF SCHOOL\'S SIGNATURE: <img src="'.$addschool->schoolprincipalsignature.'" height="50px"></p>
            <div style="height: 1px; width: 100%; background-color: black;"></div>
        </div>
        <div class="remark" style="width: 100%; margin-bottom: 10px;">
            <div style="width: 49.5%;">
                <p style="padding: 0px; margin: 0;">NEXT TERM BEGINS: '.$nextTermBegins.'</p>
                <div style="height: 1px; width: 100%; background-color: black;"></div>
            </div>
            <div style="width: 49.5%; margin-bottom: -10px;">
                <p style="padding: 0px; margin: 0;">NEXT TERM ENDS: '.$nextTermEnds.'</p>
                <div style="height: 1px; width: 100%; background-color: black;"></div>
            </div>
        </div>
        </div>';














        // implode(" ",$printOutArray);

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($printPdf)->setPaper('a4', 'portrait');
        return $pdf->stream();


        
    }

    public function generateMultipleResult(Request $request)
    {



        
    }

    public function getSubAssessmentCount($id)
    {
        $subAssessment = SubAssesmentModel::where('catid', $id)->get();
        return count($subAssessment);
    }

    public function getSubAssessment()
    {
        $assessment = AssesmentModel::where('schoolid', Auth::user()->schoolid)->orderBy('order', 'DESC')->get();
        $subAssessment = array();
        for ($i=0; $i < count($assessment); $i++) { 
            $subAss = SubAssesmentModel::where('catid', $assessment[$i]->id)->get();
            for ($k=0; $k < count($subAss); $k++) { 
                $subValue = '<th>'.$subAss[$k]->maxmarks.'</th>';
                array_push($subAssessment, $subValue);
            }
        }
        return $subAssessment;
    }

    public function getSubjectScores($term, $regNo, $session, $classid, $studentsection)
    {
        // $resultsSubject = ResultSubjectsModel::where(['term'=>$term, 'studentregno'=>$regNo, 'session'=>$session])->get();

        //get student subjects plus electives
        $classSubjects = CLassSubjects::where(['classid'=>$classid, 'sectionid'=>$studentsection])->pluck('subjectid')->toArray();
        $elective = ElectiveAdd::where(['classid'=>$classid, 'regno'=>$regNo, 'sectionid'=>$studentsection])->pluck('subjectid')->toArray();

        $subjectIdArray = array_merge($classSubjects, $elective);

        $resultList = array();
        for ($i=0; $i < count($subjectIdArray); $i++) { 
            

            $resultView = 
            '<tr><td>'.$this->getSubjectName($subjectIdArray[$i])->subjectname.'</td>
            '.
            implode(" ",$this->subAssessmentRow($subjectIdArray[$i], $term, $regNo, $session, $classid))
            .'
            <td><center>'.round($this->getSubjectAverage($subjectIdArray[$i], $term, $classid, $studentsection, $regNo, $session )->totals, 2).'</center></td>
            <td><center>'.round($this->getAverage($subjectIdArray[$i], $term, $classid, $studentsection, $session), 2).'</center></td>
            <td><center>'.$this->getSubjectAverage($subjectIdArray[$i], $term, $classid, $studentsection, $regNo, $session )->grade.'</center></td>
            <td><center>'.$this->getSubjectAverage($subjectIdArray[$i], $term, $classid, $studentsection, $regNo, $session )->position.'</center></td></tr>';

            array_push($resultList, $resultView);

        }
        return $resultList;
    }

    public function getSubjectName($subjectId)
    {
        return Addsubject_sec::find($subjectId);
    }

    public function subAssessmentRow($subjectId, $term, $regNo, $session, $classid)
    {
        
        $assessment = AssesmentModel::where('schoolid', Auth::user()->schoolid)->orderBy('order', 'DESC')->get();
        $subAssessment = array();
        for ($i=0; $i < count($assessment); $i++) { 
            $subAss = SubAssesmentModel::where('catid', $assessment[$i]->id)->get();
            for ($k=0; $k < count($subAss); $k++) { 
                array_push($subAssessment, $subAss[$k]->id);
            }
        }
        
        $subAssessmentScore = array();
        for ($k=0; $k < count($subAssessment); $k++) { 
            $scores = RecordMarks::where(['subjectid'=>$subjectId, 'subassessment_id'=>$subAssessment[$k], 'term'=>$term, 'student_id'=>$regNo, 'session'=>$session, 'class_id'=>$classid])->get();

            for ($i=0; $i < count($scores); $i++) { 

                $value = $scores == NULL ? 0:$scores[$i]->scrores;
                $subAssScore = '<td><center>'.$value.'</center></td>';

                array_push($subAssessmentScore, $subAssScore);
            }

        }
        return $subAssessmentScore;
        
    }

    public function getStudentGrandTotal($term, $classId, $studentSection, $regNo, $session)
    {

        $getGrandTotals = AssessmentTableTotal::where(['regno'=>$regNo, 'classid'=>$classId, 'sectionid'=>$studentSection, 'term'=>$term, 'session'=>$session])->sum('totals');

        return $getGrandTotals;
        
    }

    public function getSubjectAverage($subjectId, $term, $classId, $studentSection, $regNo, $session)
    {
        $subjectAverageForStudent = DB::table('addstudent_secs')
        ->join('users', 'users.id', '=', 'addstudent_secs.usernamesystem')
        ->leftJoin('assessment_table_totals', function ($join) use ($subjectId, $term) {
            $join->on('assessment_table_totals.regno', '=', 'addstudent_secs.id');
            $join->where(['assessment_table_totals.subjectid' => $subjectId, 'assessment_table_totals.term' => $term]);
        })
        ->select('addstudent_secs.*', 'users.firstname', 'users.middlename', 'users.lastname', 'assessment_table_totals.totals', 'assessment_table_totals.grade', 'assessment_table_totals.id as markid', 'assessment_table_totals.position')
        ->where(['addstudent_secs.classid' => $classId, 'addstudent_secs.schoolsession' => $session, 'addstudent_secs.studentsection' => $studentSection, 'addstudent_secs.id'=>$regNo])->orderBy('assessment_table_totals.position', 'ASC')->first();

        return $subjectAverageForStudent;
    }

    public function getAverage($subjectId, $term, $classId, $studentSection, $session) //subject average for each subject for entire class
    {
        $subjectAverage = DB::table('addstudent_secs')
        ->join('users', 'users.id', '=', 'addstudent_secs.usernamesystem')
        ->leftJoin('assessment_table_totals', function ($join) use ($subjectId, $term) {
            $join->on('assessment_table_totals.regno', '=', 'addstudent_secs.id');
            $join->where(['assessment_table_totals.subjectid' => $subjectId, 'assessment_table_totals.term' => $term]);
        })
        ->select('addstudent_secs.*', 'users.firstname', 'users.middlename', 'users.lastname', 'assessment_table_totals.totals', 'assessment_table_totals.grade', 'assessment_table_totals.id as markid', 'assessment_table_totals.position')
        ->where(['addstudent_secs.classid' => $classId, 'addstudent_secs.schoolsession' => $session, 'addstudent_secs.studentsection' => $studentSection])->orderBy('assessment_table_totals.position', 'ASC')->avg('totals');

        return $subjectAverage;
    }

    public function getStudentAverge($term, $classId, $regNo, $session)
    {
        $getStudentAverge = StudentAverage::where(['regNo'=>$regNo, 'classid'=>$classId, 'term'=>$term, 'session'=>$session])->first();
        if($getStudentAverge == null){
            return 0;
        }else{
            return $getStudentAverge->average;
        }
    }

    public function getClassAverge($term, $classId, $session, $sectionId)
    {
        $getStudentAverge = ClassAverage::where(['classid'=>$classId, 'term'=>$term, 'session'=>$session, 'sectionId'=>$sectionId])->first();
        if($getStudentAverge == null){
            return 0;
        }else{
            return $getStudentAverge->average;
        }
    }

    public function getHeadOfSchoolComment($average)
    {
        $comments = HeadOfchoolComment::all();
        $selectedComment = 'Nill';
        for ($i=0; $i < count($comments); $i++) { 
            
            if ($average >= (int)$comments[$i]->marksTo && $average <= (int)$comments[$i]->marksFrom ) {
                $selectedComment = $comments[$i]->comment;
            }

        }

        return $selectedComment;
    }
}
