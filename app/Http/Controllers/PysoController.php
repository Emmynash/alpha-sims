<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Addpost;
use App\User;
use App\Classlist;
use App\Addhouses;
use App\Addsection;
use App\AddClub;
use App\Addstudent;
use App\Addmoto;
use App\AddmotoPri;
use App\Addteachers;
use App\MotoListPri;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Carbon\Carbon;
use App\Studentattendance;
use Illuminate\Support\Facades\DB;
use Validator;

class PysoController extends Controller
{
    public function index(){

        $id = Auth::user()->schoolid;

        $userschool = Addpost::where('id', $id)->get();
        $classList = Classlist::where('schoolid', $id)->get();
        $addHouses = Addhouses::where('schoolid', $id)->get();
        $addSection = Addsection::where('schoolid', $id)->get();
        $addClub = AddClub::where('schoolid', $id)->get();

        if (Auth::user()->role == "Teacher") {

            $addteachers = Addteachers::where(['schoolid' => $id, 'systemid' => Auth::user()->id])->get();

            $studentDetails = array(
                'userschool' => $userschool,
                'classList' => $classList,
                'addHouses' => $addHouses,
                'addSection' => $addSection,
                'addClub' => $addClub,
                'addteachers' => $addteachers
            );

            // return $studentDetails['addteachers'];

        } else {

            $studentDetails = array(
                'userschool' => $userschool,
                'classList' => $classList,
                'addHouses' => $addHouses,
                'addSection' => $addSection,
                'addClub' => $addClub
            );
        }

        return view('pages.moto.pycomoto')->with('studentDetails', $studentDetails);
    }

    public function motosettings()
    {

        $motosettings = MotoListPri::where('schoolid', Auth::user()->schoolid)->get();

        return view('pages.moto.motosettings', compact('motosettings'));
    }

    public function addmotomain($id)
    {
        $motosettings = MotoListPri::where('schoolid', Auth::user()->schoolid)->get();
        $getStudentDetails = User::find($id);

        return view('pages.moto.addmoto', compact('motosettings', 'getStudentDetails'));
    }

    public function addmotoPost(Request $request, $id)
    {
        $requestData = $request->except(['_token']);

        $getschoolData = Addpost::find(Auth::user()->schoolid);

        $check = AddmotoPri::where(['session'=>$getschoolData->schoolsession, 'schoolid'=>Auth::user()->schoolid, 'term'=>$getschoolData->term])->get();

        if ($check->count() > 0) {
            return back()->with('error', 'moto already added');
        }

        foreach ($requestData as $key => $value) {
            
            $explodeSelection = explode('_', $value);

            

            $addmoto = new AddmotoPri();
            $addmoto->moto_id = $explodeSelection[0];
            $addmoto->moto_score = $explodeSelection[2];
            $addmoto->student_id = $id;
            $addmoto->schoolid = Auth::user()->schoolid;
            $addmoto->session = $getschoolData->schoolsession;
            $addmoto->term = $getschoolData->term;
            $addmoto->save();

        }

        return back()->with('success', 'process was successfull');

    }

    public function addMotoPri(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $addMotoPri = new MotoListPri();
        $addMotoPri->name = $request->name;
        $addMotoPri->schoolid = Auth::user()->schoolid;
        $addMotoPri->save();

        return back()->with('success', 'added successfully');
        
    }

    public function fetchStudentData(Request $request){

        $validator = Validator::make($request->all(),[
            'studentclass' => 'required',
            'studentsection' => 'required',
            'sessionquery' => 'required',
            'studentshift' => 'required',
            'schoolterm' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $studentsCategory = DB::table('addstudents')
                            ->join('users', 'users.id', '=', 'addstudents.usernamesystem')
                            ->join('classlists', 'classlists.id', '=', 'addstudents.classid')
                            ->select('addstudents.*', 'users.firstname', 'users.middlename', 'users.lastname', 'classlists.classnamee')
                            ->where(['addstudents.classid' => $request->input('studentclass'), 
                            'addstudents.studentsection' => $request->input('studentsection'), 
                            'addstudents.schoolsession' => $request->input('sessionquery'), 
                            'addstudents.studentshift' => $request->input('studentshift')])
                            ->get();

        $addmoto = Addmoto::where(['schoolid'=>Auth::user()->schoolid, 
        'classid'=>$request->input('studentclass'), 
        'session'=> $request->input('sessionquery')])->get();

        $a = array();

        for ($i=0; $i < count($addmoto); $i++) { 

            $addmotoRegNum = $addmoto[$i]['regno'];

            array_push($a, $addmotoRegNum);
        }

        

        return response()->json([$studentsCategory, $a], 200);

    }

    public function addmoto(Request $request){

        $validator = Validator::make($request->all(),[
            'studentregnomoto' => 'required',
            'schoolsessionmoto' => 'required',
            'schooltermmoto' => 'required',
            'neatness' => 'required',
            'punctuality' => 'required',
            'reliability' => 'required',
            'politeness' => 'required',
            'honesty' => 'required',
            'selfcontrol' => 'required',
            'cooperation' => 'required',
            'attentiveness' => 'required',
            'initiative' => 'required',
            'organisation' => 'required',
            'perseverance' => 'required',
            'flexibility' => 'required',
            'handwriting' => 'required',
            'gamessport' => 'required',
            'creativity' => 'required',
            'handlingoftools' => 'required',
            'dexterity' => 'required',
            'notecopying' => 'required',
            'systemidmoto' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        // return response()->json($request->input(), 200);

        // $msg = $request->input();

        $addmoto = new Addmoto;
        $addmoto->schoolid = Auth::user()->schoolid;
        $addmoto->classid = $request->input('classidmoto');
        $addmoto->user_id = $request->input('systemidmoto');
        $addmoto->regno = $request->input('studentregnomoto');
        $addmoto->session = $request->input('schoolsessionmoto');
        $addmoto->term = $request->input('schooltermmoto');
        $addmoto->neatness = $request->input('neatness');
        $addmoto->punctuality = $request->input('punctuality');
        $addmoto->reliability = $request->input('reliability');
        $addmoto->politeness = $request->input('politeness');
        $addmoto->honesty = $request->input('honesty');
        $addmoto->selfcontrol = $request->input('selfcontrol');
        $addmoto->cooperation = $request->input('cooperation');
        $addmoto->attentivity = $request->input('attentiveness');
        $addmoto->initiative = $request->input('initiative');
        $addmoto->organizationalability = $request->input('organisation');
        $addmoto->perseverance = $request->input('perseverance');
        $addmoto->flexibity = $request->input('flexibility');
        $addmoto->handwriting = $request->input('handwriting');
        $addmoto->gamessport = $request->input('gamessport');
        $addmoto->creativity = $request->input('creativity');
        $addmoto->handlingoftools = $request->input('handlingoftools');
        $addmoto->dexterity = $request->input('dexterity');
        $addmoto->notecopying = $request->input('notecopying');
        $addmoto->save();

        $msg = "1";

        return response()->json(array('msg' => $msg), 200);
    }
}
