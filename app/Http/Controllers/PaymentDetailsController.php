<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentDetails;
use Illuminate\Support\Facades\Auth;
use App\Addpost;
use App\FeesInvoice;
use App\Addstudent_sec;
use App\AmountTable;
use App\FeesInvoiceItems;
use App\Services\PaymentService;

class PaymentDetailsController extends Controller
{
    public function index()
    {
        $schoolDetails = Addpost::find(Auth::user()->schoolid);

        return view('secondary.payment.paymentdetails', compact('schoolDetails'));
    }

    public function addDetails(Request $request)
    {

        $request->validate([
            'paystack_pk' => 'required',
            'paystack_sk' => 'required',
            'paystack_payment_url' => 'required',
            'merchant_url' => 'required',
        ]);

        $checkEntry = PaymentDetails::where('schoolid', Auth::user()->schoolid)->first();

        if ($checkEntry == null) {

            $addData = new PaymentDetails();
            $addData->paystack_pk = $request->paystack_pk;
            $addData->paystack_sk = $request->paystack_sk;
            $addData->paystack_payment_url = $request->paystack_payment_url;
            $addData->merchant_url = $request->merchant_url;
            $addData->schoolid = Auth::user()->schoolid;
            $addData->save(); 

            return back()->with('success', 'process successfull');

        }else{

            $checkEntry->paystack_pk = $request->paystack_pk;
            $checkEntry->paystack_sk = $request->paystack_sk;
            $checkEntry->paystack_payment_url = $request->paystack_payment_url;
            $checkEntry->merchant_url = $request->merchant_url;
            $checkEntry->schoolid = Auth::user()->schoolid;
            $checkEntry->save(); 

            return back()->with('success', 'process successfull');

        }

    }

    public function makePayment(Request $request, PaymentService $paymentservice)
    {

        // return $request->server();

        //************************************************************************ 

        //payment reason code

        //code 1 = feepayment
        
        //********************************************************************** */

        //check if fee invoice has been generated....



        //generate invoice for fee payment

        $schoolDetails = Addpost::find(Auth::user()->schoolid);

        $getId = $schoolDetails->shoolinitial.time().Auth::user()->id;

        $studentDetails = Addstudent_sec::where('usernamesystem', Auth::user()->id)->first();

        $checkFeeInvoiceExist = FeesInvoice::where(['system_id'=>Auth::user()->id, 'session'=>$schoolDetails->schoolsession])->first();

        $invoice_student = "";

        if ($checkFeeInvoiceExist == null) {

            $generateInvoice = new FeesInvoice();
            $generateInvoice->schoolid = Auth::user()->schoolid;
            $generateInvoice->invoice_number = $getId;
            $generateInvoice->amount = $request->amount;
            $generateInvoice->system_id = Auth::user()->id;
            $generateInvoice->session = $schoolDetails->schoolsession;
            $generateInvoice->term = $schoolDetails->term;
            $generateInvoice->status = 0;
            $generateInvoice->classid = $studentDetails->classid;
            $generateInvoice->save();

            $invoice_student = $generateInvoice->id;

        }else{

            $invoice_student = $checkFeeInvoiceExist->id;

        }



        //add items for invoice generated above...

        

       $schoolData = AmountTable::join('payment_categories', 'payment_categories.id','=','amount_tables.payment_category_id')
                            ->where(['amount_tables.class_id'=>$studentDetails->classid, 'amount_tables.school_id'=>Auth::user()->schoolid])
                            ->select('amount_tables.*', 'payment_categories.categoryname')->get();

        for ($i=0; $i < $schoolData->count(); $i++) { 

            $checkIfItemAdded = FeesInvoiceItems::where(['session'=>$schoolDetails->schoolsession, 'term' => $schoolDetails->term, 'category_name' => $schoolData[$i]['categoryname']])->get();

            if ($checkIfItemAdded->count()< 1) {
                $addInvoiceItems = new FeesInvoiceItems();
                $addInvoiceItems->school_id = Auth::user()->schoolid;
                $addInvoiceItems->session = $schoolDetails->schoolsession;
                $addInvoiceItems->system_id = Auth::user()->id;
                $addInvoiceItems->category_name = $schoolData[$i]['categoryname'];
                $addInvoiceItems->term = $schoolDetails->term;
                $addInvoiceItems->amount = $schoolData[$i]['amount'];
                $addInvoiceItems->invoice_id = $invoice_student;
                $addInvoiceItems->save();
            }

            

        }

        $request[''] = "";

        $redirectUrl = $paymentservice->payment($request);

        if ($redirectUrl == "error") {
            return back()->with('error', 'Please, ensure you are connected to the internet. Then try again');
        }

        return redirect($redirectUrl);
    }
}
