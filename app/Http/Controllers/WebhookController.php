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

        // Log::info($request->server());


        try {
            if ((strtoupper($request->server()['REQUEST_METHOD']) != 'POST' )){
                exit();
            }
    
            $paymentDetails = $request;
    
            $sk_key = PaymentDetails::where("schoolid", $paymentDetails['data']['metadata']['schoolid'])->first();
    
            $input = $request->getContent();;
            define('PAYSTACK_SECRET_KEY', $sk_key->paystack_sk);
            // $request['PAYSTACK_SECRET_KEY'] = $sk_key->paystack_sk;
    
            if($request->server()['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $input, PAYSTACK_SECRET_KEY)) exit();
    
            // Log::debug($request);
    
            
    
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
