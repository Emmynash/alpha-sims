<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MailServices{


    public function sendMail(Request $request, $email)
    {
        
        // $userEmail = $request->Auth::user()->email;

    

            // $email = $users[$i]['email'];
            // $course = $users[$i]['course'];
            // $name = $users[$i]['firstname'];
            $to = $email;

          $subject = "Hi ";
          $content = "<p><b>APPLICATION CONFIRMATION...</b>, </p> <br>
                      <p>Your application was successful, we will get back to you as soon as possible </p>
                     <p>Click the link below to download the attachment for more details... </P>
                     <p><b> Note:</b> Classes commenced on the 18/1/2021. The venue is Block 2, Suit 1, 2, 3 1st Floor Kalwa Plaza. Zarmaganda Rayfield Road Roundabout Jos, </P>
                     <p>Thanks and best regards</p>";
          $from = "bluealgorithmtechnologies@gmail.com ";
          
          $headers  = 'MIME-Version: 1.0' . "\r\n";
          $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
           
          // Create email headers
          $headers .= 'From: '.$from."\r\n".
              'Reply-To: '.$from."\r\n" .
              'X-Mailer: PHP/' . phpversion();
              
          // Compose a simple HTML email message
          $message = '<html><body>';
         
          $message .= '<i style="color:#080;font-size:15px;">'.$subject.'</i>';
       
          $message .= '<br>';
          $message .= '<p style="color:#080;font-size:13px;">'.$content.'</p>';
          $message .= '<br>';
            $message .= '<a href=\'https://drive.google.com/file/d/1MpIbfBaYZbtSbH7FRQ1gNdXgGvZFL0yW/view?usp=sharing \'>Download attachment for more details</a>';
            $message .= '</body></html>';
          
          
  
          
          // Sending email
          if(mail($to, $subject, $message, $headers)){
              echo $to;
              
              // return 'Your mail has been sent successfully.';
              // return response()->json(['success'=>'success']);
          } else{
              echo "failed to";
              // return 'Unable to send email. Please try again.';
              // return response()->json(['notsent'=>'notsent']);

          }
        
    }
}