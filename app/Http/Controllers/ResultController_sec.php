<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClassAverageMark;
use App\Classlist_sec;
use App\Addpost;
use App\Addsubject_sec;
use App\Addstudent_sec;
use App\Addmark_sec;
use App\Addmoto_sec;
use App\CLassSubjects;
use App\MotoList;
use App\ResultAverage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repository\Result\ProcessClassAverage;
use App\Repository\Result\ResultAverageProcess;
use App\ResultReadyModel;
use PDF;
use App;
use App\Addsection_sec;
use App\AssesmentModel;
use App\AssessmentResultModel;
use App\AssessmentScoreResultModel;
use App\Classlist;
use App\CommentsModel;
use App\ComputedAverages;
use App\ElectiveAdd;
use App\Models\HeadOfchoolComment;
use App\Models\ResultSetting;
use App\RecordMarks;
use App\ResultSubjectsModel;
use App\SubAssesmentModel;
use App\FormTeachers;
use App\User;
use Svg\Tag\Rect;

class ResultController_sec extends Controller
{
    public function index()
    {

        $classlist_sec = Classlist_sec::where('schoolid', Auth::user()->schoolid)->get();
        $studentdetails = Addstudent_sec::where('usernamesystem', Auth::user()->id)->first();
        $schooldetails = Addpost::find(Auth::user()->schoolid);
        return view('secondary.result_sec', compact('schooldetails', 'classlist_sec', 'studentdetails'));
    }

    public function viewResult(Request $request)
    {

        $validatedData = $request->validate([
            'selectedclassmarks' => 'required',
            'selectedtermmarks' => 'required',
            'studentRegnomarks' => 'required',
            'schoolsession' => 'required'
        ]);

        $studentclass = $request->input('selectedclassmarks');
        $term = $request->input('selectedtermmarks');
        $studentregno = $request->input('studentRegnomarks');
        $schoolsession = $request->input('schoolsession');

        $request->session()->put('studentclass', $studentclass);
        $request->session()->put('term', $term);
        $request->session()->put('studentregno', $studentregno);
        $request->session()->put('schoolsession', $schoolsession);

        $addpost = Addpost::where('id', Auth::user()->schoolid)->get();

        $allDetails = array(
            'addpost' => $addpost
        );

        return view('secondary.result_view_sec')->with('allDetails', $allDetails);
    }


