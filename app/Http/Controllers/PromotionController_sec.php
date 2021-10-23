<?php

namespace App\Http\Controllers;

use App\Addclub_sec;
use App\Addhouse_sec;
use Illuminate\Http\Request;
use App\Addsection_sec;
use App\Classlist_sec;
use App\Addstudent_sec;
use App\AddStudentToHostel;
use App\Addpost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;


class PromotionController_sec extends Controller
{
    public function index(){

        // $classlist_sec = Classlist_sec::where('schoolid',Auth::user()->schoolid)->get();
        // $addsection_sec = Addsection_sec::where('schoolid', Auth::user()->schoolid)->get();
        // $addpost = Addpost::where('id', Auth::user()->schoolid)->get();

        // if ($addpost[0]['schoolsession'] == NULL) {
        //     return back()->with('error', 'School Session not set');
        // }

        // $alldetails = array(
        //     'classlist_sec'=>$classlist_sec,
        //     'addsection_sec'=>$addsection_sec,
        //     'addpost'=>$addpost
        // );

        // $currentsession = $alldetails['addpost'][0]['schoolsession'];

        // $explodesession = explode("/", $currentsession);

        // $oldsessionleft = $explodesession[0] - 1;
        // $oldsessionright = $explodesession[1] - 1;

        // $oldsessionboth = $oldsessionleft."/".$oldsessionright;

        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('secondary.promotion.promotion_sec', compact('schooldetails'));
    }

