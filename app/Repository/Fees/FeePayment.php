<?php

namespace App\Repository\Fees;

use App\Addpost;
use App\Addstudent;
use App\Addstudent_sec;
use App\AmountBalTableTerm;
use App\AmountBalTableTotal;
use App\AmountTable;
use App\FeesInvoice;
use App\FeesInvoiceItems;
use App\FeesTable;
use App\PaymentRecord;
use App\StudentDiscount;
use App\TransactionRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeePayment{
    
    public function confirmFeesPayment(Request $request)
    {
        try {
            $schoolDetails = Addpost::find(Auth::user()->schoolid);

            // $checkTransaction = TransactionRecord::where(['term' => $schoolDetails->term, 'session' =>$schoolDetails->schoolsession, 'school_id'=>Auth::user()->schoolid, 'system_id'=>$request->usernamesystem, 'status'=>'success'])->get();
    
            // if ($checkTransaction->count() > 0) {
            //     return "paid";
            // }
    
            if ($schoolDetails->schooltype == "Primary") {
    
                $getId = $schoolDetails->shoolinitial.time().$request->usernamesystem;
    
                $studentDetails = Addstudent::where('usernamesystem', $request->usernamesystem)->first();
        
                $checkFeeInvoiceExist = FeesInvoice::where(['system_id'=>$request->usernamesystem, 'session'=>$schoolDetails->schoolsession])->first();
        
                $invoice_student = "";
        
                if ($checkFeeInvoiceExist == null) {
        
                    $generateInvoice = new FeesInvoice();
                    $generateInvoice->schoolid = Auth::user()->schoolid;
                    $generateInvoice->invoice_number = $getId;
                    $generateInvoice->amount = $request->amount;
                    $generateInvoice->system_id = $request->usernamesystem;
                    $generateInvoice->session = $schoolDetails->schoolsession;
                    $generateInvoice->term = $schoolDetails->term;
                    $generateInvoice->status = 0;
                    $generateInvoice->classid = $studentDetails->classid;
                    $generateInvoice->save();
        
                    $invoice_student = $generateInvoice->id;
        
                }else{
        
                    $invoice_student = $checkFeeInvoiceExist->id;
        
                }
    
                $schoolData = AmountTable::join('payment_categories', 'payment_categories.id','=','amount_tables.payment_category_id')
                            ->where(['amount_tables.class_id'=>$studentDetails->classid, 'amount_tables.school_id'=>Auth::user()->schoolid])
                            ->select('amount_tables.*', 'payment_categories.categoryname')->get();
    
                for ($i=0; $i < $schoolData->count(); $i++) { 
    
                    $checkIfItemAdded = FeesInvoiceItems::where(['session'=>$schoolDetails->schoolsession, 'term' => $schoolDetails->term, 'category_name' => $schoolData[$i]['categoryname']])->get();
    
                    if ($checkIfItemAdded->count()< 1) {
                        $addInvoiceItems = new FeesInvoiceItems();
                        $addInvoiceItems->school_id = Auth::user()->schoolid;
                        $addInvoiceItems->session = $schoolDetails->schoolsession;
                        $addInvoiceItems->system_id = $request->usernamesystem;
                        $addInvoiceItems->category_name = $schoolData[$i]['categoryname'];
                        $addInvoiceItems->term = $schoolDetails->term;
                        $addInvoiceItems->amount = $schoolData[$i]['amount'];
                        $addInvoiceItems->invoice_id = $invoice_student;
                        $addInvoiceItems->save();
                    }
    
                }

                
    
                //add money to school wallet
    
                $this->addAmountToSchoolWallet($request);

    
                $updatePayment = FeesInvoice::where(['schoolid'=>Auth::user()->schoolid, 'session'=>$schoolDetails->schoolsession, 'system_id'=>$request->usernamesystem])->first();
        
                $updatePayment->status = 1;
                $updatePayment->save();
    
                $this->addTransactionHistory($request, 'Fees full payment');

                //add payment record
                $request->except(['usernamesystem']);
                $request['regno'] = $studentDetails->id;
                $request['total_amount'] = $request->amount;


                
                $this->addPaymentRecord($request, $studentDetails->id);
    
    
                return "success";
    
    
            }else{
    
                $getId = $schoolDetails->shoolinitial.time().$request->usernamesystem;
    
                $studentDetails = Addstudent_sec::where('usernamesystem', $request->usernamesystem)->first();
        
                $checkFeeInvoiceExist = FeesInvoice::where(['system_id'=>$request->usernamesystem, 'session'=>$schoolDetails->schoolsession])->first();
        
                $invoice_student = "";
        
                if ($checkFeeInvoiceExist == null) {
        
                    $generateInvoice = new FeesInvoice();
                    $generateInvoice->schoolid = Auth::user()->schoolid;
                    $generateInvoice->invoice_number = $getId;
                    $generateInvoice->amount = $request->amount;
                    $generateInvoice->system_id = $request->usernamesystem;
                    $generateInvoice->session = $schoolDetails->schoolsession;
                    $generateInvoice->term = $schoolDetails->term;
                    $generateInvoice->status = 0;
                    $generateInvoice->classid = $studentDetails->classid;
                    $generateInvoice->save();
        
                    $invoice_student = $generateInvoice->id;
        
                }else{
        
                    $invoice_student = $checkFeeInvoiceExist->id;
        
                }
    
                $schoolData = AmountTable::join('payment_categories', 'payment_categories.id','=','amount_tables.payment_category_id')
                            ->where(['amount_tables.class_id'=>$studentDetails->classid, 'amount_tables.school_id'=>Auth::user()->schoolid])
                            ->select('amount_tables.*', 'payment_categories.categoryname')->get();
    
                for ($i=0; $i < $schoolData->count(); $i++) { 
    
                    $checkIfItemAdded = FeesInvoiceItems::where(['session'=>$schoolDetails->schoolsession, 'term' => $schoolDetails->term, 'category_name' => $schoolData[$i]['categoryname']])->get();
    
                    if ($checkIfItemAdded->count()< 1) {
                        $addInvoiceItems = new FeesInvoiceItems();
                        $addInvoiceItems->school_id = Auth::user()->schoolid;
                        $addInvoiceItems->session = $schoolDetails->schoolsession;
                        $addInvoiceItems->system_id = $request->usernamesystem;
                        $addInvoiceItems->category_name = $schoolData[$i]['categoryname'];
                        $addInvoiceItems->term = $schoolDetails->term;
                        $addInvoiceItems->amount = $schoolData[$i]['amount'];
                        $addInvoiceItems->invoice_id = $invoice_student;
                        $addInvoiceItems->save();
                    }
    
                }
    
    
                //add money to school wallet
    
                $this->addAmountToSchoolWallet($request);
    
                $updatePayment = FeesInvoice::where(['schoolid'=>Auth::user()->schoolid, 'session'=>$schoolDetails->schoolsession, 'system_id'=>$request->usernamesystem])->first();
        
                $updatePayment->status = 1;
                $updatePayment->save();
    
    
                //add transaction history

                $this->addTransactionHistory($request, 'Fees full payment');


                //add payment record
                $request->except(['usernamesystem', 'amount']);
                $request['regno'] = $studentDetails->id;
                $request['total_amount'] = $request->amount;



                $this->addPaymentRecord($request, $studentDetails->id);
    
    
                return "success";
    
            }
        } catch (\Throwable $th) {
            //throw $th;

            return $th;
        }
    }

    public function addAmountToSchoolWallet(Request $request)
    {

        try {
            $schoolDetails = Addpost::find(Auth::user()->schoolid);

            $checkSchoolWalletExist = AmountBalTableTotal::where('school_id', Auth::user()->schoolid)->first();
    
            if ($checkSchoolWalletExist == NULL) {
                $createWalletAddMoney = new AmountBalTableTotal();
                $createWalletAddMoney->school_id = (int)Auth::user()->schoolid;
                $createWalletAddMoney->total_amount = (int)$request->amount;
                $createWalletAddMoney->save();
            }else{
                $checkSchoolWalletExist->total_amount += (int)$request->amount;
                $checkSchoolWalletExist->save();
            }
    
            try {
                $checkSchoolWalletExistTerm = AmountBalTableTerm::where(['school_id'=> Auth::user()->schoolid, 'term'=>$schoolDetails->term, 'session'=>$schoolDetails->schoolsession])->first();
    
                return $schoolDetails->schoolsession;

                if ($checkSchoolWalletExist == NULL) {
                    $createWalletAddMoney = new AmountBalTableTerm();
                    $createWalletAddMoney->school_id = (int)Auth::user()->schoolid;
                    $createWalletAddMoney->total_amount = (int)$request->amount;
                    $createWalletAddMoney->term = (int)$schoolDetails->term;
                    $createWalletAddMoney->session = $schoolDetails->schoolsession;
                    $createWalletAddMoney->save();
                }else{
                    $checkSchoolWalletExistTerm->total_amount += (int)$request->amount;
                    $checkSchoolWalletExistTerm->save();
                }
            } catch (\Throwable $th) {
                //throw $th; 
                return $th;
            }


        } catch (\Throwable $th) {
            //throw $th; 

            return $th;
        }
        
    }


    public function addTransactionHistory(Request $request, $purpose)
    {

        $schoolDetails = Addpost::find(Auth::user()->schoolid);

        $addHistory = new TransactionRecord();
        $addHistory->transaction_type = 1;
        $addHistory->term = $schoolDetails->term;
        $addHistory->session = $schoolDetails->schoolsession;
        $addHistory->purpose = $purpose;
        $addHistory->amount = $request->amount;
        $addHistory->school_id = Auth::user()->schoolid;
        $addHistory->system_id = $request->usernamesystem;
        $addHistory->status = 'success';
        $addHistory->save();
    }


    public function addPaymentRecord(Request $request, $userid)
    {

        $schoolDetails = Addpost::find(Auth::user()->schoolid);

        $studentDetails = Addstudent_sec::find($request->regno);

        $paymentRecordsum = PaymentRecord::where(['regno'=> $request->regno, 'term'=>$schoolDetails->term, 'session'=>$schoolDetails->schoolsession, 'schoolid'=>Auth::user()->schoolid])->sum('amount_paid');

        //check if student has a discount
        $checkDiscount = StudentDiscount::where('regno', $request->regno)->first();

        $discount = 0;

        if ($checkDiscount == null) {
            $discount = 0;
        }else{
            $percentAllocatedDiscount = $checkDiscount->percent;
            $percentDiscountCal = $percentAllocatedDiscount/100; //in decimal
            $discount = $percentDiscountCal*$request->total_amount;
        }

        if ((($request->total_amount - $discount) - $paymentRecordsum) == 0) {
            return "Payment already";
        }

        if ($request->amount > ($request->total_amount - $discount)) {
            return "over charge";
        }

        $checkFeeInvoiceExist = FeesInvoice::where(['system_id'=>$userid, 'session'=>$schoolDetails->schoolsession, 'term'=>$schoolDetails->term])->first();

        try {

            $getFeesTableRecord = FeesTable::where(['system_id'=>$userid, 'schoolid'=>Auth::user()->schoolid, 'term' => $schoolDetails->term, 'session'=>$schoolDetails->schoolsession, 'invoice_id'=>$checkFeeInvoiceExist->id])->first();

            //check if the fees have been paid in full

            if($getFeesTableRecord != null){

                $getRecentFeeTableWrite = FeesTable::find($getFeesTableRecord->id);

                if($checkFeeInvoiceExist->amount == $getRecentFeeTableWrite->amount_paid){
    
                    return "Payment already";
    
                }else{

                    $remAmount = $checkFeeInvoiceExist->amount - $getRecentFeeTableWrite->amount_paid;

                    if($request->amount > $remAmount){
                        return "over charge";
                    }

                }

            }

                $addAmountRem = FeesTable::updateOrcreate(
                    ['system_id'=>$userid, 'schoolid'=>Auth::user()->schoolid, 'term' => $schoolDetails->term, 'session'=>$schoolDetails->schoolsession, 'invoice_id'=>$checkFeeInvoiceExist->id],
                    [
                        'system_id'=>$userid, 
                        'schoolid'=>Auth::user()->schoolid, 
                        'term' => $schoolDetails->term, 
                        'session'=>$schoolDetails->schoolsession, 
                        'invoice_id'=>$checkFeeInvoiceExist->id,
                        'amount_paid'=>$getFeesTableRecord == null ? $request->amount: $request->amount+$getFeesTableRecord->amount_paid,
                        'status'=>1
                    ]
                );

                $getRecentFeeTableWrite = FeesTable::find($addAmountRem->id);

                if($checkFeeInvoiceExist->amount == $getRecentFeeTableWrite->amount_paid){

                    $updatePaymentStatus = FeesInvoice::find($checkFeeInvoiceExist->id);
                    $updatePaymentStatus->status = 1;
                    $updatePaymentStatus->save();

                }
                
        } catch (\Throwable $th) {
            //throw $th;

            return $th;
        }

        $addPaymentRecord = new PaymentRecord();
        $addPaymentRecord->regno = $request->regno;
        $addPaymentRecord->admission_no = $studentDetails->admission_no;
        $addPaymentRecord->amount_paid = $request->amount;
        $addPaymentRecord->amount_rem = ($request->total_amount - $discount) - ($paymentRecordsum + $request->amount);
        $addPaymentRecord->total_amount = $request->total_amount - $discount;
        $addPaymentRecord->schoolid = Auth::user()->schoolid; 
        $addPaymentRecord->term = $schoolDetails->term;
        $addPaymentRecord->session = $schoolDetails->schoolsession;
        $addPaymentRecord->invoice_number = $checkFeeInvoiceExist->invoice_number;
        $addPaymentRecord->save();

        return "Payment done";
    }

    public function generateInvoice(Request $request, $userid)
    {

        try {

            $schoolDetails = Addpost::find(Auth::user()->schoolid);
            $getId = $schoolDetails->shoolinitial.time().$userid;
            $studentDetails = Addstudent_sec::find($userid);
            $checkFeeInvoiceExist = FeesInvoice::where(['system_id'=>$userid, 'session'=>$schoolDetails->schoolsession, 'term'=>$schoolDetails->term])->first();
    
            $invoice_student = "";

                    //check if student has a discount
            $checkDiscount = StudentDiscount::where('regno', $request->regno)->first();

            $discount = 0;

            if ($checkDiscount == null) {
                $discount = 0;
            }else{
                $percentAllocatedDiscount = $checkDiscount->percent;
                $percentDiscountCal = $percentAllocatedDiscount/100; //in decimal
                $discount = $percentDiscountCal * $request->total_amount;
            }
            
            if ($checkFeeInvoiceExist == null) {
    
                $generateInvoice = new FeesInvoice();
                $generateInvoice->schoolid = Auth::user()->schoolid;
                $generateInvoice->invoice_number = $getId;
                $generateInvoice->amount = $request->total_amount - $discount;
                $generateInvoice->system_id = $userid;
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
    
                $checkIfItemAdded = FeesInvoiceItems::where(['system_id'=>$userid, 'session'=>$schoolDetails->schoolsession, 'term' => $schoolDetails->term, 'category_name' => $schoolData[$i]['categoryname']])->get();
    
                if ($checkIfItemAdded->count()< 1) {
                    $addInvoiceItems = new FeesInvoiceItems();
                    $addInvoiceItems->school_id = Auth::user()->schoolid;
                    $addInvoiceItems->session = $schoolDetails->schoolsession;
                    $addInvoiceItems->system_id = $userid;
                    $addInvoiceItems->category_name = $schoolData[$i]['categoryname'];
                    $addInvoiceItems->term = $schoolDetails->term;
                    $addInvoiceItems->amount = $schoolData[$i]['amount'];
                    $addInvoiceItems->invoice_id = $invoice_student;
                    $addInvoiceItems->save();
                }
    
            }

            return "success";


        } catch (\Throwable $th) {
            return "error";
        }
    
    }

}