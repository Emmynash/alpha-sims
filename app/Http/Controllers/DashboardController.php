<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Addpost;
use App\User;
use App\Addfeedback;
use App\Events_sec;
use App\Services\Imageupload;
use Illuminate\Support\Facades\Auth;
use App\Services\SchoolService;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{
    public function addschool()
    {


        $id = Auth::user()->schoolid;
        $userschool = Addpost::where('id', $id)->first();

        if ($userschool->schooltype == "Primary") {
            $classList = User::where('id', $id)->get();
            $addHouses = User::where('id', $id)->get();
            $addSection = User::where('id', $id)->get();
            $addClub = User::where('id', $id)->get();
            // $message = Message::where(['schoolid'=> Auth::user()->schoolid, 'senderid'=>Auth::user()->id])->get();

            $studentDetails = array(
                'userschool' => $userschool,
                'classList' => $classList,
                'addHouses' => $addHouses,
                'addSection' => $addSection,
                'addClub' => $addClub,
            );
            return view('pages.addschool', compact('userschool'));
        }
        return view('secondary.setupschool.addschool_sec', compact('userschool'));
    }

    public function store(Request $request, SchoolService $schoolService)
    {

        $validatedData = $request->validate([
            'schoolname' => 'required',
            'schoolemail' => 'required',
            'mobilenumber' => 'required',
            'schoolwebsite' => 'required',
            'dateestablished' => 'required',
            'schooladdress' => 'required',
            'schooltypeselect' => 'required',
            'schoolstate' => 'required'
        ]);

        $schoolcheck = Addpost::where(['mobilenumber' => $request->input('mobilenumber')])->get();
        if (count($schoolcheck) > 0) {
            return back()->with('error', 'Phone number already exist. Please add unique number for each school.');
        }
        $addSchoolRequest = $schoolService->addSchools($request);
        if ($addSchoolRequest == "success") {
            return Redirect::back()->with('success', 'application submited successfully');
        } else {
            return Redirect::back()->with('error', 'application failed');
        }
    }

    public function feedBack()
    {
        return view('secondary.feedback');
    }

    public function addFeedBack(Request $request)
    {

        $validatedData = $request->validate([
            'issueselected' => 'required',
            'accounttype' => 'required',
            'content' => 'required',
        ]);


        $addfeedback = new Addfeedback();
        $addfeedback->accounttype = $request->input('accounttype');
        $addfeedback->systemnum = Auth::user()->id;
        $addfeedback->schoolid = Auth::user()->schoolid;
        $addfeedback->content = $request->input('content');
        $addfeedback->subject = $request->input('issueselected');
        $addfeedback->attachment = $request->input('attachment');
        $addfeedback->save();
        return back()->with("success", "Feedback submited successfully. We are now reviewing your request...");
    }

    public function feedBackAdmin()
    {

        $addfeedback = Addfeedback::all();

        $allfeedbackdetails = array(
            "addfeedback" => $addfeedback
        );

        return view('super.feedback')->with("allfeedbackdetails", $allfeedbackdetails);
    }

    public function addEventAll(Request $request)
    {
        $validatedData = $request->validate([
            'eventsubject' => 'required',
            'eventdetails' => 'required',
            'eventstartdate' => 'required',
            'eventenddate' => 'required'
        ]);

        $neweventadd = new Events_sec();
        $neweventadd->schoolid = Auth::user()->schoolid;
        $neweventadd->eventtitle = $request->input('eventsubject');
        $neweventadd->eventdetails =  $request->input('eventdetails');
        $neweventadd->eventstart =  $request->input('eventstartdate');
        $neweventadd->eventend =  $request->input('eventenddate');
        $neweventadd->status = "Active";
        $neweventadd->save();

        return back()->with("success", "Event added successfully...");
    }

    public function updatelogosig(Imageupload $imageUpload, Request $request)
    {

        $rules = [
            'image' => 'image|max:2048|mimes:jpeg,png,jpg|required',
            'key' => 'required',
        ];
    
        $customMessages = [
            'required' => 'The :attribute field can not be blank.',
            'mimes' => 'file must be an image(jpeg, png, jpg)',
            'max' => 'file must not be greater than 2mb'
        ];
    
        $this->validate($request, $rules, $customMessages);

        try {
            $uploadRes = $imageUpload->imageUpload($request);
            if ($uploadRes == "Success") {
                return back()->with('success', "Process was successful");
            } else {
                return back()->with('error', "Process failed");
            }
        } catch (\Throwable $th) {
            return back()->with('error', "Process failed");
        }
    }
}
