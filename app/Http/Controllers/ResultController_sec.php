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

    public function fetchresultdetails(Request $request){
        
        $validatedData = $request->validate([
            'classid' => 'required',
            'term' => 'required',
            'regNo' => 'required',
            'session'=>'required'
        ]);

        $classid = $request->input('classid');
        $term = $request->input('term');
        $regNo = $request->input('regNo');
        $schoolsession = $request->input('session');
        
//---------------------------------------------------------------------------------
//-----------------------------update classcount here------------------------------
//---------------------------------------------------------------------------------

        $classList = Classlist_sec::where('schoolid', Auth::user()->schoolid)->get();

        if(count($classList) > 0){
            for ($i=0; $i < count($classList); $i++) { 
                $classidcountupdate = $classList[$i]['id'];
                
                $studentcountquery = Addstudent_sec::where('classid', $classidcountupdate)->get();
                
                $maincount = count($studentcountquery);
                
                $updatecountquery = Classlist_sec::find($classidcountupdate);
                $updatecountquery->studentcount = $maincount;
                $updatecountquery->save();
                
            }
        }

//--------------------------------------------------------------------------------
//                                 process class average
//--------------------------------------------------------------------------------

        $subjectarray = Addsubject_sec::where('classid', $classid)->pluck('id');
        

        for ($i=0; $i < count($subjectarray); $i++) {

            $subjectidav = $subjectarray[$i];

            $addmarkcounter = Addmark_sec::where(['classid'=>$classid, 'term'=>$term, 'subjectid'=>$subjectidav, 'session'=>$schoolsession])->get();

            $addmarkAverage = DB::table('addmark_secs') 
            ->where(['classid'=>$classid, 'term'=>$term, 'subjectid'=>$subjectidav])->SUM('totalmarks');

            if (count($addmarkcounter) > 0) {
                $averagemark = $addmarkAverage/count($addmarkcounter);

                // return $addmarkAverage;

                // check if average has already been added.

                $averageCheck = ClassAverageMark::where(['session'=>$schoolsession, 'classid'=>$classid, 'term'=>$term, 'subjectid'=>$subjectidav])->get();

                if (count($averageCheck) > 0) {

                    $averageCheckid = $averageCheck[0]['id'];

                    $averagemarkupdate = ClassAverageMark::find($averageCheckid);
                    $averagemarkupdate->average = $averagemark;
                    $averagemarkupdate->save();
                    // return $averageCheck;
                    
                }else{

                    $addaverage = new ClassAverageMark();
                    $addaverage->subjectid = $subjectidav;
                    $addaverage->schoolid = Auth::user()->schoolid;
                    $addaverage->classid = $classid;
                    $addaverage->average = $averagemark;
                    $addaverage->term = $term;
                    $addaverage->session = $schoolsession;
                    $addaverage->save();

                }

            }
            
        }


        $getaverageposition = ResultAverage::where(['classid'=>$classid, 'regno'=>$regNo, 'term'=>$term, 'session'=>$schoolsession])->get();

        if (count($getaverageposition) < 1) {

            return response()->json(['notready' => 'notready'], 200);
        }else{

            $psycomoto = Addmoto_sec::where(['classid'=>$classid, 'term'=>$term, 'regno'=>$regNo, 'session'=>$schoolsession])->get();

            if (count($psycomoto) < 1) {
                return response()->json(['notready' => 'notready'], 200);
            }else{
                $resultdetails = DB::table('addmark_secs')
                ->join('addsubject_secs', 'addsubject_secs.id','=','addmark_secs.subjectid')
                ->join('class_average_marks', 'class_average_marks.subjectid','=','addmark_secs.subjectid')
                ->join('classlist_secs', 'classlist_secs.id','=','addmark_secs.classid')
                ->select('addmark_secs.*', 'addsubject_secs.subjectname', 'class_average_marks.average', 'classlist_secs.classname')
                ->where(['addmark_secs.schoolid'=>Auth::user()->schoolid, 'addmark_secs.classid'=>$classid, 'addmark_secs.term'=>$term, 'addmark_secs.regno'=>$regNo])->get();



                $fetchUserDetails = DB::table('addstudent_secs')
                    ->join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
                    ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
                    ->join('addsection_secs', 'addsection_secs.id','=','addstudent_secs.studentsection')
                    ->select('addstudent_secs.*', 'classlist_secs.classname', 'users.firstname', 'users.middlename', 'users.lastname', 'addsection_secs.sectionname')
                    ->where(['addstudent_secs.id'=>$regNo])->get();

                return response()->json(['resultdetails'=>$resultdetails, 'fetchUserDetails'=>$fetchUserDetails, 'psycomoto'=>$psycomoto, 'positionaverage'=>$getaverageposition]);
            }
        }
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
            $getSubjectList = CLassSubjects::where(['classid'=> $classid, 'sectionid'=>$studentdetails->studentsection])->pluck('subjectid')->toArray();

            $subject = array();

            for ($i=0; $i < count($getSubjectList); $i++) { 

              $addmarksCheck = Addmark_sec::where(['subjectid' => $getSubjectList[$i], 'term' => $request->term, 'session'=>$request->session, 'regno'=>$request->student_reg_no])->get();

                if (count($addmarksCheck) > 0) {

                    if ((int)$addmarksCheck[0]->totalmarks > 0) {
                        $getSingleSubject = Addsubject_sec::find($getSubjectList[$i]);
                        array_push($subject, $getSingleSubject);
                    }
                }
            }

            $subjects = collect($subject);

            $motolistbeha = MotoList::where(['schoolid'=> Auth::user()->schoolid, 'category' => 'behaviour'])->get();

            $motolistskills = MotoList::where(['schoolid'=> Auth::user()->schoolid, 'category' => 'skills'])->get();
    
            $resultAverage = ResultAverage::where(["regno"=>$regNo, "schoolid"=>Auth::user()->schoolid, "classid"=>$classid, "term"=>$term, "session"=>$schoolsession])->first();

    
            $studentClass = Classlist_sec::find($classid);
    
            if ($checkclasstype->classtype == 1) {

                // $pdf = App::make('dompdf.wrapper');

                // $data = User::where('schoolid', "6")->get();

                // $html = '';

                // for ($i=0; $i < $data->count(); $i++) { 

                //     $datamain = $data[$i];

                //     $view = view('secondary.result.viewresult.resulttest', compact('datamain'));

                //     $html .= $view->render();

                    
                // }

                // $pdf->loadHTML($html);


                
                // return $pdf->stream();

                // $studentInClass = Addstudent_sec::where('classid', 30)->get();

                // return view('secondary.result.viewresult.resulttest', compact('studentInClass', 'motolistbeha', 'motolistskills', 'addschool'));

                return view('secondary.result.viewresult.singlejunior', compact('studentdetails', 'addschool', 'schoolsession', 'term', 'subjects', 'motolistbeha', 'motolistskills', 'resultAverage', 'studentClass'));
            } else {
                return view('secondary.result.viewresult.singleresult', compact('studentdetails', 'addschool', 'schoolsession', 'term', 'subjects', 'motolistbeha', 'motolistskills', 'resultAverage', 'studentClass'));
            }
        } catch (\Throwable $th) {
            //throw $th;

            return $th;
        }
        
        

