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
use App\Addteachers;
use Auth;
use Redirect;
use Carbon\Carbon;
use App\TeacherAttendance;
use Validator;

class PromotionController extends Controller
{
    public function index(){

        $id = Auth::user()->schoolid;

        $userschool = Addpost::where('id', $id)->get();
        $classList = Classlist::where('schoolid', $id)->get();
        $addHouses = Addhouses::where('schoolid', $id)->get();
        $addSection = Addsection::where('schoolid', $id)->get();
        $addClub = AddClub::where('schoolid', $id)->get();

        $studentDetails = array(
            'userschool' => $userschool,
            'classList' => $classList,
            'addHouses' => $addHouses,
            'addSection' => $addSection,
            'addClub' => $addClub
        );

        return view('pages.promotion')->with('studentDetails', $studentDetails);
    }

    public function fetchstudentsforpromotion(Request $request){

        $validator = Validator::make($request->all(),[
            'studentclass' => 'required',
            'studentsection' => 'required',
            'studentshift' => 'required',
            'session' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }else{
            $addstudent = Addstudent::where(['classid' => $request->input('studentclass'), 'schoolid' => Auth::user()->schoolid, 'studentsection' => $request->input('studentsection'), 'studentshift' => $request->input('studentshift'), 'schoolsession' => $request->input('session')])->get();

            $studentregnumarray = array();

            for ($i=0; $i < count($addstudent); $i++) { 
                $promoteRegNum = $addstudent[$i]['id'];
                array_push($studentregnumarray, $promoteRegNum);
            }

            return response()->json([$addstudent, $studentregnumarray], 200);
        }
    }

    public function promotemain(Request $request){

        $validator = Validator::make($request->all(),[
            'promotionclass' => 'required',
            'promotionsection' => 'required',
            'promotionshift' => 'required',
            'protionsession' => 'required',
            'promotionid' => 'required',
            'initialsession' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'An error occured. Check that all fields are entered correctly');
        }

        $initialsession = $request->input('initialsession');

        $initialsessionyeararray = explode('/', $request->input('initialsession'));
        $protionsessionarray = explode('/', $request->input('protionsession'));

        if (count($initialsessionyeararray) < 2) {
            return back()->with('error', 'invalid session');
        }

        if (count($protionsessionarray) < 2) {
            return back()->with('error', 'invalid session.');
        }

        if ($protionsessionarray[1] < $initialsessionyeararray[1]) {
            return back()->with('error', 'operation not suported. ');
        }

        $idsArray = explode(',', $request->input('promotionid'));

        for ($i=0; $i < count($idsArray); $i++) { 
            
            $promotestudent = Addstudent::find($idsArray[$i]);
            $promotestudent->classid = $request->input('promotionclass');
            $promotestudent->studentsection = $request->input('promotionsection');
            $promotestudent->schoolsession = $request->input('protionsession');
            $promotestudent->studentshift = $request->input('promotionshift');
            $promotestudent->save();
        }

        // return $request->input();

        
        return back()->with('success', 'Promotion successfully');

    }
}
