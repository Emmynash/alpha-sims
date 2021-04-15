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
use App\Message;
use App\Addfeedback;
use App\Events_sec;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Validator;
use App\Services\MailServices;

class DashboardController extends Controller
{
    public function addschool(){
        

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

    public function store(Request $request, MailServices $mailServices){

        // return $request->input();

        $validatedData = $request->validate([
            'schoolname' => 'required',
            'schoolemail' => 'required',
            'mobilenumber' => 'required',
            'schoolLogo' => 'image|max:200|mimes:jpeg,png,jpg|required',
            'schoolwebsite' => 'required',
            'dateestablished' => 'required',
            'schooladdress' => 'required',
            'schoolprincipalsignature' => 'image|max:200|mimes:jpeg,png,jpg|required',
            'schooltypeselect' => 'required',
            'schoolstate' => 'required'
        ]);

        $schoolcheck = Addpost::where(['mobilenumber'=> $request->input('mobilenumber')])->get();
        
        if(count($schoolcheck) > 0){
            return back()->with('error', 'Phone number already exist. Please add unique number for each school.');
        }

        $realImage = $request->file('schoolLogo');
        $imageSize = getimagesize( $realImage);
        $widthOfImage = $imageSize[0];
        $heightOfImage = $imageSize[1];

        // if($widthOfImage != $heightOfImage){
        //     return back()->with('error', 'invalid image dimension');
        // }

        $realImage1 = $request->file('schoolprincipalsignature');
        $imageSize1 = getimagesize( $realImage1);
        $widthOfImage1 = $imageSize1[0];
        $heightOfImage1 = $imageSize1[1];

        // if($widthOfImage1 != $heightOfImage1){
        //     return back()->with('error', 'invalid image dimension');
        // }

        $key = $request->input('schooltypeselect');

        if ($request->hasFile('schoolLogo') && $request->hasFile('schoolprincipalsignature')) {

            //get file name with extension
            $schoolLogoExt = $request->file('schoolLogo')->getClientOriginalName();
            $principalSignatureExt = $request->file('schoolprincipalsignature')->getClientOriginalName();

            //get just file names
            $fileNameLogo = pathinfo($schoolLogoExt, PATHINFO_FILENAME);
            $fileNameSignature = pathinfo($principalSignatureExt, PATHINFO_FILENAME);

            //get just extensions
            $extensionSchoolLogo = $request->file('schoolLogo')->getClientOriginalExtension();
            $extensionSignature = $request->file('schoolprincipalsignature')->getClientOriginalExtension();

            //file name to store
            $schoolLogoFinal = $fileNameLogo."_".time().$extensionSchoolLogo;
            $principalSignatureFinal = $fileNameSignature."_".time().$extensionSignature;

            //upload image
            $pathLogo = $request->file('schoolLogo')->storeAs('public/schimages', $schoolLogoFinal);
            $pathSignature = $request->file('schoolprincipalsignature')->storeAs('public/schimages', $principalSignatureFinal);
            
        }else{

        }

        //add school to database now
        $addschool = new Addpost;
        $addschool->schooltype = $key;
        $addschool->schoolname = $request->input('schoolname');
        $addschool->schoolemail = $request->input('schoolemail');
        $addschool->schoolstate = $request->input('schoolstate');
        $addschool->mobilenumber = $request->input('mobilenumber');
        $addschool->schoolLogo = $schoolLogoFinal;
        $addschool->schoolwebsite = $request->input('schoolwebsite');
        $addschool->dateestablished = $request->input('dateestablished');
        $addschool->schooladdress = $request->input('schooladdress');
        $addschool->schoolprincipalsignature = $principalSignatureFinal;
        $addschool->status = 'Pending';
        $addschool->periodfrom = '';
        $addschool->periodto = '';
        $addschool->save();

        //appoint as first admin
        $userId = Auth::user()->id;
        $getSchoolId = Addpost::where('mobilenumber', $request->input('mobilenumber'))->get();

        //update schoolId field
        $schoolIdUpdate = User::find($userId);
        $schoolIdUpdate->schoolid = $getSchoolId[0]['id'];
        $schoolIdUpdate->role = "Admin";
        $schoolIdUpdate->save();


        $mailServices->sendMail($request, Auth::user()->email);



        return Redirect::back()->with('success', 'application submited successfully');
        
    }
    
    public function contactform(Request $request){
        
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'Phone_Number' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->keys()]);
        }

        $to = 'uhweka@gmail.com';
        $subject = $request->input('subject');
        $from = $request->input('email');
        
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
         
        // Create email headers
        $headers .= 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();
            
        // Compose a simple HTML email message
        $message = '<html><body>';
        $message .= '<h5 style="color:#f40;">Hi Admin!</h5>';
        $message .= '<br>';
        $message .= '<i style="color:#080;font-size:15px;">Subject:'.$request->input("subject").'</i>';
        $message .= '<br>';
        $message .= '<i style="color:#080;font-size:14px;">Name:'.$request->input("name").'</i>';
        $message .= '<br>';
        $message .= '<i style="color:#080;font-size:14px;">Phone Number:'.$request->input("phone_Number").'</i>';
        $message .= '<br>';
        $message .= '<p style="color:#080;font-size:13px;">'.$request->input("message").'</p>';
        $message .= '</body></html>';
        
        // Sending email
        if(mail($to, $subject, $message, $headers)){
            // return 'Your mail has been sent successfully.';
            return response()->json(['success'=>'success']);
        } else{
            // return 'Unable to send email. Please try again.';
            return response()->json(['notsent'=>'notsent']);
        }
    }
    
    public function feedBack(){
        return view('secondary.feedback');
    }
    
    public function addFeedBack(Request $request){
        
        $validatedData = $request->validate([
            'issueselected' => 'required',
            'accounttype' => 'required',
            'content' => 'required',
        ]);
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        // $url = 'https://www.google.com/recaptcha/api/siteverify';
        // $remoteip = $_SERVER['REMOTE_ADDR'];
        
        // $data = [
        //         'secret' => config('services.recaptcha.secret'),
        //         'response' => $request->get('recaptcha'),
        //         'remoteip' => $remoteip
        //       ];
        // $options = [
        //         'http' => [
        //           'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        //           'method' => 'POST',
        //           'content' => http_build_query($data)
        //         ]
        //     ];
        // $context = stream_context_create($options);
        //         $result = file_get_contents($url, false, $context);
        //         $resultJson = json_decode($result);
        // if ($resultJson->success != true) {
        //         return back()->withErrors(['captcha' => 'ReCaptcha Error']);
        //         }
        // if ($resultJson->score >= 0.3) {
        //         //Validation was successful, add your form submission logic here
        //         return back()->with('message', 'Thanks for your message!');
        // } else {
        //         return back()->withErrors(['captcha' => 'ReCaptcha Error']);
        // }
        
        
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
    
    public function feedBackAdmin(){
        
        $addfeedback = Addfeedback::all();
        
        $allfeedbackdetails = array(
                "addfeedback"=>$addfeedback
            );
            
        // return $allfeedbackdetails['addfeedback'];
        
        return view('super.feedback')->with("allfeedbackdetails", $allfeedbackdetails);
    }
    
    public function addEventAll(Request $request){
        
        
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
    
    public function updatelogosig(Request $request){
        
        if($request->input('logo') == "logo"){
            
            $validatedData = $request->validate([
                'schoolLogo' => 'image|max:200|mimes:jpeg,png,jpg|required',
            ]);
            
            if ($request->hasFile('schoolLogo')) {

                //get file name with extension
                $schoolLogoExt = $request->file('schoolLogo')->getClientOriginalName();
    
                //get just file names
                $fileNameLogo = pathinfo($schoolLogoExt, PATHINFO_FILENAME);
    
                //get just extensions
                $extensionSchoolLogo = $request->file('schoolLogo')->getClientOriginalExtension();
    
                //file name to store
                $schoolLogoFinal = $fileNameLogo."_".time().$extensionSchoolLogo;
    
                //upload image
                $pathLogo = $request->file('schoolLogo')->storeAs('public/schimages', $schoolLogoFinal);
                
                $addschool = Addpost::find(Auth::user()->schoolid);
                $addschool->schoolLogo = $schoolLogoFinal;
                $addschool->save();
                
                return back()->with("success", "updated successfully...");
            
            }
            
            
            
        }else{
            
            $validatedData = $request->validate([
                'schoolprincipalsignature' => 'image|max:200|mimes:jpeg,png,jpg|required',
            ]);
            
            if ($request->hasFile('schoolprincipalsignature')) {

                //get file name with extension
                $principalSignatureExt = $request->file('schoolprincipalsignature')->getClientOriginalName();
    
                //get just file names
                $fileNameSignature = pathinfo($principalSignatureExt, PATHINFO_FILENAME);
    
                //get just extensions
                $extensionSignature = $request->file('schoolprincipalsignature')->getClientOriginalExtension();
    
                //file name to store
                $principalSignatureFinal = $fileNameSignature."_".time().$extensionSignature;
    
                //upload image
                $pathSignature = $request->file('schoolprincipalsignature')->storeAs('public/schimages', $principalSignatureFinal);
                
                $addschool = Addpost::find(Auth::user()->schoolid);
                $addschool->schoolprincipalsignature = $principalSignatureFinal;
                $addschool->save();
                
                return back()->with("success", "updated successfully...");
                
            }
            
            
            
        }
        
        
        
    }
}
