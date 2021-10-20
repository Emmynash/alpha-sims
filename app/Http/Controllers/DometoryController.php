<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dometory;
use App\RoomsModel;
use Auth;
use Validator;
use App\AddStudentToHostel;
use App\Addstudent_sec;
use App\User;
use DB;


class DometoryController extends Controller
{
    public function index(){

        $allhostels = Dometory::where('schoolid', Auth::user()->schoolid)->get();

        return view('secondary/dometory/index_dom')->with('allhostels', $allhostels);
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    function show($id){

        $fetchhostel = Dometory::find($id);

        // return $fetchhostel;

        if ($fetchhostel == NULL) {
            return back();
        }

        $fetchhosteldetails = RoomsModel::where(['hostelid'=>$id, 'schoolid'=>Auth::user()->schoolid])->get();

        $allarrayhostels = array(
            'fetchhostel'=>$fetchhostel,
            'fetchhosteldetails'=>$fetchhosteldetails
        );

        // return $allarrayhostels['fetchhosteldetails'];

        return view('secondary/dometory/singlehostel')->with('allarrayhostels', $allarrayhostels);

    }

    public function addHostel(Request $request){
       
        $validatedData = $request->validate([
            'hostelname' => 'required',
        ]);

        $allhostels = Dometory::where('hostelname', $request->input('hostelname'))->get();

        if (count($allhostels) > 0) {
            return back()->with('error', 'Hostel already added');
        }

        $dometory = new Dometory();
        $dometory->schoolid= Auth::user()->schoolid;
        $dometory->hostelname= $request->input('hostelname');
        $dometory->roomcount= "0";
        $dometory->studentcount= "0";
        $dometory->save();

        $updateroomcount = Dometory::where('schoolid', Auth::user()->schoolid)->get();

        if (count($updateroomcount) > 0) {
            for ($i=0; $i < count($updateroomcount); $i++) { 
                $hostelid = $updateroomcount[$i]['id'];

                $updatecountroom = RoomsModel::where('hostelid', $hostelid)->get();
                $updateStudentcount = AddStudentToHostel::where('hostelid', $hostelid)->get();
    
                $undatecountroom = Dometory::find($hostelid);
                $undatecountroom->roomcount= count($updatecountroom);
                $undatecountroom->studentcount = count($updateStudentcount);
                $undatecountroom->save();
            }

        }

        return back()->with(['success'=> 'Hostel added successfully. Please proceed to adding rooms']);
    }

    public function addHostels(Request $request){

        $validatedData = $request->validate([
            'roomname' => 'required',
            'roomcapacity' => 'required',
            'hostelid' => 'required'
        ]);

            $addhostels = new RoomsModel();
            $addhostels->roomname = $request->input('roomname');
            $addhostels->roomcapacity = $request->input('roomcapacity');
            $addhostels->roomcount = "0";
            $addhostels->schoolid = Auth::user()->schoolid;
            $addhostels->hostelid = $request->input('hostelid');
            $addhostels->save();


            $updateroomcount = Dometory::where('schoolid', Auth::user()->schoolid)->get();

            if (count($updateroomcount) > 0) {
                for ($i=0; $i < count($updateroomcount); $i++) { 
                    $hostelid = $updateroomcount[$i]['id'];
    
                    $updatecountroom = RoomsModel::where('hostelid', $hostelid)->get();
                    $updateStudentcount = AddStudentToHostel::where('hostelid', $hostelid)->get();
        
                    $undatecountroom = Dometory::find($hostelid);
                    $undatecountroom->roomcount= count($updatecountroom);
                    $undatecountroom->studentcount = count($updateStudentcount);
                    $undatecountroom->save();
                }
    
            }
            
            
        return back()->with('success', 'room added successfully');


    }

    public function addStudentToHostel(Request $request){
        // return $request->input();

        $validator = Validator::make($request->all(),[
            'addstudentstorooms'=>'required|string',
            'hostelidadd'=>'required|string',
            'roomidhostel'=>'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $idsorid = $request->input('addstudentstorooms');

        $explodedids = explode(',', $idsorid);

        $invalidIdArray = array();

        $alreadyexist = array();

        $roomfull = array();

        for ($i=0; $i < count($explodedids); $i++) { 

            $regno = $explodedids[$i];

            $addstudent_sec = Addstudent_sec::where(['id'=>$regno, 'schoolid'=> Auth::user()->schoolid])->get();

            if (count($addstudent_sec) > 0) {

                $addStudentToHostel = AddStudentToHostel::where(['regno'=>$regno, 'schoolid'=>Auth::user()->schoolid])->get();

                if (count($addStudentToHostel) > 0) {

                    array_push($alreadyexist, $regno);

                }else{
                    $systemid = $addstudent_sec['0']['usernamesystem'];

                    $userRoleCheck = User::where('id', $systemid)->get();

                    if ($userRoleCheck[0]['role'] == "Student") {

                        $checkroomnumber = RoomsModel::where('id',$request->input('roomidhostel'))->get();

                        $currentcount = $checkroomnumber[0]['roomcount'];
                        $roomcapacity = $checkroomnumber[0]['roomcapacity'];

                        if ($currentcount < $roomcapacity) {
                            $addstudenttohostel = new AddStudentToHostel();
                            $addstudenttohostel->schoolid = Auth::user()->schoolid;
                            $addstudenttohostel->hostelid = $request->input('hostelidadd');
                            $addstudenttohostel->systemid = $systemid;
                            $addstudenttohostel->roomid = $request->input('roomidhostel');
                            $addstudenttohostel->regno = $regno;
                            $addstudenttohostel->save();
                        }else{
                            array_push($roomfull, $regno);
                        }

                    }else {
                        array_push($invalidIdArray, $regno);
                    }
                }
            }else{
                array_push($invalidIdArray, $regno);
            }
        }

        $hostelcount = AddStudentToHostel::where(['schoolid'=>Auth::user()->schoolid, 'hostelid'=>$request->input('hostelidadd'), 'roomid'=>$request->input('roomidhostel')])->get();

        $updateroomcount = RoomsModel::find($request->input('roomidhostel'));
        $updateroomcount->roomcount = count($hostelcount);
        $updateroomcount->save();


        $updateroomcount = Dometory::where('schoolid', Auth::user()->schoolid)->get();

        if (count($updateroomcount) > 0) {
            for ($i=0; $i < count($updateroomcount); $i++) { 
                $hostelid = $updateroomcount[$i]['id'];

                $updatecountroom = RoomsModel::where('hostelid', $hostelid)->get();
                $updateStudentcount = AddStudentToHostel::where('hostelid', $hostelid)->get();
    
                $undatecountroom = Dometory::find($hostelid);
                $undatecountroom->roomcount= count($updatecountroom);
                $undatecountroom->studentcount = count($updateStudentcount);
                $undatecountroom->save();
            }

        }


        return response()->json(['success'=>"success", 'invalid'=>$invalidIdArray, 'exist'=>$alreadyexist, 'roomfull'=>$roomfull]);
    }

    public function fetchAllStudentInARoom(Request $request){

        $validator = Validator::make($request->all(),[
            'roomid'=>'required|string',
            'hostelid'=>'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $hostelid = $request->input('hostelid');
        $roomid = $request->input('roomid');

        // $getclassid = Addstudent_sec::where('')->get();

        $studentinahostel = DB::table('add_student_to_hostels')
                            ->join('users', 'users.id','=','add_student_to_hostels.systemid')
                            ->select('add_student_to_hostels.*', 'users.firstname', 'users.middlename', 'users.lastname', 'users.profileimg')
                            ->where(['add_student_to_hostels.roomid'=>$hostelid, 'add_student_to_hostels.roomid'=>$roomid])->get();


    return response()->json(['success'=>$studentinahostel]);

    }

    public function deleteRoomMate(Request $request){

        $validator = Validator::make($request->all(),[
            'studenthostelid'=>'required|string',
            'roomid'=>'required|string',
            'hostelid'=>'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $idtodelete = $request->input('studenthostelid');

        $deleteStudent = AddStudentToHostel::find($idtodelete);
        $deleteStudent->delete();

        $hostelcount = AddStudentToHostel::where(['schoolid'=>Auth::user()->schoolid, 'hostelid'=>$request->input('hostelid'), 'roomid'=>$request->input('roomid')])->get();

        $updateroomcount = RoomsModel::find($request->input('roomid'));
        $updateroomcount->roomcount = count($hostelcount);
        $updateroomcount->save();

        $updateroomcount = Dometory::where('schoolid', Auth::user()->schoolid)->get();

        if (count($updateroomcount) > 0) {
            for ($i=0; $i < count($updateroomcount); $i++) { 
                $hostelid = $updateroomcount[$i]['id'];

                $updatecountroom = RoomsModel::where('hostelid', $hostelid)->get();
                $updateStudentcount = AddStudentToHostel::where('hostelid', $hostelid)->get();
    
                $undatecountroom = Dometory::find($hostelid);
                $undatecountroom->roomcount= count($updatecountroom);
                $undatecountroom->studentcount = count($updateStudentcount);
                $undatecountroom->save();
            }

        }

        return response()->json(['success'=>$idtodelete]);
    }

    public function deleteRoom(Request $request){

        $validatedData = $request->validate([
            'roomidvalue' => 'required',
        ]);

        $roomid = $request->input('roomidvalue');

        $addstudettohostel = AddStudentToHostel::where('roomid', $roomid)->get();

        if (count($addstudettohostel) > 0) {

            $roommatearray = array();

            for ($i=0; $i < count($addstudettohostel); $i++) { 
                $regno = $addstudettohostel[$i]['id'];
                $deleteRoomMate = AddStudentToHostel::find($regno);
                $deleteRoomMate->delete();
            }

            $deleteRoomEntry = RoomsModel::find($roomid);
            $deleteRoomEntry->delete();
        }else {
            $deleteRoomEntry = RoomsModel::find($roomid);
            $deleteRoomEntry->delete();
        }

        $updateroomcount = Dometory::where('schoolid', Auth::user()->schoolid)->get();

        if (count($updateroomcount) > 0) {
            for ($i=0; $i < count($updateroomcount); $i++) { 
                $hostelid = $updateroomcount[$i]['id'];

                $updatecountroom = RoomsModel::where('hostelid', $hostelid)->get();
                $updateStudentcount = AddStudentToHostel::where('hostelid', $hostelid)->get();
    
                $undatecountroom = Dometory::find($hostelid);
                $undatecountroom->roomcount= count($updatecountroom);
                $undatecountroom->studentcount = count($updateStudentcount);
                $undatecountroom->save();
            }

        }

        return back()->with('success', 'Room deleted successfully');
    }

    public function deleteHostel(Request $request){
        $validatedData = $request->validate([
            'hostelidDelete' => 'required',
        ]);

        // return $roomsModel = RoomsModel::where('hostelid', $request->input('hostelidDelete'))->get();

        //delete hostel first
        $dometory = Dometory::find($request->input('hostelidDelete'));
        $dometory->delete();
        //delete rooms
        $roomsModel = RoomsModel::where('hostelid', $request->input('hostelidDelete'))->get();


        if (count($roomsModel) > 0) {
            for ($i=0; $i < count($roomsModel); $i++) { 
                $roomiddelete = $roomsModel[$i]['id'];
                $roomEachId = RoomsModel::find($roomiddelete);
                $roomEachId->delete();
            }
        }

        $addhostelstudent = AddStudentToHostel::where('hostelid', $request->input('hostelidDelete'))->get();

        if (count($addhostelstudent) > 0) {
            for ($i=0; $i < count($addhostelstudent); $i++) { 
                $studentidtoremove = $addhostelstudent[$i]['id'];

                $studentDelete = AddStudentToHostel::find($studentidtoremove);
                $studentDelete->delete();
            }
        }

        $updateroomcount = Dometory::where('schoolid', Auth::user()->schoolid)->get();

        if (count($updateroomcount) > 0) {
            for ($i=0; $i < count($updateroomcount); $i++) { 
                $hostelid = $updateroomcount[$i]['id'];

                $updatecountroom = RoomsModel::where('hostelid', $hostelid)->get();
                $updateStudentcount = AddStudentToHostel::where('hostelid', $hostelid)->get();
    
                $undatecountroom = Dometory::find($hostelid);
                $undatecountroom->roomcount= count($updatecountroom);
                $undatecountroom->studentcount = count($updateStudentcount);
                $undatecountroom->save();
            }

        }

        return back()->with('success', 'hostel delete request successfull');
        
    }
}
