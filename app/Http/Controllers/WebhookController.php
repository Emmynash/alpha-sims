<?php

namespace App\Http\Controllers;

use App\FeesInvoice;
use App\PaymentDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\AmountBalTableTotal;
use App\AmountBalTableTerm;
use GuzzleHttp\Client;
use App\TransactionRecord;

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

            if ($sk_key == null) {
                exit();
            }
    
            $input = $request->getContent();;
            define('PAYSTACK_SECRET_KEY', $sk_key->paystack_sk);
            // $request['PAYSTACK_SECRET_KEY'] = $sk_key->paystack_sk;
    
            if($request->server()['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $input, PAYSTACK_SECRET_KEY)) exit();
    
            // Log::debug($request);




            $client = new Client();
            $response = $client->request('GET', 'https://api.paystack.co/transaction/verify/'.$paymentDetails['data']['reference'], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '.$sk_key->paystack_sk 
                ],
            ]);

            

            $responseMain = json_decode($response->getBody(), true);

            if ($responseMain['data']['status'] == "success") {

                $schoolid = $paymentDetails['data']['metadata']['schoolid'];
    
                $systemno = $paymentDetails['data']['metadata']['systemno'];
        
                $schoolid = $paymentDetails['data']['metadata']['schoolid'];
    
                $session = $paymentDetails['data']['metadata']['session'];

                $term = $paymentDetails['data']['metadata']['term'];
        
                $amount = $paymentDetails['data']['amount']/100;

                $addHistory = new TransactionRecord();
                $addHistory->transaction_type = 1;
                $addHistory->term = $term;
                $addHistory->session = $session;
                $addHistory->purpose = "Fee Payment";
                $addHistory->amount = $amount;
                $addHistory->school_id = $schoolid;
                $addHistory->system_id = $systemno;
                $addHistory->status = $responseMain['data']['status'];
                $addHistory->save();
                
            }else{

                $schoolid = $paymentDetails['data']['metadata']['schoolid'];
    
                $systemno = $paymentDetails['data']['metadata']['systemno'];
        
                $schoolid = $paymentDetails['data']['metadata']['schoolid'];
    
                $session = $paymentDetails['data']['metadata']['session'];

                $term = $paymentDetails['data']['metadata']['term'];
        
                $amount = $paymentDetails['data']['amount']/100;

                $addHistory = new TransactionRecord();
                $addHistory->transaction_type = 1;
                $addHistory->term = $term;
                $addHistory->session = $session;
                $addHistory->purpose = "Fee Payment";
                $addHistory->amount = $amount;
                $addHistory->school_id = $schoolid;
                $addHistory->system_id = $systemno;
                $addHistory->status = 'pending';
                $addHistory->save();

                exit();

            }
    
            
    
            $paymentcode = $paymentDetails['data']['metadata']['paymentcode'];
    
            if ($paymentcode == "1") {
                
                $schoolid = $paymentDetails['data']['metadata']['schoolid'];
    
                $systemno = $paymentDetails['data']['metadata']['systemno'];
        
                $schoolid = $paymentDetails['data']['metadata']['schoolid'];
    
                $session = $paymentDetails['data']['metadata']['session'];

                $term = $paymentDetails['data']['metadata']['term'];
        
                $amount = $paymentDetails['data']['amount']/100;
        
                $ref = $paymentDetails['data']['reference'];
    
    
                $updatePayment = FeesInvoice::where(['schoolid'=>$schoolid, 'session'=>$session, 'system_id'=>$systemno])->first();
    
                $updatePayment->status = 1;
                $updatePayment->save();

                $checkSchoolWalletExist = AmountBalTableTotal::where('school_id', $schoolid)->first();

                if ($checkSchoolWalletExist == NULL) {
                    $createWalletAddMoney = new AmountBalTableTotal();
                    $createWalletAddMoney->school_id = (int)$schoolid;
                    $createWalletAddMoney->total_amount = (int)$amount;
                    $createWalletAddMoney->save();
                }else{
                    $checkSchoolWalletExist->total_amount += (int)$amount;
                    $checkSchoolWalletExist->save();
                }

                $checkSchoolWalletExistTerm = AmountBalTableTerm::where(['school_id'=> $schoolid, 'term'=>$term, 'session'=>$session])->first();

                if ($checkSchoolWalletExist == NULL) {
                    $createWalletAddMoney = new AmountBalTableTerm();
                    $createWalletAddMoney->school_id = (int)$schoolid;
                    $createWalletAddMoney->total_amount = (int)$amount;
                    $createWalletAddMoney->term = (int)$term;
                    $createWalletAddMoney->session = $session;
                    $createWalletAddMoney->save();
                }else{
                    $checkSchoolWalletExistTerm->total_amount += (int)$amount;
                    $checkSchoolWalletExistTerm->save();
                }


    
            }
        } catch (\Throwable $th) {
            //throw $th;
            Log::debug($th);
        }
    }
}
