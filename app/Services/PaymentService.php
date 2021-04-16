<?php

namespace App\Services;

use App\Addpost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\PaymentDetails;

class PaymentService{


    public function payment(Request $request)
    {
        try {

            $paymentDetails = PaymentDetails::where("schoolid", Auth::user()->schoolid)->first();

            $scholdetails = Addpost::find(Auth::user()->schoolid);

            $url = "https://api.paystack.co/transaction/initialize";
            $fields = [
              'email' => Auth::user()->email,
              'amount' => $request->amount * 100,
              'metadata' =>[
                  'paymentcode'=>"1", //1 school fee payment
                  'systemno' =>Auth::user()->id,
                  'schoolid' => Auth::user()->schoolid,
                  'session' => $scholdetails->schoolsession,
                  'term' =>$scholdetails->term
              ]
            ];
            $fields_string = http_build_query($fields);
            //open connection
            $ch = curl_init();
            
            //set the url, number of POST vars, POST data
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POST, true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              "Authorization: Bearer ".$paymentDetails->paystack_sk,
              "Cache-Control: no-cache",
            ));
            
            //So that curl_exec returns the contents of the cURL; rather than echoing it
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
    
            // return curl_exec($ch);
            
            //execute post
            $result = json_decode(curl_exec($ch));

            return $result->data->authorization_url;


        } catch (\Throwable $th) {
            //throw $th;

            return "error";
        }
    }

}