//--------------------------------------------------------------------------------
//                                 process class average
//--------------------------------------------------------------------------------

        $subjectarray = Addsubject_sec::where('classid', $classid)->pluck('id');
        

        for ($i=0; $i < count($subjectarray); $i++) {

            $subjectidav = $subjectarray[$i];

            $addmarkcounter = Addmark_sec::where(['classid'=>$classid, 'term'=>$term, 'subjectid'=>$subjectidav, 'session'=>$schoolsession])->get();

            $addmarkAverage = DB::table('addmark_secs') 
            ->where(['classid'=>$classid, 'term'=>$term, 'subjectid'=>$subjectidav])->SUM('totalmarks');

            if (count($addmarkcounter) > 0) {
                $averagemark = $addmarkAverage/count($addmarkcounter);

                // return $addmarkAverage;

                // check if average has already been added.

                $averageCheck = ClassAverageMark::where(['session'=>$schoolsession, 'classid'=>$classid, 'term'=>$term, 'subjectid'=>$subjectidav])->get();

                if (count($averageCheck) > 0) {

                    $averageCheckid = $averageCheck[0]['id'];

                    $averagemarkupdate = ClassAverageMark::find($averageCheckid);
                    $averagemarkupdate->average = $averagemark;
                    $averagemarkupdate->save();
                    // return $averageCheck;
                    
                }else{

                    $addaverage = new ClassAverageMark();
                    $addaverage->subjectid = $subjectidav;
                    $addaverage->schoolid = Auth::user()->schoolid;
                    $addaverage->classid = $classid;
                    $addaverage->average = $averagemark;
                    $addaverage->term = $term;
                    $addaverage->session = $schoolsession;
                    $addaverage->save();

                }

            }
            
        }


        $getaverageposition = ResultAverage::where(['classid'=>$classid, 'regno'=>$regNo, 'term'=>$term, 'session'=>$schoolsession])->get();

        if (count($getaverageposition) < 1) {

            return response()->json(['notready' => 'notready'], 200);
        }else{

            $psycomoto = Addmoto_sec::where(['classid'=>$classid, 'term'=>$term, 'regno'=>$regNo, 'session'=>$schoolsession])->get();

            if (count($psycomoto) < 1) {
                return response()->json(['notready' => 'notready'], 200);
            }else{
                
                $resultdetails = DB::table('addmark_secs')
                                ->join('addsubject_secs', 'addsubject_secs.id','=','addmark_secs.subjectid')
                                ->join('class_average_marks', 'class_average_marks.subjectid','=','addmark_secs.subjectid')
                                ->join('classlist_secs', 'classlist_secs.id','=','addmark_secs.classid')
                                ->select('addmark_secs.*', 'addsubject_secs.subjectname', 'class_average_marks.average', 'classlist_secs.classname')
                                ->where(['addmark_secs.schoolid'=>Auth::user()->schoolid, 'addmark_secs.classid'=>$classid, 'addmark_secs.term'=>$term, 'addmark_secs.regno'=>$regNo])->get();

                $fetchUserDetails = DB::table('addstudent_secs')
                                    ->join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
                                    ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
                                    ->join('addsection_secs', 'addsection_secs.id','=','addstudent_secs.studentsection')
                                    ->select('addstudent_secs.*', 'classlist_secs.classname', 'users.firstname', 'users.middlename', 'users.lastname', 'addsection_secs.sectionname')
                                    ->where(['addstudent_secs.id'=>$regNo])->get();

                return response()->json(['resultdetails'=>$resultdetails, 'fetchUserDetails'=>$fetchUserDetails, 'psycomoto'=>$psycomoto, 'positionaverage'=>$getaverageposition]);
            }
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

        return view('secondary.result.viewresult.resulttest', compact('studentInClass', 'motolistbeha', 'motolistskills', 'addschool', 'term', 'schoolsession', 'classid', 'section', 'classtype'));
    }




}
