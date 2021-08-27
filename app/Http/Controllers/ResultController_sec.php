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
use App\ElectiveAdd;
use App\User;

class ResultController_sec extends Controller
{
    public function index(){

        $classlist_sec = Classlist_sec::where('schoolid', Auth::user()->schoolid)->get();
        
        if(Auth::user()->role == "Student"){
            $studentdetails = Addstudent_sec::where('usernamesystem', Auth::user()->id)->get();
            
            $allDetails = array(
                'classlist_sec'=>$classlist_sec,
                'studentdetails'=>$studentdetails
            );
            
        }else{
            
            $allDetails = array(
                'classlist_sec'=>$classlist_sec
            );
            
        }

        // $allDetails = array(
        //     'classlist_sec'=>$classlist_sec
        // );

        return view('secondary.result_sec')->with('allDetails', $allDetails);
    }

    public function viewResult(Request $request){

        $validatedData = $request->validate([
            'selectedclassmarks' => 'required',
            'selectedtermmarks' => 'required',
            'studentRegnomarks' => 'required',
            'schoolsession'=>'required'
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
            'addpost'=>$addpost
        );

        return view('secondary.result_view_sec')->with('allDetails', $allDetails);
    }


    public function viewSingleResult(Request $request)
    {

        $validatedData = $request->validate([
            'classid' => 'required',
            'term' => 'required',
            'student_reg_no' => 'required',
            'session'=>'required'
        ]);


        try {
            $classid = $request->input('classid');
            $term = $request->input('term');
            $regNo = $request->input('student_reg_no');
            $schoolsession = $request->input('session');
    
            $checkclasstype = Classlist_sec::find($classid);
    
            $studentdetails = Addstudent_sec::find($regNo);
    
            $addschool = Addpost::find(Auth::user()->schoolid);

            //get subject list
            $getSubjectList = CLassSubjects::where(['classid'=> $classid, 'sectionid'=>$studentdetails->studentsection, 'subjecttype'=>2])->pluck('subjectid')->toArray();
            $getStudentElective = ElectiveAdd::where(['regno'=>$regNo, 'classid'=>$classid, 'sectionid'=>$studentdetails->studentsection])->pluck('subjectid')->toArray(); // get all student's elective subjects


            $subject = array();

            $subjectSum  = array_merge($getSubjectList, $getStudentElective);


            for ($i=0; $i < count($subjectSum); $i++) { 

              $addmarksCheck = Addmark_sec::where(['subjectid' => $subjectSum[$i], 'term' => $request->term, 'session'=>$request->session, 'regno'=>$request->student_reg_no])->get();

                if (count($addmarksCheck) > 0) {

                    if ((int)$addmarksCheck[0]->totalmarks > 0) {
                        $getSingleSubject = Addsubject_sec::find($subjectSum[$i]);
                        array_push($subject, $getSingleSubject);
                    }
                }
            }

            $subjects = collect($subject);

            $motolistbeha = MotoList::where(['schoolid'=> Auth::user()->schoolid, 'category' => 'behaviour'])->get();

            $motolistskills = MotoList::where(['schoolid'=> Auth::user()->schoolid, 'category' => 'skills'])->get();
    
            $resultAverage = ResultAverage::where(["regno"=>$regNo, "schoolid"=>Auth::user()->schoolid, "classid"=>$classid, "term"=>$term, "session"=>$schoolsession])->first();

    
            $studentClass = Classlist_sec::find($classid);

            if ($addschool->schooltype == "Primary") {

                return view('secondary.result.viewresult.singleprimary', compact('studentdetails', 'addschool', 'schoolsession', 'term', 'subjects', 'motolistbeha', 'motolistskills', 'resultAverage', 'studentClass'));

            }else{

                if ($checkclasstype->classtype == 1) {
    
                    return view('secondary.result.viewresult.singlejunior', compact('studentdetails', 'addschool', 'schoolsession', 'term', 'subjects', 'motolistbeha', 'motolistskills', 'resultAverage', 'studentClass'));
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

        return view('secondary.result.resultbyclass', compact('school'));
    }

    public function view_by_class(Request $request)
    {
        $term = $request->term;
        $section = $request->section;
        $session = $request->session;

        $entirestudent = Addstudent_sec::where(['classid'=>$request->classid, "studentsection"=>$request->section, "schoolsession"=>$request->session])->get();

        return view('secondary.result.viewentireclass', compact('entirestudent', 'term', 'section', 'session'));
    }

    public function generateResult()
    {
       $classlist = Classlist_sec::where('schoolid', Auth::user()->schoolid)->get();

       $schoolDetails = Addpost::find(Auth::user()->schoolid);

        $checkRecord = ResultAverage::where(['session'=>$schoolDetails->schoolsession, 'term'=>$schoolDetails->term, 'schoolid'=>Auth::user()->schoolid])->pluck('classid')->toArray();

        // return view('secondary.adminside.result.generateresult', compact('classlist', 'checkRecord'));

        return view('secondary.adminside.result.generateresultreact');
    }

    public function generateResultMain(Request $request, ProcessClassAverage $processClassAverage, ResultAverageProcess $resultAverageProcess)
    {

        //--------------------------------------------------------------------------------
        //                                 process class average
        //--------------------------------------------------------------------------------

        try {
            $resultAverage = $resultAverageProcess->processResultAverage($request);

            if ($resultAverage == "success") {
                
                $process_class_average = $processClassAverage->processresult($request);
    
                return $process_class_average;
            }else{
                return $resultAverage;
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }

    }

    public function get_result_ready_section()
    {
        try {

            $term = Addpost::find(Auth::user()->schoolid);

            $getReadyResults = ResultReadyModel::join('classlist_secs', 'classlist_secs.id','=','result_ready_models.classid')
                            ->join('addsection_secs', 'addsection_secs.id','=','result_ready_models.sectionid')
                            ->where(['result_ready_models.schoolid'=> Auth::user()->schoolid, 'result_ready_models.term'=>$term->term])
                            ->select('result_ready_models.*', 'classlist_secs.classname', 'classlist_secs.id as classid', 'addsection_secs.sectionname', 'addsection_secs.id as sectionid')->get();

            return response()->json(['getReadyResults' => $getReadyResults]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['getReadyResults' => $th]);
        }
    }

    public function loadHtmlDoc(Request $request)
    {

        $motolistbeha = MotoList::where(['schoolid'=> Auth::user()->schoolid, 'category' => 'behaviour'])->get();

        $motolistskills = MotoList::where(['schoolid'=> Auth::user()->schoolid, 'category' => 'skills'])->get();

        $addschool = Addpost::find(Auth::user()->schoolid);

        return view('secondary.result.viewresult.resulttest', compact('motolistbeha', 'motolistskills', 'addschool'));


        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('secondary.result.viewresult.resulttest', compact('motolistbeha', 'motolistskills', 'addschool'));
        return $pdf->stream();

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

        $addschool = Addpost::find(Auth::user()->schoolid);

        $classtype = Classlist_sec::find($classid)->classtype;

        //get studentlist for same class and section
        $studentList = Addstudent_sec::where(['classid'=>$request->classid, 'studentsection'=>$request->section, 'schoolsession'=>$request->session])->pluck('id')->toArray();

        // return $studentList;
        $studentInClass = Addstudent_sec::where(['classid'=> $classid, 'studentsection'=>$section])->get();

        $motolistbeha = MotoList::where(['schoolid'=> Auth::user()->schoolid, 'category' => 'behaviour'])->get();

        $motolistskills = MotoList::where(['schoolid'=> Auth::user()->schoolid, 'category' => 'skills'])->get();

        $resultAverage = ResultAverage::where(["regno"=>$regNo, "schoolid"=>Auth::user()->schoolid, "classid"=>$classid, "term"=>$term, "session"=>$schoolsession])->first();

        if ($addschool->schooltype == "Primary") {
            return view('secondary.result.viewresult.resultlistpri', compact('studentInClass', 'motolistbeha', 'motolistskills', 'addschool', 'term', 'schoolsession', 'classid', 'section', 'classtype'));
        }else{
            return view('secondary.result.viewresult.resulttest', compact('studentInClass', 'motolistbeha', 'motolistskills', 'addschool', 'term', 'schoolsession', 'classid', 'section', 'classtype'));
        }

        
    }




}
