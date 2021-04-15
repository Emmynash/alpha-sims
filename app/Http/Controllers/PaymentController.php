<?php

namespace App\Http\Controllers;

use App\FeesInvoice;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Paystack;
use App\SubHistory;

class PaymentController extends Controller
{

    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        try{
            return Paystack::getAuthorizationUrl()->redirectNow();
        }catch(\Exception $e) {
            return Redirect::back()->with('error', 'token expired try again later');
        }        
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        // $paymentDetails = Paystack::getPaymentData();

        $input = @file_get_contents("php://input");
        $paymentDetails = json_decode($input);

        // return $paymentDetails;

        $paymentcode = $paymentDetails['data']['metadata']['paymentcode'];

        if ($paymentcode == "1") {
            
            $schoolid = $paymentDetails['data']['metadata']['schoolid'];

            $systemno = $paymentDetails['data']['metadata']['systemno'];
    
            $schoolid = $paymentDetails['data']['metadata']['schoolid'];

            $session = $paymentDetails['data']['metadata']['session'];
    
            $amount = $paymentDetails['data']['amount']/100;
    
            $ref = $paymentDetails['data']['reference'];


            $updatePayment = FeesInvoice::where(['schoolid'=>$schoolid, 'session'=>$session, 'system_id'=>$systemno])->first();

            $updatePayment->status = 1;
            $updatePayment->save();

        }



        

        // dd($paymentDetails['data']['channel']);

         //schoolid
        // $student_count = $paymentDetails['data']['metadata']['student_count']; //studentcount
        // $session = $paymentDetails['data']['metadata']['session']; //session
        // $channel = $paymentDetails['data']['channel']; //channel
        // $amount = $paymentDetails['data']['amount']/100; //amount
        // $transid = $paymentDetails['data']['id']; //transid
        // $ref = $paymentDetails['data']['reference']; //ref

        // $history = new SubHistory();
        // $history->student_count = $student_count;
        // $history->schoolid = $schoolid;
        // $history->session = $session;
        // $history->channel = $channel;
        // $history->amount = $amount;
        // $history->transid = $transid;
        // $history->ref = $ref;
        // $history->save(); 

        return back()->with('success', 'Transaction was successfully');


        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }
}