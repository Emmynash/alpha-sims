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
use Illuminate\Support\Facades\Auth;
use DB;
use Redirect;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->schoolid;
        $classList = Classlist::where('schoolid', $id)->get();
        $addsubject = Addsubject::where('schoolid', $id)->get();

        return view('pages.subjects.addsubject', compact('classList', 'addsubject'));
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

        $validatedData = $request->validate([
            'subjectcode' => 'required',
            'subjectname' => 'required',
            'selectclass' => 'required',
            'subjecttype' => 'required',
            'gradesystem' => 'required',
            'studentgroup' => 'required',
            'schoolExamsFullMarkTotal' => 'required',
            'schoolExamsFullMark' => 'required',
            'schoolca1' => 'required',
            'schoolca2' => 'required',
            'schoolca3' => 'required',
        ]);

        

            $schoolExamsFullMarkTotal = $request->input('schoolExamsFullMarkTotal');
            $searchForValue = ',';
            if( strpos($schoolExamsFullMarkTotal, $searchForValue) !== false ) {
                $splitedScore = explode(",", $schoolExamsFullMarkTotal);
                $splitedtotal = $splitedScore[0];
                $splitedpass = $splitedScore[1];
            }else{
                $splitedpass = "not";
            }

            $schoolExamsFullMark = $request->input('schoolExamsFullMark');
            $searchForValue = ',';
            if( strpos($schoolExamsFullMark, $searchForValue) !== false ) {
                $splitedExams = explode(",", $schoolExamsFullMark);
                $splitedexamsfull = $splitedExams[0];
                $splitedexamspass = $splitedExams[1];
            }else{
                $splitedpass = "not";
            }


            $schoolca1 = $request->input('schoolca1');
            $searchForValue = ',';
            if( strpos($schoolca1, $searchForValue) !== false ) {
                $splitedca1 = explode(",", $schoolca1);
                $splitedca1full = $splitedca1[0];
                $splitedca1pass = $splitedca1[1];
            }else{
                $splitedpass = "not";
            }


            $schoolca2 = $request->input('schoolca2');
            $searchForValue = ',';
            if( strpos($schoolca2, $searchForValue) !== false ) {
                $splitedca2 = explode(",", $schoolca2);
                $splitedca2full = $splitedca2[0];
                $splitedca2pass = $splitedca2[1];
            }else{
                $splitedpass = "not";
            }

            $schoolca3 = $request->input('schoolca3');
            $searchForValue = ',';
            if( strpos($schoolca3, $searchForValue) !== false ) {
                $splitedca3 = explode(",", $schoolca3);
                $splitedca3full = $splitedca3[0];
                $splitedca3pass = $splitedca3[1];
            }else{
                $splitedpass = "not";
            }




        $checkforduplicate = Addsubject::where(['schoolid' => Auth::user()->schoolid, 'subjectcode' => $request->input('subjectcode'), 'classid' => $request->input('selectclass'), 'subjectname' => $request->input('subjectname')])->get();

        if (count($checkforduplicate)>0) {
            $msg = "1";
        return response()->json(array('msg' => $msg), 200);
        }else{

            $addsubject = new Addsubject;
            $addsubject ->schoolid = Auth::user()->schoolid;
            $addsubject->classid = $request->input('selectclass');
            $addsubject->classname = $request->input('selectclass');
            $addsubject->subjectcode = strtoupper($request->input('subjectcode'));
            $addsubject->subjectname = strtoupper($request->input('subjectname'));
            $addsubject->subjecttype = $request->input('subjecttype');
            $addsubject->gradesystem = $request->input('gradesystem');
            $addsubject->totalfull = $splitedtotal;
            $addsubject->totalpass = $splitedpass;
            $addsubject->examfull = $splitedexamsfull;
            $addsubject->exampass = $splitedexamspass;
            $addsubject->ca1full = $splitedca1full;
            $addsubject->ca1pass = $splitedca1pass;
            $addsubject->ca2full = $splitedca2full;
            $addsubject->ca2pass = $splitedca2pass;
            $addsubject->ca3full = $splitedca3full;
            $addsubject->ca3pass = $splitedca3pass;
            $addsubject->save();
    
            $msg = '0';
            return response()->json(array('msg' => $msg), 200);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function subjectList(){

        $id = Auth::user()->schoolid;
        $classList = Classlist::where('schoolid', $id)->get();
        $addsubject = DB::table('addsubjects')
                    ->join('classlists', 'classlists.id', '=', 'addsubjects.classid')
                    ->select('addsubjects.*', 'classlists.classnamee')
                    ->where('addsubjects.schoolid', $id)->paginate(10);

        return view('pages.subjects.viewsubject', compact('addsubject', 'classList'));
    }

    public function viewClass(){

        $classList = Classlist::where('schoolid', Auth::user()->schoolid)->get();

        return view('pages.classes.viewclasses', compact('classList'));
    }

    public function deleteSubject(Request $request){

        $entryid = $request->input('subjectid');    

        $deletemarks = Addsubject::find($entryid);
        $deletemarks->delete();

        return back()->with('success', 'record deleted successfully');

    }

    public function updateSubject(Request $request){
        $validatedData = $request->validate([
            'updateclass' => 'required',
            'updatesubjectcode' => 'required',
            'updatesubjectname' => 'required',
            'subjectid' => 'required'
        ]);

        $updatesubject = Addsubject::find($request->input('subjectid'));
        $updatesubject->subjectcode = $request->input('updatesubjectcode');
        $updatesubject->subjectname = $request->input('updatesubjectname');
        $updatesubject->classid = $request->input('updateclass');
        $updatesubject->save(); 

        return back()->with('success', 'subject updated...');
    }
}
