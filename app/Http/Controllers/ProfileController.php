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
use App\Addsubject;
use Auth;
use DB;
use Redirect;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($student_id)
    {
        $id = Auth::user()->schoolid;

        $userschool = Addpost::where('id', $id)->get();
        $classList = Classlist::where('schoolid', $id)->get();
        $addHouses = Addhouses::where('schoolid', $id)->get();
        $addSection = Addsection::where('schoolid', $id)->get();
        $addClub = AddClub::where('schoolid', $id)->get();
        $addsubject = Addsubject::where('schoolid', $id)->get();
        $addstudentprocess = DB::table('addstudents')
        ->join('users', 'users.id', '=', 'addstudents.usernamesystem')
        ->join('classlists', 'classlists.id', '=', 'addstudents.classid')
        ->join('addposts', 'addposts.id', '=', 'addstudents.schoolid')
        ->select('addstudents.*', 'users.firstname', 'users.middlename', 'users.lastname', 'users.id as userid', 'classlists.classnamee', 'addposts.schoolname', 'users.profileimg', 'users.role')
        ->where('addstudents.id', $student_id)->get();

        

        $idf = $addstudentprocess->toJson();
        $addstudent = json_decode($idf, true)[0];

        // return $addstudent;

        $studentDetails = array(
            'userschool' => $userschool,
            'classList' => $classList,
            'addHouses' => $addHouses,
            'addSection' => $addSection,
            'addClub' => $addClub,
            'addsubject' => $addsubject,
            'addstudent' => $addstudent,
            'addstudentprocess' => $addstudentprocess
        );

        return view('pages.profile')->with('studentDetails', $studentDetails);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