    public function viewSingleResult(Request $request)
    {

        $validatedData = $request->validate([
            'classid' => 'required',
            'term' => 'required',
            'student_reg_no' => 'required',
            'session' => 'required',
        ]);




        try {
            $classid = $request->input('classid');
            $term = $request->input('term');
            $regNo = $request->input('student_reg_no');
            $schoolsession = $request->input('session');
            $section = $request->input('section');

            $checkclasstype = Classlist_sec::find($classid);

            $studentdetails = Addstudent_sec::find($regNo);

            $addschool = Addpost::find(Auth::user()->schoolid);

            $resultMain = ResultSubjectsModel::where(['result_subjects_models.term' => $term, 'result_subjects_models.studentregno' => $regNo, 'result_subjects_models.session' => $schoolsession])->get();

            $subCatAss = SubAssesmentModel::where('schoolid', Auth::user()->schoolid)->get();

            $assessment = AssesmentModel::where('schoolid', Auth::user()->schoolid)->orderBy('order', 'DESC')->get();

            $motolistbeha = MotoList::where(['schoolid' => Auth::user()->schoolid, 'category' => 'behaviour'])->get();

            $motolistskills = MotoList::where(['schoolid' => Auth::user()->schoolid, 'category' => 'skills'])->get();

            $studentClass = Classlist_sec::find($classid);

            $computedAverage = ComputedAverages::where(['session' => $schoolsession, 'regno' => $regNo, 'term' => $term])->first();

            $getStudentsArray = Addstudent_sec::where(['classid' => $classid])->pluck('id');

            $scoresGrandTotal = DB::table('computed_averages')
                                ->whereIn('regno', $getStudentsArray) 
                                ->sum('examstotal');


            $subAssessmentMarks = array();
            for ($i = 0; $i < count($assessment); $i++) {
                $subAss = SubAssesmentModel::where('catid', $assessment[$i]->id)->get();
                for ($k = 0; $k < count($subAss); $k++) {
                    $subValue = $subAss[$k]->maxmarks;
                    array_push($subAssessmentMarks, $subValue);
                }
            }

            $nextTermBegins = '';
            if ($addschool->term == 1) {
                $nextTermBegins = $addschool->secondtermbegins;
            } elseif ($addschool->term == 2) {
                $nextTermBegins = $addschool->thirdtermbegins;
            } elseif ($addschool->term == 3) {
                $nextTermBegins = $addschool->firsttermstarts;
            } else {
                $nextTermBegins = 'NAN';
            }

            $nextTermEnds = '';
            if ($addschool->term == 1) {
                $nextTermEnds = $addschool->secondtermends;
            } elseif ($addschool->term == 2) {
                $nextTermEnds = $addschool->thirdtermends;
            } elseif ($addschool->term == 3) {
                $nextTermEnds = $addschool->firsttermends;
            } else {
                $nextTermEnds = 'NAN';
            }


            return view('secondary.result.viewresult.singleprimary', compact('scoresGrandTotal','nextTermBegins', 'nextTermEnds', 'subAssessmentMarks', 'resultMain', 'subCatAss', 'assessment', 'motolistbeha', 'motolistskills', 'classid', 'regNo', 'schoolsession', 'studentdetails', 'term', 'addschool', 'schoolsession', 'studentClass', 'computedAverage'));

            //get subject list
            $getSubjectList = CLassSubjects::where(['classid' => $classid, 'sectionid' => $studentdetails->studentsection, 'subjecttype' => 2])->pluck('subjectid')->toArray();
            $getStudentElective = ElectiveAdd::where(['regno' => $regNo, 'classid' => $classid, 'sectionid' => $studentdetails->studentsection])->pluck('subjectid')->toArray(); // get all student's elective subjects


            $subject = array();

            $subjectSum  = array_merge($getSubjectList, $getStudentElective);


            for ($i = 0; $i < count($subjectSum); $i++) {

                $addmarksCheck = Addsubject_sec::find($subjectSum[$i]);

                // if (count($addmarksCheck) > 0) {

                //     if ((int)$addmarksCheck[0]->totalmarks > 0) {
                //         $getSingleSubject = Addsubject_sec::find($subjectSum[$i]);

                //     }
                // }
                array_push($subject, $addmarksCheck);
            }

            $subjects = collect($subject);

            $motolistbeha = MotoList::where(['schoolid' => Auth::user()->schoolid, 'category' => 'behaviour'])->get();

            $motolistskills = MotoList::where(['schoolid' => Auth::user()->schoolid, 'category' => 'skills'])->get();

            $resultAverage = ResultAverage::where(["regno" => $regNo, "schoolid" => Auth::user()->schoolid, "classid" => $classid, "term" => $term, "session" => $schoolsession])->first();


            $studentClass = Classlist_sec::find($classid);

            if ($addschool->schooltype == "Primary") {

                return view('secondary.result.viewresult.singleprimary', compact('studentdetails', 'addschool', 'schoolsession', 'term', 'subjects', 'motolistbeha', 'motolistskills', 'resultAverage', 'studentClass'));
            } else {



                if ($checkclasstype->classtype == 1) {

                    $assessments = AssesmentModel::where('schoolid', Auth::user()->schoolid)->get();

                    return view('secondary.result.viewresult.singlejunior', compact('studentdetails', 'addschool', 'schoolsession', 'term', 'subjects', 'motolistbeha', 'motolistskills', 'resultAverage', 'studentClass', 'assessments'));
                } else {
                    return view('secondary.result.viewresult.singleresult', compact('studentdetails', 'addschool', 'schoolsession', 'term', 'subjects', 'motolistbeha', 'motolistskills', 'resultAverage', 'studentClass'));
                }
            }
        } catch (\Throwable $th) {
            //throw $th;

            return $th;
        }
    }

