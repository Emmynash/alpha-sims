<?php

namespace App\Http\Controllers;

use App\FeesInvoice;
use App\PaymentDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {


        try {
            if ((strtoupper($request->method()) != 'POST' ) || !array_key_exists('x-paystack-signature', $request->input()) ){
                exit();
            }
    
            $paymentDetails = $request;
    
            $paymentDetails = PaymentDetails::where("schoolid", $paymentDetails['data']['metadata']['schoolid'])->first();
    
            $input = @file_get_contents("php://input");
            define('PAYSTACK_SECRET_KEY', $paymentDetails->paystack_sk);
    
            if($request['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $input, PAYSTACK_SECRET_KEY)) exit();
    
            Log::debug($request);
    
            
    
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
        } catch (\Throwable $th) {
            //throw $th;
            Log::debug($th);
        }
    }
}
