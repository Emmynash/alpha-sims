<?php

namespace App\Http\Controllers;

use App\FeesInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::debug($request);

        $paymentDetails = $request;

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
    }
}
