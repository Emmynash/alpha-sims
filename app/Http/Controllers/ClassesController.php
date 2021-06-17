<?php

namespace App\Http\Controllers;

use App\Addpost;
use Illuminate\Http\Request;
use App\Classlist_sec;
use Illuminate\Support\Facades\Auth;

class ClassesController extends Controller
{

    private $classlist_sec;

    function __construct(Classlist_sec $classlist_sec)
    {
        $this->classlist_sec = $classlist_sec;
    }

    public function index(){

        $classesAll = $this->classlist_sec->where(['schoolid'=> Auth::user()->schoolid, 'status'=>1])->get();

        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('secondary.studentclasses.classes', compact('classesAll', 'schooldetails'));
    }
    
    public function editClassName(Request $request){
        
        $classid = $request->input('classid');
        $newclassname = $request->input('classname');
        
        $updateschoolname = $this->classlist_sec->find($classid);
        $updateschoolname->classname = $newclassname;
        $updateschoolname->save();
        
        
        return back()->with("success", "Class name updated successfully");
    }
}
