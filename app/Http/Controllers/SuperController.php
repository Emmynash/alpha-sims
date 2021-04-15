<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Addpost;
use Carbon\Carbon;
use Validator;
use App\User;
use App\CallBack;
use App\Addstudent;
use App\Addstudent_sec;
use App\Addteachers_sec;
use App\Addteachers;
use App\Addsubject;
use App\Addsubject_sec;
use App\Classlist;
use App\Classlist_sec;
use App\Events_sec;
use Auth;
use DB;

class SuperController extends Controller
{
    public function index(){

        $allSchools = Addpost::all();
        $allactiveschools = Addpost::where("status", "Approved")->get();
        $allpendingschools = Addpost::where("status", "Pending")->get();

        $allDetails = array(
            "allSchools"=>$allSchools,
            "allactiveschools"=>$allactiveschools,
            "allpendingschools"=>$allpendingschools

        );

        // return $allDetails['allactiveschools'];

        return view('super.index')->with("allDetails", $allDetails);
    }

    public function manageAdmin(Request $request){

        $allAdmins = User::where("role", "SuperAdmin")->get();

        $alldetails = array(
            "allAdmins"=>$allAdmins
        );

        // return $alldetails;

        return view('super.manageadmin')->with("alldetails", $alldetails);
    }

    public function order(){

        $allschools = Addpost::all();
        
        $allschools = DB::table('addposts')
                    ->leftjoin("users", "users.id","=","addposts.track")
                    ->select("addposts.*", "users.firstname", "users.middlename", "users.lastname")->get();

        // return $allschools;


        return view('super.order')->with('allschools', $allschools);
    }

