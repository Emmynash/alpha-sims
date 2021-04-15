<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classlist_sec;
use App\Addpdf;
use Validator;
use Auth;

class PdfController extends Controller
{
    public function index(){
        $schoolid = Auth::user()->schoolid;

        $classlists = Classlist_sec::where('schoolid', $schoolid)->get();

        $alldata = array(
            'classlists' => $classlists
        );


        return view('secondary.pdfuploaddownload')->with('alldata', $alldata);
    }

    public function fileUploadPost(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'file' => 'required|max:2000|mimes:pdf,docx,doc',
            'pdfgotclass'=>'required|string',
            'pdfsubject'=>'required|string',
            'pdftitle'=>'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        if (!$request->hasFile('file')) {
            return response()->json(['imgerr'=>'imgerr']);
        }
 
        $fileName = time().'.'.request()->file->getClientOriginalExtension();
        
        $request->file('file')->storeAs('public/pdffiles', $fileName);


        $addpdf = new Addpdf();
        $addpdf->addedbyid = Auth::user()->id;
        $addpdf->schoolid = Auth::user()->schoolid;
        $addpdf->filetitle = $request->input('pdftitle');
        $addpdf->classid = $request->input('pdfgotclass');
        $addpdf->subjectid = $request->input('pdfsubject');
        $addpdf->filename =  $fileName;
        $addpdf->save();

 
        return response()->json(['success'=>'You have successfully upload file.']);
    }
}
