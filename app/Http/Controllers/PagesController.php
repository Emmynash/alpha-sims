<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Addpost;
use App\User;
use App\Classlist;
use App\Addhouses;
use App\Addsection;
use App\AddClub;
use App\Addmarks;
use App\Addgrades;
use App\Addgrades_sec;
use Auth;
use Redirect;
use Validator;

class PagesController extends Controller
{
    public function index(){
        
        if(Auth::guest()){
            
        $addpost = Addpost::where('status', 'Approved')->get();

        return view('pages.index')->with('addpost', $addpost);
            
        }else{
            return redirect('/home');
        }
        
        
    }

    public function setUpSchool(){

        $id = Auth::user()->schoolid;
        
        // return "";


        $userschool = Addpost::where('id', $id)->get();
        $classList = Classlist::where('schoolid', $id)->get();
        $addHouses = Addhouses::where('schoolid', $id)->get();
        $addSection = Addsection::where('schoolid', $id)->get();
        $addClub = AddClub::where('schoolid', $id)->get();
        $addgrades = Addgrades::where('schoolid', $id)->get();

        

        $studentDetails = array(
            'userschool' => $userschool,
            'classList' => $classList,
            'addHouses' => $addHouses,
            'addSection' => $addSection,
            'addClub' => $addClub,
            'addgrades' => $addgrades
        );


        return view('pages.schoolsetup')->with('studentDetails', $studentDetails);
    }

    public function updateSchoolInitial(Request $request){

        $schoolIdAsigned = $request->input('initialvalue');
        $schoolInitialValue = $request->input('schoolInitialValue');

        $schoolIdProcess = Addpost::where('id', Auth::user()->schoolid)->get();

        $id = $schoolIdProcess[0]['id'];

        $addSchoolInitial = Addpost::find($id);
        $addSchoolInitial->shoolinitial = strtoupper($schoolIdAsigned);
        $addSchoolInitial->save();

        $msg = "success";

        return response()->json(array("msg" => $schoolIdAsigned), 200);
    }

    public function addclasslist(Request $request){

        $classlist = $request->input('classlist');

        if (strlen($classlist) == "") {
            $msg = "failed";
        }else{
            $classlistarray = explode(",", $classlist);

            $classCount = count($classlistarray);
    
            for ($x = 0; $x <= $classCount-1; $x++) {
            //    $msg = $classlistarray[2];
               $classListdata = new Classlist;
               $classListdata->schoolid = Auth::user()->schoolid;
               $classListdata->classnamee = $classlistarray[$x];
               $classListdata->studentcount = "0";
               $classListdata->save();
              }
    
              $msg = "success";
    
            return response()->json(array("msg" => $msg), 200);
        }
    }

    public function addhouses(Request $request){

        $houselist = $request->input('houselist');

        $houselistarray = explode(",", $houselist);

        $houseCount = count($houselistarray);

        for ($x = 0; $x <= $houseCount-1; $x++) {
        //    $msg = $classlistarray[2];
           $housesListdata = new Addhouses;
           $housesListdata->schoolid = Auth::user()->schoolid;
           $housesListdata->housename = $houselistarray[$x];
           $housesListdata->save();
          }

          $msg = "success";


        return response()->json(array("msg" => $msg), 200);

    }

    public function addsection(Request $request){
        $sectionlist = $request->input('sectionlist');


        $sectionlistarray = explode(",", $sectionlist);

        $sectionCount = count($sectionlistarray);

        for ($x = 0; $x <= $sectionCount-1; $x++) {
        //    $msg = $classlistarray[2];
           $sectionListdata = new Addsection;
           $sectionListdata->schoolid = Auth::user()->schoolid;
           $sectionListdata->sectionname = $sectionlistarray[$x];
           $sectionListdata->save();
          }

        $msg = "success";


        return response()->json(array("msg" => $msg), 200);
    }

    public function addclublist(Request $request){

        $clublist = $request->input('clublist');

        $clublistarray = explode(",", $clublist);

        $clubCount = count($clublistarray);

        for ($x = 0; $x <= $clubCount-1; $x++) {
        //    $msg = $classlistarray[2];
           $clubListdata = new Addclub;
           $clubListdata->schoolid = Auth::user()->schoolid;
           $clubListdata->clubname = $clublistarray[$x];
           $clubListdata->save();
          }

        $msg = "success";


        return response()->json(array("msg" => $msg), 200);

    }

