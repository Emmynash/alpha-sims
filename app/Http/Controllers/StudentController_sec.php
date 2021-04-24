<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Addstudent_sec;
use App\Classlist_sec;
use App\Addhouse_sec;
use App\Addsection_sec;
use App\Addclub_sec;
use App\Addpost;
use App\Addstudent;
use App\AmountTable;
use App\FeesInvoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class StudentController_sec extends Controller
{

    private $user;
    private $addstudent_sec;
    private $classlist_sec;
    private $addhouse_sec;
    private $addsection_sec;
    private $addclub_sec;
    private $addpost;

    function __construct(User $user, Addstudent_sec $addstudent_sec, Classlist_sec $classlist_sec, Addhouse_sec $addhouse_sec, Addsection_sec $addsection_sec, Addclub_sec $addclub_sec, Addpost $addpost)
    {
        $this->user = $user;
        $this->addstudent_sec = $addstudent_sec;
        $this->classlist_sec = $classlist_sec;
        $this->addhouse_sec = $addhouse_sec;
        $this->addsection_sec = $addsection_sec;
        $this->addclub_sec = $addclub_sec;
        $this->addpost = $addpost;

        
    }

    public function index(){

        $addschool = Addpost::where('id', Auth::user()->schoolid)->first();

        return view('secondary.studentprocess.addstudent_sec', compact('addschool'));
    }

    public function viewStudentbyClass(){

        $addschool = Addpost::where('id', Auth::user()->schoolid)->first();

        return view('secondary.studentprocess.viewstudent_sec', compact('addschool'));
    }

    public function confirmStudentRegNumber(Request $request){

        $validator = Validator::make($request->all(),[
            'allocatedclass' => 'required|string',
            'allocatedsection' => 'required|string',
            'allocatedshift' => 'required|string',
            'currentsession' => 'required|string',
            'systemnumber' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $userdetailfetch = $this->user->where('id', $request->input('systemnumber'))->get();

        $addstudent_sec = $this->addstudent_sec->where('usernamesystem', $request->input('systemnumber'))->get();

        if (count($userdetailfetch) > 0) {

            if (count($addstudent_sec) > 0) {
                return response()->json(['exist'=>'noaccount']);
            }else{
                return response()->json(['create'=>$userdetailfetch]);
            }
            
        }else{
            return response()->json(['noaccount'=>'noaccount']);
        }

        return response()->json($userdetailfetch, 200);
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'studentclassallocated' => 'required',
            'schoolsession' => 'required',
            'studentsectionallocated' => 'required',
            'studenttype' => 'required',
            'studentsystemnumber' => 'required',
            'studentgender' => 'required',
            'studentreligion' => 'required',
            'fathersname' => 'required',
            'fathersphonenumber' => 'required|regex:/(0)[0-9]{10}/',
            'mothersname' => 'required',
            'mothersphonenumber' => 'required|regex:/(0)[0-9]{10}/',
            'dateofbirth' => 'required',
            'bloodgroup' => 'required',
            'studenthouse' => 'required',
            'nationality' => 'required',
            'studentclub' => 'required',
            'studentaddress_sec' => 'required'
        ]);
        
        $checkduplicate = $this->addstudent_sec->where('usernamesystem', $request->input('studentsystemnumber'))->get();

        if (count($checkduplicate) > 0) {
            return back()->with('error', 'Student already added');
        }


        $rollNumberProcess = $this->addstudent_sec->where(['schoolid' => Auth::user()->schoolid, 'classid' => $request->input('studentclassallocated')])->get();


            $a = array();

            for ($i=0; $i < count($rollNumberProcess); $i++) {
                
                $rollnumber = $rollNumberProcess[$i]['renumberschoolnew'];
                array_push($a, $rollnumber);
            }

            if (count($a) > 0) {
                $maxrollnum = max($a);
                $newrolnumber = $maxrollnum + 1;
            }else{
                $newrolnumber = '1';
            }


        $Addstudent = new Addstudent_sec();
        $Addstudent->classid = $request->input('studentclassallocated');
        $Addstudent->schoolid = Auth::user()->schoolid;
        $Addstudent->usernamesystem = $request->input('studentsystemnumber');
        $Addstudent->renumberschoolnew = $newrolnumber;
        $Addstudent->nationality = $request->input('nationality');
        $Addstudent->studentsection = $request->input('studentsectionallocated');
        $Addstudent->schoolsession = $request->input('schoolsession');
        $Addstudent->gender = $request->input('studentgender');
        $Addstudent->studenthouse = $request->input('studenthouse');
        $Addstudent->studentreligion = $request->input('studentreligion');
        $Addstudent->bloodgroup = $request->input('bloodgroup');
        $Addstudent->studentclub = $request->input('studentclub');
        $Addstudent->studentshift = $request->input('studenttype');
        $Addstudent->studentfathername = $request->input('fathersname');
        $Addstudent->studentfathernumber = $request->input('fathersphonenumber');
        $Addstudent->studentmothersname = $request->input('mothersname');
        $Addstudent->studentmothersnumber = $request->input('mothersphonenumber');
        $Addstudent->studentpresenthomeaddress = $request->input('studentaddress_sec');
        $Addstudent->studentpermanenthomeaddress = $request->input('studentaddress_sec');
        $Addstudent->dateOfBirth = $request->input('dateofbirth');
        $Addstudent->sessionstatus = 0;
        $Addstudent->save();

        //asign student role

        $userId = $this->user->where('id', $request->input('studentsystemnumber'))->first();
        $userIdFinal = $userId->id;

        //update schoolId field
        $schoolIdUpdate = $this->user->find($userIdFinal);
        $schoolIdUpdate->schoolid = Auth::user()->schoolid;;
        $schoolIdUpdate->role = "Student";
        $schoolIdUpdate->save();

        $user = User::find($request->input('studentsystemnumber'));

        $user->assignRole('Student');

        return back()->with('success', 'Student added successfully');
    }

    public function viewStudentSingleClass(Request $request){

        $validator = Validator::make($request->all(),[
            'classessingle' => 'required|string',
            'schoolsessionsingle' => 'required|string',
            'sectionsingle' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $fetchStudentsClass = DB::table('addstudent_secs')
        ->join('classlist_secs','classlist_secs.id','=', 'addstudent_secs.classid')
        ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
        ->select('addstudent_secs.*', 'classlist_secs.classname', 'users.firstname', 'users.middlename', 'users.lastname')
        ->where(['addstudent_secs.classid'=> $request->input('classessingle'), 'addstudent_secs.schoolid'=> Auth::user()->schoolid, 'addstudent_secs.schoolsession'=>$request->input('schoolsessionsingle'), 'addstudent_secs.studentsection'=>$request->input('sectionsingle')])->get();

        return response()->json($fetchStudentsClass, 200);
    }
    
    public function addStudentModal(Request $request){
        
        $validatedData = $request->validate([
            'modalfirstname' => 'required',
            'modalmiddlename' => 'required',
            'modallastname' => 'required',
            'studentgendermodal' => 'required',
            'studentreligionmodal' => 'required',
            'dateofbirthmodal' => 'required',
            'bloodgroupmodal' => 'required',
            'studenthousemodal' => 'required',
            'nationalitymodal' => 'required|regex:/(0)[0-9]{10}/',
            'studentclubmodal' => 'required',
            'fathersnamemodal' => 'required|regex:/(0)[0-9]{10}/',
            'fathersphonenumbermodal' => 'required',
            'mothersnamemodal' => 'required',
            'mothersphonenumbermodal' => 'required',
            'studentaddress_secmodal' => 'required',
        ]); 
    }

    public function feePayment()
    {

        $schooldetails = Addpost::find(Auth::user()->schoolid);

        if ($schooldetails->schooltype == "Primary") {

            $studentDetails = Addstudent::where('usernamesystem', Auth::user()->id)->first();

            $schoolData = AmountTable::join('payment_categories', 'payment_categories.id','=','amount_tables.payment_category_id')
                                ->where(['amount_tables.class_id'=>$studentDetails->classid, 'amount_tables.school_id'=>Auth::user()->schoolid])
                                ->select('amount_tables.*', 'payment_categories.categoryname')->get();
    
            
            $sumAmount = AmountTable::join('payment_categories', 'payment_categories.id','=','amount_tables.payment_category_id')
                        ->where(['amount_tables.class_id'=>$studentDetails->classid, 'amount_tables.school_id'=>Auth::user()->schoolid])
                        ->select('amount_tables.*', 'payment_categories.categoryname')->sum('amount');
    
            return view('secondary.student.fees', compact('schoolData', 'sumAmount', 'schooldetails'));
            
        }else{

           return $studentDetails = Addstudent_sec::where('usernamesystem', Auth::user()->id)->first();

            $schoolData = AmountTable::join('payment_categories', 'payment_categories.id','=','amount_tables.payment_category_id')
                                ->where(['amount_tables.class_id'=>$studentDetails->classid, 'amount_tables.school_id'=>Auth::user()->schoolid])
                                ->select('amount_tables.*', 'payment_categories.categoryname')->get();
    
            
            $sumAmount = AmountTable::join('payment_categories', 'payment_categories.id','=','amount_tables.payment_category_id')
                        ->where(['amount_tables.class_id'=>$studentDetails->classid, 'amount_tables.school_id'=>Auth::user()->schoolid])
                        ->select('amount_tables.*', 'payment_categories.categoryname')->sum('amount');
    
            return view('secondary.student.fees', compact('schoolData', 'sumAmount', 'schooldetails'));

        }


    }

    public function paymentHistory()
    {

        $schooldetails = Addpost::find(Auth::user()->schoolid);

        if ($schooldetails->schooltype == "Primary") {

            $feeInvoices = FeesInvoice::
            join('classlists', 'classlists.id','=','fees_invoices.classid')
                    ->select('fees_invoices.*', 'classlists.classnamee as classname')
                    ->where(['system_id'=>Auth::user()->id])->get();

            return view('secondary.student.transaction', compact('feeInvoices', 'schooldetails'));
            
        }else{
            
            $feeInvoices = FeesInvoice::
            join('classlist_secs', 'classlist_secs.id','=','fees_invoices.classid')
                    ->select('fees_invoices.*', 'classlist_secs.classname')
                    ->where(['system_id'=>Auth::user()->id])->get();

            return view('secondary.student.transaction', compact('feeInvoices', 'schooldetails'));
        }


    }
}