    public function result_by_class()
    {
        $school = Addpost::find(Auth::user()->schoolid);
        $formTeacherClasses = FormTeachers::join('classlist_secs', 'classlist_secs.id', '=', 'form_teachers.class_id')
        ->join('addsection_secs', 'addsection_secs.id', '=', 'form_teachers.form_id')
        ->where('teacher_id', Auth::user()->id)
        ->select('addsection_secs.id as sectionId', 'classlist_secs.classname', 'addsection_secs.sectionname', 'classlist_secs.status', 'classlist_secs.index', 'classlist_secs.id', 'classlist_secs.classtype', 'classlist_secs.schoolid')->get();

        return view('secondary.result.resultbyclass', compact('school', 'formTeacherClasses'));
    }

    public function addResultSettings(Request $request)
    {
        $rules = [
            'name' => 'required',
            'fontSize' => 'required',
        ];
    
        $customMessages = [
            'required' => 'The :attribute field can not be blank.'
        ];

        $this->validate($request, $rules, $customMessages);

        try {

            $addResultSettings = ResultSetting::updateOrCreate(
                ['slug'=>str_replace(' ', '', $request->name), 'schoolId'=>Auth::user()->schoolid],
                ['fontSize'=>$request->fontSize."px", 'schoolId' => Auth::user()->schoolid, 'name'=>$request->name, 'slug'=>str_replace(' ', '', $request->name)]);

            // $addResultSettings = new ResultSetting();
            // $addResultSettings->name = $request->name;
            // $addResultSettings->fontSize = $request->fontSize."px";
            // $addResultSettings->schoolId = Auth::user()->schoolid;
            // $addResultSettings->save();

            return back()->with('success', 'Settings added successfully');
        } catch (\Throwable $th) {
            return $th;
            return back()->with('error', 'Process failed');
        }
        
    }

    public function view_by_class(Request $request)
    {
        $term = $request->term;
        $section = $request->section;
        $session = $request->session;

        $entirestudent = Addstudent_sec::where(['classid' => $request->classid, "studentsection" => $request->section, "schoolsession" => $request->session])->get();

        return view('secondary.result.viewentireclass', compact('entirestudent', 'term', 'section', 'session'));
    }

    public function generateResult()
    {
        $classlist = Classlist_sec::where('schoolid', Auth::user()->schoolid)->get();

        $schoolDetails = Addpost::find(Auth::user()->schoolid);

        $checkRecord = ResultAverage::where(['session' => $schoolDetails->schoolsession, 'term' => $schoolDetails->term, 'schoolid' => Auth::user()->schoolid])->pluck('classid')->toArray();

        // return view('secondary.adminside.result.generateresult', compact('classlist', 'checkRecord'));

        return view('secondary.adminside.result.generateresultreact');
    }

    public function generateResultMain(Request $request, ProcessClassAverage $processClassAverage, ResultAverageProcess $resultAverageProcess)
    {

        //--------------------------------------------------------------------------------
        //                                 process class average
        //--------------------------------------------------------------------------------

        // try {
            $resultAverage = $resultAverageProcess->processResultAverage($request);

            //    return $resultAverage;

            if ($resultAverage == "success") {


                return response()->json(['response' => $resultAverage], 200);

                // $process_class_average = $processClassAverage->processresult($request);

                // return response()->json(['response' => ''], 200);
            } else {
                return response()->json(['response' => $resultAverage], 500);
            }
        // } catch (\Throwable $th) {
        //     //throw $th;
        //     return response()->json(['response' => $th], 400);
        // }
    }