    public function addRoleAdmin(Request $request){

        $validator = Validator::make($request->all(),[
            'adminsystemid' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $adminSystemId = User::where("id", $request->input('adminsystemid'))->get();

        if (count($adminSystemId) > 0) {
            return response()->json(['success' => $adminSystemId], 200);
        }else {
            return response()->json(['none' => "none"], 200);
        }

    }

    public function technicalSupport(){

        return view('super.technicalsuport');
    }

    public function callRequest(){

        if (Auth::user()->role == "SuperAdmin" && Auth::user()->schoolid == null) {
            $callBack = CallBack::orderBy('created_at','desc')->paginate(5);
            $callRequestCount = CallBack::where("status", "Pending")->get();
            $callRequestCountonCall = CallBack::where("status", "CallLater")->get();
            $callRequestCountondone = CallBack::where("status", "CallDone")->get();
    
            $allCallData = array(
                "callBack"=>$callBack,
                "callRequestCount"=>$callRequestCount,
                "callRequestCountonCall"=>$callRequestCountonCall,
                "callRequestCountondone"=>$callRequestCountondone
            );
            // return $allCallData['callBack'];
            return view('super.callrequest')->with("allCallData", $allCallData);
        }



    }

    public function onCallAdd(Request $request){

        if ($request->input('optionselected') == "OnCall") {
            // return $request->input();
            $updateCallStatus = CallBack::find($request->input('callid'));
            $updateCallStatus->status = "Oncall";
            $updateCallStatus->save();

            return back()->with('success', "On Call");
        }

        if ($request->input('optionselected') == "OnCallLater") {
            // return $request->input();
            $updateCallStatus = CallBack::find($request->input('callid'));
            $updateCallStatus->status = "CallLater";
            $updateCallStatus->save();

            return back()->with('success', "On Call");
        }

        if ($request->input('optionselected') == "OnCalldone") {
            // return $request->input();
            $updateCallStatus = CallBack::find($request->input('callid'));
            $updateCallStatus->status = "CallDone";
            $updateCallStatus->save();

            return back()->with('success', "Call Done"); 
        }

        if ($request->input('optionselected') == "Delete") {
            // return $request->input();
            $updateCallStatus = CallBack::find($request->input('callid'));
            $updateCallStatus->delete();

            return back()->with('success', "deleted");
        }



    }

    public function submitCallRequestForm(Request $request){

        $validator = Validator::make($request->all(),[
            'address' => 'required',
            'emailadd' => 'required|email',
            'fullname' => 'required',
            'messagecontent' => 'required',
            'phonenumber' => 'required|min:11',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $data = [
                'secret' => config('services.recaptcha.secret'),
                'response' => $request->get('recaptcha'),
                'remoteip' => $remoteip
            ];
        $options = [
                'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
                ]
            ];
        $context = stream_context_create($options);
                $result = file_get_contents($url, false, $context);
                $resultJson = json_decode($result);
        if ($resultJson->success != true) {
                return back()->withErrors(['captcha' => 'ReCaptcha Error']);
                }
        if ($resultJson->score >= 0.3) {
                //Validation was successful, add your form submission logic here
                return back()->with('message', 'Thanks for your message!');
        } else {
                return back()->withErrors(['captcha' => 'ReCaptcha Error']);
        }

        $checkentry = CallBack::where('phonenumber', $request->input('phonenumber'))->get();
        if (count($checkentry) > 0) {
            return;
        }

        $checkentry2 = CallBack::where('emailadd', $request->input('emailadd'))->get();
        if (count($checkentry2) > 0) {
            return;
        }

        $datemain = Carbon::now();
        $attDate = $datemain->toDateString();

        $daetFInal = Carbon::parse($attDate)->format('d F y');



        $addCallRequest = new CallBack();
        $addCallRequest->date = $daetFInal;
        $addCallRequest->fullname = $request->input('fullname');
        $addCallRequest->phonenumber = $request->input('phonenumber');
        $addCallRequest->emailadd = $request->input('emailadd');
        $addCallRequest->message = $request->input('messagecontent');
        $addCallRequest->status = "Pending";
        $addCallRequest->willcallback = "no";
        $addCallRequest->address = $request->input('address');
        $addCallRequest->save();

    }

    public function asignRoles(Request $request){

        $validatedData = $request->validate([
            'selectedrole' => 'required',
        ]);

        $id = $request->input('whotoasign');

        if ($request->input('selectedrole') == "SuperAdmin") {

            $asignrole = User::find($id);
            $asignrole->role = "SuperAdmin";
            $asignrole->schoolid = NULL;
            $asignrole->save();
            return back()->with('success', 'Role allocated successfully...');
            
        }else{
            

            $checkId = User::where('id', $id)->get();
    
            if (count($checkId) > 0) {
                if (is_numeric($checkId[0]['schoolid'])) {
                    return back()->with('error', 'Operation aborted. User already allocated school');
                }else{
                    if ($checkId[0]['role'] == "SuperAdmin") {
                        return back()->with('error', 'You have to revoke role before reasigning...');
                    }else{
                        $asignrole = User::find($id);
                        $asignrole->role = "SuperAdmin";
                        $asignrole->schoolid = $request->input('selectedrole');
                        $asignrole->save();
                        return back()->with('success', 'Role allocated successfully...');
                    }
                }
            }
        }



    }

    public function activateSchool(Request $request){

        $id = $request->input('schoolid');
        $status = $request->input('status');

        if ($status == "Pending") {

        $datemain = Carbon::now();
        $attDate = $datemain->toDateString();

        $periodto = $datemain->addDays(365);
        $periodtoMain = $periodto->toDateString();

        $activateschool = Addpost::find($id);
        $activateschool->status = "Approved";
        $activateschool->track = Auth::user()->id;
        $activateschool->periodfrom = $attDate;
        $activateschool->periodto = $periodtoMain;
        $activateschool->save();
        return back()->with('success', 'school approved successfully');
        }else{

        $activateschool = Addpost::find($id);
        $activateschool->status = "Pending";
        $activateschool->track = Auth::user()->id;
        $activateschool->periodfrom = "";
        $activateschool->periodto = "";
        $activateschool->save();
        
        return back()->with('success', 'school approval cancelled');
        }

    }

    public function viewSchool(){
        return view('super.viewschool');
    }
    
    public function deleteSchool(Request $request){
        
        $id = $request->input('schoolid');
        
        $deleteschool = Addpost::find($id);
        $deleteschool->delete();
        
        return back()->with('success', 'school deleted successfully');
    }

    public function messages(){
        return view('super.messages');
    }
    
    public function viewSchoolOrder($id){
        
        $addpost = Addpost::where("id", $id)->get();
        
        if(count($addpost)<1){
            return back()->with("error", "Record doesn't exist...");
        }
        
        $checkSchoolType = $addpost[0]['schooltype'];
        
        if($checkSchoolType == "Primary"){
            
            $studentCount = DB::table('addstudents')
                            ->join('users', 'users.id','=','addstudents.usernamesystem')
                            ->where(["addstudents.schoolid"=>$id, "addstudents.sessionstatus"=>1])
                            ->select('addstudents.*', 'users.firstname', 'users.middlename', 'users.lastname')->get();
            
            
            $addteachers = DB::table('addteachers') 
                         ->join('users', 'users.id','=','addteachers.systemid')
                         ->where("addteachers.schoolid", $id)
                         ->select('addteachers.*', 'users.firstname', 'users.middlename', 'users.lastname')->get();
            
            
            $addsubjects = Addsubject::where("schoolid", $id)->get();
            
            $classlists = Classlist::where("schoolid", $id)->get();
            
            
        
        $eventsdetails = Events_sec::where("schoolid", $id)->get();
        
        $allSchoolDetails = array(
            
            "addpost"=>$addpost,
            "studentCount"=>$studentCount,
            "addteachers"=>$addteachers,
            "addsubjects"=>$addsubjects,
            "classlists"=>$classlists,
            "eventsdetails"=>$eventsdetails
            
            );
            
            // return $allSchoolDetails['studentCount'];
        
            return view('super.viewschool')->with('allSchoolDetails', $allSchoolDetails);
            
        }else{
            
        $studentCount = DB::table('addstudent_secs')
                        ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
                        ->where(["addstudent_secs.schoolid"=>$id, "addstudent_secs.sessionstatus"=>0])
                        ->select('addstudent_secs.*', 'users.firstname', 'users.middlename', 'users.lastname')->get();
            
        // $studentCount = Addstudent_sec::where(["schoolid"=>$id, "sessionstatus"=>0])->get();
        
        $addteachers = DB::table('addteachers_secs') 
                         ->join('users', 'users.id','=','addteachers_secs.systemid')
                         ->where("addteachers_secs.schoolid", $id)
                         ->select('addteachers_secs.*', 'users.firstname', 'users.middlename', 'users.lastname')->get();
            
        $addsubjects = Addsubject_sec::where("schoolid", $id)->get();
            
        $classlists = Classlist_sec::where("schoolid", $id)->get();
        
        $eventsdetails = Events_sec::where("schoolid", $id)->get();
        
        $allSchoolDetails = array(
            
            "addpost"=>$addpost,
            "studentCount"=>$studentCount,
            "addteachers"=>$addteachers,
            "addsubjects"=>$addsubjects,
            "classlists"=>$classlists,
            "eventsdetails"=>$eventsdetails
            
            );
            
            // return $allSchoolDetails['eventsdetails'];
        
            return view('super.viewschool')->with('allSchoolDetails', $allSchoolDetails);
            
            
        }
        

    }
}
