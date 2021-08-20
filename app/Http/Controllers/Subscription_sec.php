<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Addstudent_sec;
use App\Addstudent;
use App\Addpost;
use App\TransferSub;
use Illuminate\Support\Facades\Auth;
use App\SubHistory;

class Subscription_sec extends Controller
{
    public function index(){

        $addschool = Addpost::where('id', Auth::user()->schoolid)->get();


        if ($addschool[0]->schooltype == "Primary") {

           $getStudentCount = Addstudent::where(['sessionstatus'=> '1', 'schoolid'=>Auth::user()->schoolid])->get();

            $studentCountTotal = count($getStudentCount);
            $amountFinal = $studentCountTotal * 500;
            $amountPerStudent = 500;

            $subHistory = SubHistory::where(['schoolid'=> Auth::user()->schoolid, 'session'=>$addschool[0]->schoolsession])->sum('student_count');

            $difStudentCount = 0;

            if ($studentCountTotal == $subHistory) {

                $difStudentCount = 0;

            }else {

                $difStudentCount = abs($studentCountTotal - $subHistory);

            }


            $historySub = SubHistory::where('schoolid', Auth::user()->schoolid)->get();


            return view('subscription_sec.index')->with(['getStudentCount'=> $getStudentCount, 'amountFinal'=> $amountFinal, 'addschool'=>$addschool, 'amountPerStudent'=>$amountPerStudent, 'historySub'=>$historySub, 'difStudentCount'=>$difStudentCount]);

        }else {
            $getStudentCount = Addstudent_sec::where(['sessionstatus'=> '0', 'schoolid'=>Auth::user()->schoolid])->get();

            $studentCountTotal = count($getStudentCount);
            $amountFinal = $studentCountTotal * 500;
            $amountPerStudent = 500;

            $subHistory = SubHistory::where(['schoolid'=> Auth::user()->schoolid, 'session'=>$addschool[0]->schoolsession])->sum('student_count');

            $difStudentCount = 0;

            if ($studentCountTotal == $subHistory) {

                $difStudentCount = 0;

            }else {

                $difStudentCount = abs($studentCountTotal - $subHistory);

            }


            $historySub = SubHistory::where('schoolid', Auth::user()->schoolid)->get();


            return view('subscription_sec.index')->with(['getStudentCount'=> $getStudentCount, 'amountFinal'=> $amountFinal, 'addschool'=>$addschool, 'amountPerStudent'=>$amountPerStudent, 'historySub'=>$historySub, 'difStudentCount'=>$difStudentCount]);
        }



        
    }

    public function pay_sub(Request $request){

        return $request->input();

    }

    public function pay_sub_transfer(Request $request){

        $validatedData = $request->validate([
            'proofofpayment' => 'image|max:200|mimes:jpeg,png,jpg|required',
            'accountname' => 'required',
        ]);

        if ($request->hasFile('proofofpayment')) {

            //get file name with extension
            $profilepixExt = $request->file('proofofpayment')->getClientOriginalName();

            //get just file names
            $fileNameProfile = pathinfo($profilepixExt, PATHINFO_FILENAME);

            //get just extensions
            $extensionProfilepix = $request->file('proofofpayment')->getClientOriginalExtension();

            //file name to store
            $profileFinal = $fileNameProfile."_".time().$extensionProfilepix;

            //upload image
            $pathProfile = $request->file('proofofpayment')->storeAs('public/schimages', $profileFinal);

        }

        $transferData = new TransferSub();
        $transferData->schoolid = Auth::user()->schoolid;
        $transferData->proofofpayment = $profileFinal;
        $transferData->accountname = $request->input('accountname');
        $transferData->track = Auth::user()->id;
        $transferData->amounttopay = $request->input('amounttopay');
        $transferData->save(); 

        return back()->with('success', 'Request submited successfully');

    }
}