    public function deleteGeneratedResult(Request $request, ProcessClassAverage $processClassAverage, ResultAverageProcess $resultAverageProcess)
    {


        try {
            $resultAverage = $resultAverageProcess->deleteGeneratedResult($request);

            

            //    return $resultAverage;
            if ($resultAverage == "success") {


                return response()->json(['response' => $resultAverage], 200);

                // $process_class_average = $processClassAverage->processresult($request);

                // return response()->json(['response' => ''], 200);
            } else {
                return response()->json(['response' => $resultAverage], 500);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => $th], 400);
        }

    }

    public function get_result_ready_section()
    {
        try {

            $term = Addpost::find(Auth::user()->schoolid);

            $getReadyResults = ResultReadyModel::join('classlist_secs', 'classlist_secs.id', '=', 'result_ready_models.classid')
                ->join('addsection_secs', 'addsection_secs.id', '=', 'result_ready_models.sectionid')
                ->where(['result_ready_models.schoolid' => Auth::user()->schoolid, 'result_ready_models.term' => $term->term])
                ->select('result_ready_models.*', 'classlist_secs.classname', 'classlist_secs.id as classid', 'addsection_secs.sectionname', 'addsection_secs.id as sectionid')->get();

            return response()->json(['getReadyResults' => $getReadyResults]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['getReadyResults' => $th]);
        }
    }

    public function loadHtmlDoc(Request $request)
    {

        // $motolistbeha = MotoList::where(['schoolid' => Auth::user()->schoolid, 'category' => 'behaviour'])->get();

        // $motolistskills = MotoList::where(['schoolid' => Auth::user()->schoolid, 'category' => 'skills'])->get();

        $classid = $request->input('classid');
        $term = $request->input('term');
        $regNo = $request->input('student_reg_no');
        $schoolsession = $request->input('session');
        $section = $request->input('section');
        DB::beginTransaction();

        $addschool = Addpost::find(Auth::user()->schoolid);
        $getClass = Classlist_sec::find($classid);
        $getSection = Addsection_sec::find($section);

       
        $resultMain = ResultSubjectsModel::where(['result_subjects_models.term' => $term, 'result_subjects_models.studentregno' => $regNo, 'result_subjects_models.session' => $schoolsession])->get();

        $getClassGrandTotal = ComputedAverages::where(['session' => $schoolsession, 'term' => $term])->sum('regno');

        $getStudentsArray = Addstudent_sec::where(['classid'=>$classid, 'studentsection'=>$section])->pluck('id');

        $scoresGrandTotal = DB::table('computed_averages')
                    ->whereIn('regno', $getStudentsArray)
                    ->sum('examstotal');

        

        $getStudents = Addstudent_sec::join('users', 'users.id','=','addstudent_secs.usernamesystem')
                       ->select('addstudent_secs.*', 'users.firstname', 'users.middlename', 'users.lastname')
                       ->where(['classid'=>$classid, 'studentsection'=>$section])->get();

        $subCatAss = SubAssesmentModel::where('schoolid', Auth::user()->schoolid)->get();

        $assessment = AssesmentModel::where('schoolid', Auth::user()->schoolid)->orderBy('order', 'ASC')->get();
        $assessment = AssesmentModel::where('schoolid', Auth::user()->schoolid)->orderBy('order', 'DESC')->get();

        $nextTermBegins = '';
        if ($addschool->term == 1) {
            $nextTermBegins = '<i style="font-style: normal; font-weight: bold;">' . $addschool->secondtermbegins . '</i>';
        } elseif ($addschool->term == 2) {
            $nextTermBegins = '<i style="font-style: normal; font-weight: bold;">' . $addschool->thirdtermbegins . '</i>';
        } elseif ($addschool->term == 3) {
            $nextTermBegins = '<i style="font-style: normal; font-weight: bold;">' . $addschool->firsttermstarts . '</i>';
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

        $schoolTerm = '';
        if ($addschool->term == 1) {
            $schoolTerm = 'First';
        } elseif ($addschool->term == 2) {
            $schoolTerm = 'Second';
        } elseif ($addschool->term == 3) {
            $schoolTerm = 'Third';
        } else {
            $schoolTerm = '';
        }


        $assessmentHeadCompiled = array();
        for ($i=0; $i < count($assessment); $i++) { 
            $assementHead = '<th colspan='.$this->getSubAssessmentCount($assessment[$i]->id).'>'.$assessment[$i]->name.'</th>';
            array_push($assessmentHeadCompiled, $assementHead);
        }

        

        $printOutArray = array();

        for ($i=0; $i < count($getStudents); $i++) { 

            $resultsSubject = ResultSubjectsModel::where(['term'=>$term, 'studentregno'=>$getStudents[$i]->id, 'session'=>$schoolsession])->get();
            $classAverage = ($scoresGrandTotal /  count($getStudentsArray))*count($resultsSubject);

            $motolistbeha = MotoList::leftjoin('add_moto_secs', 'add_moto_secs.moto_id','=','moto_lists.id')
                            ->select("moto_lists.*", 'add_moto_secs.moto_score')
                            ->where(['moto_lists.schoolid' => Auth::user()->schoolid, 'moto_lists.category' => 'behaviour', 'add_moto_secs.student_id'=>$getStudents[$i]->id, 'add_moto_secs.session'=>$schoolsession, 'add_moto_secs.term'=>$term])->get();

            $motolistSkill = MotoList::leftjoin('add_moto_secs', 'add_moto_secs.moto_id','=','moto_lists.id')
                            ->select("moto_lists.*", 'add_moto_secs.moto_score')
                            ->where(['moto_lists.schoolid' => Auth::user()->schoolid, 'moto_lists.category' => 'skills', 'add_moto_secs.student_id'=>$getStudents[$i]->id, 'add_moto_secs.session'=>$schoolsession, 'add_moto_secs.term'=>$term])->get();

            $formTeacherComment = $addschool->getStudentComment($getStudents[$i]->id, $classid, $term, $schoolsession);

            $commentMain = '';
            if($formTeacherComment != null){
                $commentMain = $formTeacherComment->comments;
            }else{
                $commentMain = "Nill";
            }

        


        $motoBe = array();

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
                        <td>'.$getStudents[$i]->firstname." ".$getStudents[$i]->middlename." ".$getStudents[$i]->lastname.'</td>
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
                        <td>'.$getStudents[$i]->gender.'</td>
                    </tr>
                </table>
            </div>
            <div class="studentDetailstwo" style="">
                <table style="width: 100%;">
                    <tr>
                        <td>Term:</td>
                        <td>'.$schoolTerm.'</td>
                    </tr>
                    <tr>
                        <td>Admission No:</td>
                        <td>'.$getStudents[$i]->admission_no.'</td>
                    </tr>
                    <tr>
                        <td>No in Class:</td>
                        <td>'.count($getSection->getClassCount($classid, $schoolsession, $section)).'</td>
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
                </tr>
                '.implode(" ",$this->getSubjectScores($term, $getStudents[$i]->id, $schoolsession,$classid, $term, $section)).'
            </table>
        </div>
        <br>
        <div style="width: 100%;">
            <i style="font-style:normal; padding: 8px;">Grand Total: '.$this->getGrandTotal($term, $getStudents[$i]->id, $schoolsession).'</i>
            <i style="font-style:normal; padding: 8px;">Student/Pupil Average: '. round($this->getStudentAverage($term, $getStudents[$i]->id, $schoolsession, $classid, $section), 2).'</i>
            <i style="font-style:normal; padding: 8px;">Class Average: '.round(($scoresGrandTotal / (count($getStudentsArray) * $this->getSubjectCount($term, $getStudents[$i]->id, $schoolsession))), 2). '</i>
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
            <p style="padding: 0px; margin: 0;">FORM TEACHER\'S REMARK: '.$commentMain. '</p>
            <div style="height: 1px; width: 100%; background-color: black;"></div>
        </div>
        <div style="width: 100%; margin-bottom: 10px;">
            <p style="padding: 0px; margin: 0;">HEAD OF SCHOOL\'S COMMENT: ' . $this->getHeadOfSchoolComment($this->getStudentAverage($term, $getStudents[$i]->id, $schoolsession, $classid, $section)) . '</p>
            <div style="height: 1px; width: 100%; background-color: black;"></div>
        </div>
        <div style="width: 100%; margin-bottom: 8px;">
            <p style="padding: 0px; margin: 0;">HEAD OF SCHOOL\'S SIGNATURE: <img src='.$addschool->schoolprincipalsignature.' height="50px"></p>
            <div style="height: 1px; width: 100%; background-color: black;"></div>
        </div>
        <div class="remark" style="width: 100%; margin-bottom: 10px;">
            <div style="width: 49.5%;">
                <p style="padding: 0px; margin: 0;">NEXT TERM BEGINS: '.$nextTermBegins. '</p>
                <div style="height: 1px; width: 100%; background-color: black;"></div>
            </div>
            <div style="width: 49.5%; margin-bottom: -10px;">
                <p style="padding: 0px; margin: 0;">NEXT TERM ENDS: '.$nextTermEnds.'</p>
                <div style="height: 1px; width: 100%; background-color: black;"></div>
            </div>
        </div>
        </div>';

        array_push($printOutArray, $printPdf);
            
        }

        $printOutArray;

        implode(" ",$printOutArray);

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(implode(" ",$printOutArray))->setPaper('a4', 'portrait');
        return $pdf->stream();

        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadView('secondary.result.viewresult.resulttest', compact('motolistbeha', 'motolistskills', 'addschool'));
        // return $pdf->stream();

        // $pdfOptions = new Options();
        // $pdfOptions->set('defaultFont', 'Arial');

        // $dompdf = new Dompdf($pdfOptions);

        // // Retrieve the HTML generated in our twig file
        // $html = $this->loadHtml('secondary.adminside.result.generateresultreact', [
        //     'title' => "Welcome to our PDF Test"
        // ]);

        // $dompdf->loadHtml($html);

        // // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        // $dompdf->setPaper('A4', 'portrait');

        // // Render the HTML as PDF
        // $dompdf->render();

        // // Output the generated PDF to Browser (inline view)
        // $dompdf->stream("mypdf.pdf", [
        //     "Attachment" => false
        // ]);



    }

    public function printEntrireClassResult(Request $request)
    {

        // return $request;

        $classid = $request->input('classid');
        $term = $request->input('term');
        $regNo = $request->input('student_reg_no');
        $schoolsession = $request->input('session');
        $section = $request->input('section');

        return $this->loadHtmlDoc($request);

        $addschool = Addpost::find(Auth::user()->schoolid);

        $classtype = Classlist_sec::find($classid)->classtype;

        //get studentlist for same class and section
        $studentList = Addstudent_sec::where(['classid' => $request->classid, 'studentsection' => $request->section, 'schoolsession' => $request->session])->pluck('id')->toArray();

        // return $studentList;
        $studentInClass = Addstudent_sec::where(['classid' => $classid, 'studentsection' => $section])->get();

        $motolistbeha = MotoList::where(['schoolid' => Auth::user()->schoolid, 'category' => 'behaviour'])->get();

        $motolistskills = MotoList::where(['schoolid' => Auth::user()->schoolid, 'category' => 'skills'])->get();

        $resultAverage = ResultAverage::where(["regno" => $regNo, "schoolid" => Auth::user()->schoolid, "classid" => $classid, "term" => $term, "session" => $schoolsession])->first();

        if ($addschool->schooltype == "Primary") {
            return view('secondary.result.viewresult.resultlistpri', compact('studentInClass', 'motolistbeha', 'motolistskills', 'addschool', 'term', 'schoolsession', 'classid', 'section', 'classtype'));
        } else {

            if ($classtype == "1") {
                return view('secondary.result.viewresult.resulttest', compact('studentInClass', 'motolistbeha', 'motolistskills', 'addschool', 'term', 'schoolsession', 'classid', 'section', 'classtype'));
            } else {
                return view('secondary.result.viewresult.resultseniorsec', compact('studentInClass', 'motolistbeha', 'motolistskills', 'addschool', 'term', 'schoolsession', 'classid', 'section', 'classtype'));
            }
        }
    }

        public function getSubjectCount($term, $regNo, $session)
    {
        $resultsSubject = ResultSubjectsModel::where(['term'=>$term, 'studentregno'=>$regNo, 'session'=>$session])->get();
        return count($resultsSubject);
    }

    public function getSubjectScores($term, $regNo, $session, $classid, $studentsection)
    {
        $resultsSubject = ResultSubjectsModel::where(['term'=>$term, 'studentregno'=>$regNo, 'session'=>$session])->get();
        $resultList = array();
        for ($i=0; $i < count($resultsSubject); $i++) { 
            

            $resultView = 
            '<tr><td>'.$resultsSubject[$i]->subjectname.'</td>
            '.
            implode(" ",$this->subAssessmentRow($resultsSubject[$i]->id))
            .'
            <td><center>'.round($resultsSubject[$i]->getAssessmentsTotal($resultsSubject[$i]->id)->total, 2).'</center></td>
            <td><center>'.round($resultsSubject[$i]->getAssessmentsTotal($resultsSubject[$i]->id, 2)->average).'</center></td>
            <td><center>'.$resultsSubject[$i]->getAssessmentsTotal($resultsSubject[$i]->id)->grade.'</center></td>
            <td><center>'.$resultsSubject[$i]->getStudentRecordBulk($resultsSubject[$i]->subjectid, $session, $regNo, $classid, $term)->position.'</center></td></tr>';
            array_push($resultList, $resultView);
        }
        return $resultList;
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

    public function getSubAssessmentCount($id)
    {
        $subAssessment = SubAssesmentModel::where('catid', $id)->get();
        return count($subAssessment);
    }

    public function getScoreEntriesBySpaceId($space_id)
    {
        $scores = AssessmentResultModel::where('space_id', $space_id)->orderBy('id', 'DESC')->get();

        if($scores == null){
            return 0;
        }else{
            return $scores;
        }
    }

    public function getScoremain($assessment_id)
    {
        $mainScore = AssessmentScoreResultModel::where('assessment_id', $assessment_id)->first();
        // if($mainScore == null){
        //     return 0;
        // }else{

        //     return $mainScore;
        // }
        return $mainScore;
    }

    public function getGrandTotal($term, $regno, $session)
    {
        $grandTotal = RecordMarks::where(['term'=>$term, 'student_id'=>$regno, 'session'=>$session])->sum('scrores');
        if($grandTotal == null){
            return 0;
        }else{
            return round($grandTotal, 2);
        }
    }

    public function getStudentAverage($term, $regno, $session, $classid, $section)
    {
        $getAverage = ComputedAverages::where(['term'=>$term, 'session'=>$session, 'regno'=>$regno])->first();
        if($getAverage == null){
            return 0;
        }else{
            return $getAverage->studentaverage;
        }
    }

    public function getClassCount($term, $regno, $session, $classid, $section)
    {
        $getAverage = ComputedAverages::where(['term' => $term, 'session' => $session, 'regno' => $regno])->first();
        if ($getAverage == null) {
            return 0;
        } else {
            return $getAverage->studentaverage;
        }
    }

    public function getClassAverage($term, $session, $classid, $section)
    {
        $getAverage = ComputedAverages::where(['term'=>$term, 'session'=>$session])->first();
        if($getAverage == null){
            return 0;
        }else{
            return $getAverage->studentaverage;
        }
        
    }

    public function subAssessmentRow($space_id)
    {
        $subAssessment = $this->getScoreEntriesBySpaceId($space_id);
        $subAssessmentScore = array();
        for ($k=0; $k < count($subAssessment); $k++) { 
            $mainScore = $this->getScoremain($subAssessment[$k]->id);
            $value = $mainScore == NULL ? 0:$mainScore->score;
            // if($mainScore == 0){
            //     $value = 0;
            // }else{
            //     $value = $mainScore->score;
            // }
            $subAssScore = '<td><center>'.$value.'</center></td>';
            array_push($subAssessmentScore, $subAssScore);
        }
        return $subAssessmentScore;
    }

    public function getHeadOfSchoolComment($average)
    {
        $comments = HeadOfchoolComment::all();
        $selectedComment = 'Nill';
        for ($i=0; $i < count($comments); $i++) { 
            
            if ($average >= $comments[$i]->marksFrom && $average <= $comments[$i]->marksTo ) {
                $selectedComment = $comments[$i]->comment;
            }

        }

        return $selectedComment;
    }
}
