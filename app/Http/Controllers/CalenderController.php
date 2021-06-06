<?php

namespace App\Http\Controllers;

use App\Addpost;
use App\CalenderModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalenderController extends Controller
{
    public function index()
    {
        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('secondary.calender.calenderreact', compact('schooldetails'));
    }

    public function postAnEvent(Request $request)
    {

        try {
            if ($request->startdate == null) {
                return response()->json(['response', 'start date is required']);
            }
    
            $addEvent = new CalenderModel();
            $addEvent->schoolid = Auth::user()->schoolid;
            $addEvent->title = $request->title;
            $addEvent->startdate = $request->startdate;
            $addEvent->starttime = $request->starttime;
            $addEvent->enddate = $request->enddate;
            $addEvent->endtime = $request->endtime;
            $addEvent->color = $request->pickedColor;
            $addEvent->save();
    
            return response()->json(['response'=>'success']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response', $th]);
        }
        
    }

    public function getAllEvents()
    {
        $getAllEvent = CalenderModel::where('schoolid', Auth::user()->schoolid)->get();

        $user = User::find(Auth::user()->id);

        $getPermission = $user->can('add event');

        return response()->json(['getAllEvent'=>$getAllEvent, 'getPermission'=>$getPermission]);
    }
}
