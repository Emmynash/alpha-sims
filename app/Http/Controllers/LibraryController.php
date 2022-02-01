<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Addbooks;
use App\Addlibcategory;
use App\Addstudent_sec;
use Carbon\Carbon;
use App\Addpost;
use App\Addborrow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LibraryController extends Controller
{
    private $addbooks;
    private $addlibcategory;
    private $addstudent_sec;
    private $addpost;
    private $addborrow;

    function __construct(Addbooks $addbooks, Addlibcategory $addlibcategory, Addstudent_sec $addstudent_sec, Addpost $addpost, Addborrow $addborrow)
    {
        $this->addbooks = $addbooks;
        $this->addlibcategory = $addlibcategory;
        $this->addstudent_sec = $addstudent_sec;
        $this->addpost = $addpost;
        $this->addborrow = $addborrow;
        
    }

    public function index(){

        $libcategory = $this->addlibcategory->where('schoolid', Auth::user()->schoolid)->get();
        $addschool = $this->addpost->where('id', Auth::user()->schoolid)->first();
        return view('secondary.librarymodule.library', compact('libcategory', 'addschool'));
    }

    public function viewallbooks(){

        $libcategory = $this->addlibcategory->where('schoolid', Auth::user()->schoolid)->get();
        return view('secondary.librarymodule.viewbooksadmin', compact('libcategory'));
    }

//----------------------------------------------------------------------------------
//                             add books
//----------------------------------------------------------------------------------

    public function addbooks(Request $request){

        $datemain = Carbon::now();
        $attDate = $datemain->toDateString();

        if ($request->input('submittype') == "0") { //add offline book
            $validator = Validator::make($request->all(),[
                // 'file' => 'required|max:2000|mimes:png,jpeg,jpg',
                'booktitle'=>'required|string',
                'bookisbn'=>'required|string',
                'bookcategory'=>'required|string',
                'bookauthor'=>'required|string',
                'editor1'=>'required|string',
                'quantity'=>'required|string'
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()->keys()]);
            }

            $addbooks = $this->addbooks->where(['schoolid'=>Auth::user()->schoolid, 'booktitle'=>$request->input('booktitle'), 'bookisbn'=>$request->input('bookisbn'), 'bookauthor'=>$request->input('bookauthor')])->get();
    
            if (count($addbooks) > 0) {
                return response()->json(['already'=>'already']);
            }
            if (!$request->hasFile('fileebook')) {
                return response()->json(['imgerr'=>'imgerr']);
            }
            
            
            
            $fileName = time().'.'.request()->file('fileebook')->getClientOriginalExtension();
            
            $pathProfile = $request->file('fileebook')->storeAs('public/ebook', $fileName);
    
            // if (!$request->hasFile('file')) {
            //     return response()->json(['imgerr'=>'imgerr']);
            // }
     
            // $fileNamecover = time().'.'.request()->file('file')->getClientOriginalExtension();
            
            // $pathProfile = $request->file('file')->storeAs('public/cover', $fileNamecover);
    
    
            $datemain = Carbon::now();
            $attDate = $datemain->toDateString();
    
    
            $addpdf = new Addbooks();
            $addpdf->schoolid = Auth::user()->schoolid;
            $addpdf->booktitle = $request->input('booktitle');
            $addpdf->bookisbn = $request->input('bookisbn');
            $addpdf->bookcategory = $request->input('bookcategory');
            $addpdf->bookauthor = $request->input('bookauthor');
            $addpdf->datebook = $attDate;
            $addpdf->aboutbook = $request->input('editor1');
            $addpdf->file =  "https://www.mswordcoverpages.com/wp-content/uploads/2018/10/Book-cover-page-3-CRC.png";
            $addpdf->quantity = $request->input('quantity');
            $addpdf->available = $request->input('quantity');
             $addpdf->fileebook = $fileName;
            $addpdf->booktype = "hard copy";
            $addpdf->save();
     
            return response()->json(['success'=>'You have successfully uploaded file.']);
        }
        
        if($request->input('submittype') == "1"){ // add ebook

            $validator = Validator::make($request->all(),[
                // 'file' => 'required|max:2000|mimes:png,jpeg,jpg', //book cover
                'fileebook'=> 'required|max:2000|mimes:pdf,docx,doc', //pdf book 
                'booktitle'=>'required|string',
                'bookisbn'=>'required|string',
                'bookcategory'=>'required|string',
                'bookauthor'=>'required|string',
                'editor1'=>'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()->keys()]);
            }

            $addbooks = Addbooks::where(['schoolid'=>Auth::user()->schoolid, 'booktitle'=>$request->input('booktitle'), 'bookisbn'=>$request->input('bookisbn'), 'bookauthor'=>$request->input('bookauthor')])->get();
    
            if (count($addbooks) > 0) {
                return response()->json(['already'=>'already']);
            }
    
            if (!$request->hasFile('fileebook')) {
                return response()->json(['imgerr'=>'imgerr']);
            }
            
            
            
            $fileName = time().'.'.request()->file('fileebook')->getClientOriginalExtension();
            
            $pathProfile = $request->file('fileebook')->storeAs('public/ebook', $fileName);

            

            // if (!$request->hasFile('file')) {
            //     return response()->json(['imgerr'=>'imgerr']);
            // }
            
            
            // $fileNamecover = time().'.'.request()->file('file')->getClientOriginalExtension();
            
            // $pathProfile = $request->file('file')->storeAs('public/cover', $fileNamecover);
            
            

            $addpdf = new Addbooks();
            $addpdf->schoolid = Auth::user()->schoolid;
            $addpdf->booktitle = $request->input('booktitle');
            $addpdf->bookisbn = $request->input('bookisbn');
            $addpdf->bookcategory = $request->input('bookcategory');
            $addpdf->bookauthor = $request->input('bookauthor');
            $addpdf->datebook = $attDate;
            $addpdf->aboutbook = $request->input('editor1');
            $addpdf->file =  "https://www.mswordcoverpages.com/wp-content/uploads/2018/10/Book-cover-page-3-CRC.png";
            $addpdf->quantity = "0";
            $addpdf->fileebook = $fileName;
            $addpdf->booktype = "ebook";
            $addpdf->save();

            return response()->json(['success'=>'You have successfully uploaded file.']);

        }

        
    }

    public function addcategory(Request $request){

        $validator = Validator::make($request->all(),[
            'category'=>'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $categorylist = explode(',', $request->input('category'));

        for ($i=0; $i < count($categorylist); $i++) { 
            $catnamesingle = $categorylist[$i];

            $addlibcategory = Addlibcategory::where('categoryname', $catnamesingle)->get();

            if (count($addlibcategory) < 1) {

                $addlibcat = new Addlibcategory();
                $addlibcat->schoolid = Auth::user()->schoolid;
                $addlibcat->categoryname = $catnamesingle;
                $addlibcat->save();
            }
        }

        return response()->json(['success'=>'successfull']);
    }

    public function deletebook(Request $request){

        $validator = Validator::make($request->all(),[
            'bookidtodelete'=>'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $id = $request->input("bookidtodelete");

        $data = Addbooks::findOrFail($id);
        $data->delete();

        return response()->json(['success'=>'successfull']);
    }


    public function ftechAllbooks(){

        $chatdown = DB::table('addbooks')
        ->join('addlibcategories', 'addlibcategories.id','=','addbooks.bookcategory')
        ->where(['addbooks.schoolid'=>Auth::user()->schoolid])
        ->select('addbooks.*', 'addlibcategories.categoryname')->paginate(12);
        return response()->json(['data'=>$chatdown]);
    }

    public function trackbook(){
        return view('secondary.librarymodule.track_book');
    }

    public function fetchbokdetailisbn(Request $request){

        $validator = Validator::make($request->all(),[
            'bookisbnentered'=>'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $bookdetails = DB::table('addbooks')
                    ->join('addlibcategories', 'addlibcategories.id','=','addbooks.bookcategory')
                    ->where(['addbooks.bookisbn'=> $request->input('bookisbnentered'), 'addbooks.schoolid'=>Auth::user()->schoolid])
                    ->select('addbooks.*', 'addlibcategories.categoryname')->get();

                    if (count($bookdetails) > 0) {
                        $idf = $bookdetails->toJson();
                        $bookdetailsmain = json_decode($idf, true)[0];
                        return response()->json(['bookdetaild'=>$bookdetailsmain]);
                    }else {
                        return response()->json(['notfound'=>'notfound']);
                    }
    }

    public function getstudentforbook(Request $request){

        $validator = Validator::make($request->all(),[
            'studentregno'=>'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $addschool = Addpost::where('id', Auth::user()->schoolid)->get();
        $schooltype = $addschool[0]['schooltype'];

        if ($schooltype == "Primary") {

            $addstudent = DB::table('addstudents')
                        ->join('users', 'users.id','=','addstudents.usernamesystem')
                        ->join('classlist','classlists.id','=','addstudents.classid')
                        ->where('addstudents.id', $request->input('studentregno'))
                        ->select('addstudent.*', 'users.firstname', 'users.middlename', 'users.lastname', 'classlists.classnamee')->get();

                        if (count($addstudent) > 0) {
                            $idf = $addstudent->toJson();
                            $studentdetails = json_decode($idf, true)[0];

                            return response()->json(['success'=>$studentdetails, '']);
                        }else {

                            return response()->json(['error'=>"error"]);
                            
                        }

            
        }else {

            $addstudent = DB::table('addstudent_secs')
                        ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
                        ->join('classlist_secs','classlist_secs.id','=','addstudent_secs.classid')
                        ->where('addstudent_secs.id', $request->input('studentregno'))
                        ->select('addstudent_secs.*', 'users.firstname', 'users.middlename', 'users.lastname', 'classlist_secs.classname as classnamee')->get();

                        if (count($addstudent) > 0) {
                            $idf = $addstudent->toJson();
                            $studentdetails = json_decode($idf, true);

                            return response()->json(['success'=>$studentdetails, '']);
                        }else {

                            return response()->json(['error'=>"error"]);
                            
                        }
        }

        
    }

    public function addBookBorrowData(Request $request){

        // return $request->input();

        $validator = Validator::make($request->all(),[
            'bookid'=>'required|string',
            'bookisbnissn'=>'required|string',
            'datetoreturnbook'=>'required|string',
            'studentregnobook'=>'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $checkforduplicate = Addborrow::where(['studentreno'=>$request->input('studentregnobook'), 'bookisbnissn'=>$request->input('bookisbnissn'), 'status'=>'Pending'])->get();

        if (count($checkforduplicate) > 0) {
            return response()->json(['duplicate'=>"duplicate"]);
        }

        $getdatabooks = Addborrow::where(['bookid'=> $request->input('bookid'), 'status'=>'Pending', 'schoolid'=>Auth::user()->schoolid])->get();
        $borrowed = count($getdatabooks);

        $checkrecord = Addbooks::where('id', $request->input('bookid'))->get();

        $available = $checkrecord[0]['available'];
        $quantity = $checkrecord[0]['quantity'];

        if ($available < 1) {
            return response()->json(['notavailable'=>"notavailable"]);
        }

        $datemain = Carbon::now();
        $attDate = $datemain->toDateString();

        $addborrow = new Addborrow();
        $addborrow->schoolid = Auth::user()->schoolid;
        $addborrow->studentreno = $request->input('studentregnobook');
        $addborrow->dateborrow = $attDate;
        $addborrow->datetoreturn = $request->input('datetoreturnbook');
        $addborrow->bookid = $request->input('bookid');
        $addborrow->bookisbnissn = $request->input('bookisbnissn');
        $addborrow->status = "Pending";
        $addborrow->save();

        $updatebookdata = Addbooks::find($request->input('bookid'));
        $updatebookdata->available = $quantity - 1;
        $updatebookdata->borrowed = $borrowed + 1;
        $updatebookdata->save();
        

        return response()->json(['success'=>"success"]);
    }

    public function allborrowedbook(){

        $schooltype = Addpost::where('id', Auth::user()->schoolid)->get();
        $schooltypemain = $schooltype[0]['schooltype'];

        if ($schooltypemain == "Primary") {
            if (Auth::user()->hasRole('Librarian')) {
                $chatdown = DB::table('addborrows')
                ->join('addbooks', 'addbooks.id','=','addborrows.bookid')
                ->join('addstudents', 'addstudents.id','=','addborrows.studentregno')
                ->join('users', 'users.id','=','addstudents.usernamesystem')
                ->where(['addborrows.schoolid'=>Auth::user()->schoolid])
                ->select('addborrows.*', 'addbooks.booktitle',)->paginate(12);
                return response()->json(['data'=>$chatdown]);
            }else {
                $studentregno = Addstudent::where('usernamesystem', Auth::user()->id)->get();
                $rgnomain = $studentregno[0]['id'];
                $chatdown = DB::table('addborrows')
                ->join('addbooks', 'addbooks.id','=','addborrows.bookid')
                ->join('addstudents', 'addstudents.id','=','addborrows.studentregno')
                ->join('users', 'users.id','=','addstudents.usernamesystem')
                ->where(['addborrows.schoolid'=>Auth::user()->schoolid, 'addborrows.studentreno'=>$rgnomain])
                ->select('addborrows.*', 'addbooks.booktitle',)->paginate(12);
                return response()->json(['data'=>$chatdown]);
            }
        }else{
            if (Auth::user()->hasRole('Librarian')) {
                $chatdown = DB::table('addborrows')
                ->join('addbooks', 'addbooks.id','=','addborrows.bookid')
                ->join('addstudent_secs', 'addstudent_secs.id','=','addborrows.studentreno')
                ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
                ->where(['addborrows.schoolid'=>Auth::user()->schoolid])
                ->select('addborrows.*', 'addbooks.booktitle', 'addbooks.file', 'users.firstname', 'users.middlename', 'users.lastname')->orderBy('created_at', 'DESC')->paginate(12);
                return response()->json(['data'=>$chatdown]);
            }else {
                $studentregno = Addstudent_sec::where('usernamesystem', Auth::user()->id)->get();
                $rgnomain = $studentregno[0]['id'];
                $chatdown = DB::table('addborrows')
                ->join('addbooks', 'addbooks.id','=','addborrows.bookid')
                ->join('addstudent_secs', 'addstudent_secs.id','=','addborrows.studentreno')
                ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
                ->where(['addborrows.schoolid'=>Auth::user()->schoolid, 'addborrows.studentreno'=>$rgnomain])
                ->select('addborrows.*', 'addbooks.booktitle', 'addbooks.file', 'users.firstname', 'users.middlename', 'users.lastname')->orderBy('created_at', 'DESC')->paginate(12);
                return response()->json(['data'=>$chatdown]);
            }
        }

    }

    public function deletebookborrowrecord(Request $request){
        $validator = Validator::make($request->all(),[
            'borrowrecordid'=>'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $id = $request->input("borrowrecordid");

        $data = Addborrow::findOrFail($id);
        $data->delete();

        return response()->json(['success'=>'successfull']);
    }

    public function approvereturnbook(Request $request){

        $validator = Validator::make($request->all(),[
            'bookcondition'=>'required|string',
            'borrowrecordid'=>'required|string',
            'actiontype'=>'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        if ($request->input('actiontype') == "approve") {

            $getdatabooks = Addborrow::where(['id'=> $request->input('borrowrecordid'), 'status'=>'Pending', 'schoolid'=>Auth::user()->schoolid])->get();
            $bookid = $getdatabooks[0]['bookid'];
    
            $checkrecord = Addbooks::where('id', $bookid)->get();
    
            $available = $checkrecord[0]['available'];
            $borrowed = $checkrecord[0]['borrowed'];

            $datemain = Carbon::now();
            $attDate = $datemain->toDateString();
    
            $addborrow = Addborrow::find($request->input('borrowrecordid'));
            $addborrow->datereturned = $attDate;
            $addborrow->bookcondition = $request->input('bookcondition');
            $addborrow->status = "Completed";
            $addborrow->save();

            $updatebookdata = Addbooks::find($bookid);
            $updatebookdata->available = $available + 1;
            $updatebookdata->borrowed = $borrowed - 1;
            $updatebookdata->save();
    
            return response()->json(['success'=>'successfull']);
        }else{

            $getdatabooks = Addborrow::where(['id'=> $request->input('borrowrecordid'), 'status'=>'Pending', 'schoolid'=>Auth::user()->schoolid])->get();
            $bookid = $getdatabooks[0]['bookid'];
    
            $checkrecord = Addbooks::where('id', $bookid)->get();
    
            $available = $checkrecord[0]['available'];
            $borrowed = $checkrecord[0]['borrowed'];

            $addborrow = Addborrow::find($request->input('borrowrecordid'));
            $addborrow->datereturned = NULL;
            $addborrow->bookcondition = NULL;
            $addborrow->status = "Pending";
            $addborrow->save();

            $updatebookdata = Addbooks::find($bookid);
            $updatebookdata->available = $available - 1;
            $updatebookdata->borrowed = $borrowed + 1;
            $updatebookdata->save();
    
            return response()->json(['revoke'=>'successfull']);
        }



    }
}