    public function addsession(Request $request){

        $validator = Validator::make($request->all(),[
            'schoolsessionSetter' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $updatesession = Addpost::find(Auth::user()->schoolid);
        $updatesession ->schoolsession = $request->input('schoolsessionSetter');
        $updatesession->save();

        $msg = "1";

        return response()->json(array("result" => $msg), 200);
    }

    public function grades(){

        $id = Auth::user()->schoolid;


        $userschool = Addpost::where('id', $id)->get();
        $classList = Classlist::where('schoolid', $id)->get();
        $addHouses = Addhouses::where('schoolid', $id)->get();
        $addSection = Addsection::where('schoolid', $id)->get();
        $addClub = AddClub::where('schoolid', $id)->get();
        $addgrades = Addgrades::where('schoolid', $id)->get();

        

        $studentDetails = array(
            'userschool' => $userschool,
            'classList' => $classList,
            'addHouses' => $addHouses,
            'addSection' => $addSection,
            'addClub' => $addClub,
            'addgrades' => $addgrades
        );

        // return $studentDetails['addgrades'];

        return view('pages.grade')->with('studentDetails', $studentDetails);
    }

    public function submitMark(Request $request){

        $validatedData = $request->validate([
            'gpafor' => 'required',
            'grade' => 'required',
            'point' => 'required',
            'markfrom' => 'required',
            'markto' => 'required',
        ]);

        $addmarks = new Addgrades();
        $addmarks->gpafor = $request->input('gpafor');
        $addmarks->schoolid = Auth::user()->schoolid;
        $addmarks->gpaname = $request->input('grade');
        $addmarks->point = $request->input('point');
        $addmarks->marksfrom = $request->input('markfrom');
        $addmarks->marksto = $request->input('markto');
        $addmarks->save();

        return back()->with('success', 'record added successfully');
    }
    
    public function submitMark_sec(Request $request){

        // return $request->input();

        $validatedData = $request->validate([
            'gpafor' => 'required',
            'grademain' => 'required',
            'marksfrom' => 'required',
            'marksto' => 'required',
        ]);

        $addmarks = new Addgrades_sec();
        $addmarks->gpafor = $request->input('gpafor');
        $addmarks->schoolid = Auth::user()->schoolid;
        $addmarks->gpaname = $request->input('grademain');
        $addmarks->point = "NA";
        $addmarks->marksfrom = $request->input('marksfrom');
        $addmarks->marksto = $request->input('marksto');
        $addmarks->save();

        return back()->with('success', 'record added successfully');
    }

    public function deleteGrade(Request $request){

        $entryid = $request->input('entryId');    

        $deletemarks = Addgrades::find($entryid);
        $deletemarks->delete();

        return back()->with('success', 'record deleted successfully');
    }

    public function fetchtoschoolsetup(Request $request){

        $id = Auth::user()->schoolid;

        $classList = Classlist::where('schoolid', $id)->get();

        // $msg = "1";

        return response()->json($classList, 200);

    }
    
    public function tryOurDemo(Request $request){
        
        $validatedData = $request->validate([
            'fullname' => 'required',
            'emailaddress' => 'required',
            'phonenumber' => 'required|numeric|min:11',
            'schoolname' => 'required',
            'schoolsize' => 'required',
        ]);
        
        $emailaddress = $request->input('emailaddress');
        $fullname = $request->input('fullname');
        $phonenumber = $request->input('phonenumber');
        $schoolname = $request->input('schoolname');
        $schoolsize = $request->input('schoolsize');
        
        
        $to = "uhweka@gmail.com";
        $subject = "Request For a Demo with alpha-sim";
        $msg = "Hello my name is".$fullname." from".$schoolname ." I am requesting a demo account with alpha-sims. My school have a size of".$schoolsize."You can contact me on" .$phonenumber." or via email". $emailaddress."";
        $txt = wordwrap($msg,70);;
        $headers = "From:".$emailaddress. "\r\n" .
        "CC: somebodyelse@example.com";
        
        mail($to,$subject,$txt,$headers);
        
        return back()->with('success', 'details submitted. Our customer support will contact you shortly');
        
    }
    
    public function manageStaff(){
        return view('secondary.managestaff');
    }

    public function manageStaffRole(Request $request){

        $validator = Validator::make($request->all(),[
            'staffregnorole'=>'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $users = User::where(['id'=> $request->input('staffregnorole'), 'schoolid'=>Auth::user()->schoolid])->get();

        if (count($users) > 0) {
            return response()->json(['userdetails'=>$users]);
        }else{
            
            $users2 = User::where(['id'=> $request->input('staffregnorole'), 'schoolid'=>NULL, 'role'=>NULL])->get();
            
            if(count($users2) > 0){
                
                return response()->json(['userdetails'=>$users2]);
                
            }else{
                
                return response()->json(['none'=>'none']);
                
            }
        }
        
        
    }

    public function allocateroletostaff(Request $request){

        $validator = Validator::make($request->all(),[
            'systemnumberrole'=>'required|string',
            'roleselect'=>'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $checkstudentrole = User::where(['id'=>$request->input('systemnumberrole'), 'role'=>'Student', 'schoolid'=>Auth::user()->schoolid])->get();

        if (count($checkstudentrole) > 0) {
            return response()->json(['notallow'=>'notallow']);
        }

        $checkadminrole = User::where(['id'=>$request->input('systemnumberrole'), 'role'=>'Admin', 'schoolid'=>Auth::user()->schoolid])->get();

        if (count($checkadminrole) > 0) {
            return response()->json(['notallow'=>'notallow']);
        }

        $checksuperadminrole = User::where(['id'=>$request->input('systemnumberrole'), 'role'=>'SuperAdmin'])->get();

        if (count($checksuperadminrole) > 0) {
            return response()->json(['notallow'=>'notallow']);
        }

        $updaterole = User::find($request->input('systemnumberrole'));
        $updaterole->schoolid = Auth::user()->schoolid;
        $updaterole->role = $request->input('roleselect');
        $updaterole->save();

        return response()->json(['success'=>'success']);


    }


}