    public function fetchstudentforpromotion(Request $request){

        $validator = Validator::make($request->all(),[
            'promofromclass' => 'required',
            'promofromsection' => 'required',
            'promofromsession' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }
        
        // promotion procedure
        // promotion is only possible when there is a change in session. upward change
        // promotion will only work if classes are arranged in ascending order.

        $addstudent_sec = DB::table('addstudent_secs')
                        ->join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
                        ->join('users','users.id','=','addstudent_secs.usernamesystem')
                        ->leftjoin('promotion_average_secs',['promotion_average_secs.regno'=>'addstudent_secs.id', 'promotion_average_secs.session'=>'addstudent_secs.schoolsession'])
                        ->select('addstudent_secs.*', 'classlist_secs.classname', 'users.firstname', 'users.middlename', 'users.lastname', 'promotion_average_secs.promomarks')
                        ->where(['addstudent_secs.classid'=>$request->input('promofromclass'), 'addstudent_secs.studentsection'=>$request->input('promofromsection'), 'addstudent_secs.schoolsession'=>$request->input('promofromsession'), 'sessionstatus'=>"0"])->get();
                        
                        
                        // fetch classes in ascending order depends on if schools are entered in ascending order as instructed

                        $classlist_secs = Classlist_sec::where(['schoolid'=> Auth::user()->schoolid, 'status'=>1])->orderBy("id", "ASC")->get();
                        $a = array();
                        for ($i=0; $i < count($classlist_secs); $i++) { 
                            $addsubjectid = $classlist_secs[$i]['id'];
                                array_push($a, $addsubjectid);
                        }
                        
                        $promofromclass = $request->input('promofromclass'); // class you are promoting from

                        if (max($a) == $promofromclass) // check if the id of the class we are promoting from is same as the one we are proting to. if same, no promotion allowed
                        {
                            return response()->json(['success'=>'nopromo', 'addstudent_sec'=>$addstudent_sec]);
                        }

                        $nextClass=""; // varriable decleration for the next class. i.e the class we are promoting to

                        for ($i=0; $i < count($a); $i++) // loop to find the next class to promote student to...
                        { 

                            $classidvalue = $a[$i];

                            if ($promofromclass == $classidvalue) {
                                $nextClass = $a[$i+1];
                                // $nextClass;
                            }
                        }

                        $nextClassMain = Classlist_sec::where('id', $nextClass)->get(); // next class details finally gotten...

                        $requiredDetails = array(
                            'addstudent_sec'=>$addstudent_sec,
                            'classlist_secs'=>$nextClassMain
                        );

        return response()->json(['success'=>$requiredDetails]);
        
    }

    public function promotionmain(Request $request){



        if ($request->promotewithaverage == "0") {

            $addstudent_sec = Addstudent_sec::join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
                            ->join('users','users.id','=','addstudent_secs.usernamesystem')
                            ->leftjoin('promotion_average_secs',['promotion_average_secs.regno'=>'addstudent_secs.id', 'promotion_average_secs.session'=>'addstudent_secs.schoolsession'])
                            ->select('addstudent_secs.*', 'classlist_secs.classname', 'users.firstname', 'users.middlename', 'users.lastname', 'promotion_average_secs.promomarks')
                            ->where(['addstudent_secs.classid'=>$request->classfrom, 'addstudent_secs.studentsection'=>$request->promofromsection, 'addstudent_secs.schoolsession'=>$request->previoussession, 'sessionstatus'=>"0"])->get();



                    if (count($addstudent_sec) < 1) // check if there is student in the currently selected class for promotion...
                    {
                        return back('warning', 'No student in the selected class');
                    }


                    for ($i=0; $i < count($addstudent_sec); $i++) 
                    { 

                        if ((int)$addstudent_sec[$i]->promomarks >= (int)$request->promotionaverage) {

                            if ($request->input('nextClassDisplayname') == "GRAD") // check if the student is in final year in the school. Remove student from hostel if done with school
                            {
    
                                $promoteStudentNow = Addstudent_sec::find($addstudent_sec[$i]->id);
                                $promoteStudentNow->sessionstatus = "1";
                                $promoteStudentNow->save();
    
                                $getHostelId = AddStudentToHostel::where('regno', $addstudent_sec[$i]->id)->get();
    
                                if (count($getHostelId) > 0) {
                                    $hostelIdMain = $getHostelId[0]['id'];
    
                                    $removeStudentHostel = AddStudentToHostel::find($hostelIdMain);
                                    $removeStudentHostel->delete();
    
                                }
                                
                            }else{
    
                                $promoteStudentNow = Addstudent_sec::find($addstudent_sec[$i]->id);
                                $promoteStudentNow->classid = $request->classto;
                                $promoteStudentNow->schoolsession = $request->newsession;
                                $promoteStudentNow->save();
    
                            }
                            
                        }

                    }

                    if ((int)$addstudent_sec[$i]->promomarks == null) {
                        return response()->json(['response'=>'error']);
                    }else{
                        return response()->json(['response'=>'success']);
                    }

                    


            
        }elseif ($request->promotewithaverage == "1") {

            $addstudent_sec = DB::table('addstudent_secs')
                    ->join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
                    ->join('users','users.id','=','addstudent_secs.usernamesystem')
                    ->leftjoin('promotion_average_secs',['promotion_average_secs.regno'=>'addstudent_secs.id', 'promotion_average_secs.session'=>'addstudent_secs.schoolsession'])
                    ->select('addstudent_secs.*', 'classlist_secs.classname', 'users.firstname', 'users.middlename', 'users.lastname', 'promotion_average_secs.promomarks')
                    ->where(['addstudent_secs.classid'=>$request->classfrom, 'addstudent_secs.studentsection'=>$request->promofromsection, 'addstudent_secs.schoolsession'=>$request->previoussession, 'sessionstatus'=>"0"])->get();


                return $addstudent_sec;


                if (count($addstudent_sec) < 1) // check if there is student in the currently selected class for promotion...
                {
                    return back('warning', 'No student in the selected class');
                }


                for ($i=0; $i < count($addstudent_sec); $i++) 
                { 

                    if ($request->input('nextClassDisplayname') == "GRAD") // check if the student is in final year in the school. Remove student from hostel if done with school
                    {

                        $promoteStudentNow = Addstudent_sec::find($addstudent_sec[$i]->id);
                        $promoteStudentNow->sessionstatus = "1";
                        $promoteStudentNow->save();

                        $getHostelId = AddStudentToHostel::where('regno', $addstudent_sec[$i]->id)->get();

                        if (count($getHostelId) > 0) {
                            $hostelIdMain = $getHostelId[0]['id'];

                            $removeStudentHostel = AddStudentToHostel::find($hostelIdMain);
                            $removeStudentHostel->delete();

                        }
                        
                    }else{

                        $promoteStudentNow = Addstudent_sec::find($addstudent_sec[$i]->id);
                        $promoteStudentNow->classid = $request->classto;
                        $promoteStudentNow->schoolsession = $request->newsession;
                        $promoteStudentNow->save();

                    }

                }


                if ((int)$addstudent_sec[$i]->promomarks == null) {
                    return response()->json(['response'=>'error']);
                }else{
                    return response()->json(['response'=>'success']);
                }
            
        }else {
            return response()->json(['response'=>'error']);
        }





    }

    public function promotejss3toss1(Request $request){

        $validator = Validator::make($request->all(),[
            'nextpromotoss1jss3' => 'required',
            'studenttopromoteregno' => 'required',
            'nextclassforjss3' => 'required',
            'newsection' => 'required',
            'newsessionvalue'=> 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }
        
        // promote students from jss3 to sss1.

        $newclassid = $request->input('nextpromotoss1jss3');
        $studentregnumber = $request->input('studenttopromoteregno');
        $newclassname = $request->input('nextclassforjss3');
        $newSectionid = $request->input('newsection');

        //update promotion details
        $updatesinglestudentpromtion = Addstudent_sec::find($studentregnumber);
        $updatesinglestudentpromtion->classid = $newclassid;
        $updatesinglestudentpromtion->studentsection = $newSectionid;
        $updatesinglestudentpromtion->schoolsession = $request->input('newsessionvalue');
        $updatesinglestudentpromtion->save();

        return response()->json(['success'=>'success']);

    }

    public function getSchoolDetails()
    {
        $schoolDetails = Addpost::where('id', Auth::user()->schoolid)->first();

        $classlist = Classlist_sec::where(["schoolid"=> Auth::user()->schoolid, 'status'=>1])->get();

        $classsection = Addsection_sec::where("schoolid", Auth::user()->schoolid)->get();

        $getPreviousSession = explode("/", $schoolDetails->schoolsession);

        $previousSessionmain = ((int)$getPreviousSession[0]-1)."/".((int)$getPreviousSession[1]-1);

        return response()->json(['schoolDetails'=>$schoolDetails, 'classlist'=>$classlist, 'classsection'=>$classsection, 'previousSessionmain'=>$previousSessionmain]);
    }

    public function updatePromotionAverage(Request $request)
    {

        try {
            if ($request->key == "averageMark") {
                $schoolDetails = Addpost::find(Auth::user()->schoolid);
                $schoolDetails->promotionaverage = $request->average;
                $schoolDetails->save();
    
                return response()->json(['response'=>'success']);
            }else{
                $schoolDetails = Addpost::find(Auth::user()->schoolid);
                $schoolDetails->averagestatus = $request->average;
                $schoolDetails->save();
    
                return response()->json(['response'=>'success']);
            }


        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response'=>'error']);
        }


        
    }
}
