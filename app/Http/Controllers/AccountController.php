<?php

namespace App\Http\Controllers;

use App\Addpost;
use App\Addstudent;
use App\Addstudent_sec;
use App\AmountBalTableTerm;
use Illuminate\Http\Request;
use App\PaymentCategory;
use App\AmountTable;
use App\FeesInvoice;
use App\InventoryModel;
use App\RequestModelAccount;
use App\OrderInvoiceModel;
use App\InvoicesInventory;
use App\TransactionRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\AmountBalTableTotal;
use App\FeesInvoiceItems;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class AccountController extends Controller
{

    private $paymentcategory;

    function __constuct(PaymentCategory $paymentcategory)
    {
        $this->paymentcategory = $paymentcategory;
        
    }

    public function index()
    {
        return view('secondary.accounting.index');
    }

    public function account_dash()
    {

        return view('secondary.accounting.dashboard');
    }

    public function index_fees()
    {
        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('secondary.accounting.schoolfees.index_fees', compact('schooldetails'));
        
    }

    public function addPaymentCategory(Request $request)
    {
        $validatedData = $request->validate([
            'paymentcategoryform' => 'required'
        ]);

        $check = PaymentCategory::where(['categoryname'=>$request->paymentcategoryform, 'school_id'=>Auth::user()->schoolid])->get();

        if ($check->count() >0) {
            return back()->with('error', 'category already exist');
        }

        //add record to database
        $addcategory = new PaymentCategory();
        $addcategory->categoryname =$request->paymentcategoryform;
        $addcategory->school_id = Auth::user()->schoolid;
        $addcategory->save();

        return back()->with('success', 'Category added successfully');
    }

    public function updatePaymentCategory(Request $request, $id)
    {
        $validatedData = $request->validate([
            'paymentcategoryform' => 'required'
        ]);

        $check = PaymentCategory::where(['categoryname'=>$request->paymentcategoryform, 'school_id'=>Auth::user()->schoolid])->get();

        if ($check->count() >0) {
            return back()->with('error', 'category already exist');
        }

        //add update to database
        $addcategory = PaymentCategory::find($id);
        $addcategory->categoryname =$request->paymentcategoryform;
        $addcategory->save();

        return back()->with('success', 'Category added successfully');
    }

    public function addcategoryamount(Request $request)
    {
        $validatedData = $request->validate([
            'paymentcategoryform' => 'required',
            'classSelected' => 'required',
            'amount' => 'required'
        ]);

        $check = AmountTable::where(['payment_category_id'=>$request->paymentcategoryform, 'class_id'=>$request->classSelected, 'school_id'=>Auth::user()->schoolid])->get();

        if ($check->count() >0) {
            return back()->with('error', 'Amount already added');
        }

        $addamount = new AmountTable();
        $addamount->payment_category_id = $request->paymentcategoryform;
        $addamount->class_id = $request->classSelected;
        $addamount->amount = $request->amount;
        $addamount->school_id = Auth::user()->schoolid;
        $addamount->save();

        return back()->with('success', 'Category added successfully');
        
    }

    public function deletePaymentCategory($id)
    {
        $deletecat = PaymentCategory::find($id);
        $deletecat->delete();

        $deleteAmount = AmountTable::where('payment_category_id', $id)->first();
        if ($deleteAmount != null) {
            $deleteAmount->delete();
        }
        

        return back()->with('success', 'Record deleted successfully...');
    }

    public function updateCategoryAmount(Request $request, $id)
    {
        $validatedData = $request->validate([
            'classSelected' => 'required',
            'amount' => 'required'
        ]);

        $updateAmount = AmountTable::find($id);
        $updateAmount->class_id = $request->classSelected;
        $updateAmount->amount = $request->amount;
        $updateAmount->save();

        return back()->with('success', 'Record deleted successfully...');
    }

    public function summary()
    {
        $schooldetails = Addpost::find(Auth::user()->schoolid);

        $transactionHistory = TransactionRecord::where('school_id', Auth::user()->schoolid)->orderBy('created_at', 'desc')->paginate(10);

        $sumTotalExpenditure = RequestModelAccount::where(['schoolid'=> Auth::user()->schoolid, 'status'=>'accept'])->sum('amountrequesting');

        $sumTotalExpenditureTerm = RequestModelAccount::where(['schoolid'=> Auth::user()->schoolid, 'status'=>'accept', 'term'=>$schooldetails->term, 'session'=>$schooldetails->schoolsession])->sum('amountrequesting');

        

        return view('secondary.accounting.summary', compact('schooldetails', 'transactionHistory', 'sumTotalExpenditure', 'sumTotalExpenditureTerm'));
    }

    public function invoices()
    {
        // $feeInvoices = FeesInvoice::where('schoolid', Auth::user()->schoolid)->get();

        $schooldetails = Addpost::find(Auth::user()->schoolid);

        $feeInvoices = FeesInvoice::
                    join('classlist_secs', 'classlist_secs.id','=','fees_invoices.classid')
                    ->join('users', 'users.id','=','fees_invoices.system_id')
                    ->select('fees_invoices.*', 'classlist_secs.classname', 'users.firstname', 'users.middlename', 'users.lastname')
                    ->where(['fees_invoices.schoolid'=>Auth::user()->schoolid])->get();

        $getSettledInvoices = FeesInvoice::where(['schoolid'=> Auth::user()->schoolid, 'status'=>1])->get();

        $getSettledInvoicesThisTerm = FeesInvoice::where(['schoolid'=> Auth::user()->schoolid, 'status'=>1, 'term'=>$schooldetails->term, 'session'=>$schooldetails->schoolsession])->get();

        $getPendingInvoices = FeesInvoice::where(['schoolid'=> Auth::user()->schoolid, 'status'=>0])->get();

        $getPendingInvoicesThisTerm = FeesInvoice::where(['schoolid'=> Auth::user()->schoolid, 'status'=>0, 'term'=>$schooldetails->term, 'session'=>$schooldetails->schoolsession])->get();

        return view('secondary.accounting.inoivces', compact('feeInvoices', 'getSettledInvoices', 'getPendingInvoices', 'getSettledInvoicesThisTerm', 'getPendingInvoicesThisTerm', 'schooldetails'));
    }

    public function orderRequest()
    {
        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('secondary.accounting.request', compact('schooldetails'));
    }

    public function feecollection()
    {
        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('secondary.accounting.feecollection', compact('schooldetails'));
    }

    public function confirmMoneyReceived(Request $request)
    {
        $schoolDetails = Addpost::find(Auth::user()->schoolid);

        $checkTransaction = TransactionRecord::where(['term' => $schoolDetails->term, 'session' =>$schoolDetails->schoolsession, 'school_id'=>Auth::user()->schoolid, 'system_id'=>$request->usernamesystem, 'status'=>'success'])->get();

        if ($checkTransaction->count() > 0) {
            return back()->with('error', 'School fee already paid');
        }

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

            $checkSchoolWalletExistTerm = AmountBalTableTerm::where(['school_id'=> Auth::user()->schoolid, 'term'=>$schoolDetails->term, 'session'=>$schoolDetails->schoolsession])->first();

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

            $updatePayment = FeesInvoice::where(['schoolid'=>Auth::user()->schoolid, 'session'=>$schoolDetails->schoolsession, 'system_id'=>$request->usernamesystem])->first();
    
            $updatePayment->status = 1;
            $updatePayment->save();

            $addHistory = new TransactionRecord();
            $addHistory->transaction_type = 1;
            $addHistory->term = $schoolDetails->term;
            $addHistory->session = $schoolDetails->schoolsession;
            $addHistory->purpose = "Fee Payment";
            $addHistory->amount = $request->amount;
            $addHistory->school_id = Auth::user()->schoolid;
            $addHistory->system_id = $request->usernamesystem;
            $addHistory->status = 'success';
            $addHistory->save();


            return back()->with('success', 'Process Successful');


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

            $checkSchoolWalletExistTerm = AmountBalTableTerm::where(['school_id'=> Auth::user()->schoolid, 'term'=>$schoolDetails->term, 'session'=>$schoolDetails->schoolsession])->first();

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

            $updatePayment = FeesInvoice::where(['schoolid'=>Auth::user()->schoolid, 'session'=>$schoolDetails->schoolsession, 'system_id'=>$request->usernamesystem])->first();
    
            $updatePayment->status = 1;
            $updatePayment->save();


            $addHistory = new TransactionRecord();
            $addHistory->transaction_type = 1;
            $addHistory->term = $schoolDetails->term;
            $addHistory->session = $schoolDetails->schoolsession;
            $addHistory->purpose = "Fee Payment";
            $addHistory->amount = $request->amount;
            $addHistory->school_id = Auth::user()->schoolid;
            $addHistory->system_id = $request->usernamesystem;
            $addHistory->status = 'success';
            $addHistory->save();


            return back()->with('success', 'Process Successful');

        }
        
    }

    public function fetchstudentdataforfee(Request $request)
    {
        $validatedData = $request->validate([
            'identity' => 'required',
        ]);

        $regno = $request->identity;

        //check if identity is regno first

        $getStudentData = Addstudent_sec::join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
                        ->join('addsection_secs', 'addsection_secs.id','=','addstudent_secs.studentsection')
                        ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
                        ->select('addstudent_secs.*', 'classlist_secs.classname', 'addsection_secs.sectionname', 'users.firstname', 'users.middlename', 'users.lastname')
                        ->where(['addstudent_secs.id'=> $regno, 'addstudent_secs.schoolid'=>Auth::user()->schoolid])->first();

        if ($getStudentData == null) {
        //else
        $getStudentData = Addstudent_sec::join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
                        ->join('addsection_secs', 'addsection_secs.id','=','addstudent_secs.studentsection')
                        ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
                        ->select('addstudent_secs.*', 'classlist_secs.classname', 'addsection_secs.sectionname', 'users.firstname', 'users.middlename', 'users.lastname', 'users.profileimg')
                        ->where(['addstudent_secs.id'=> $regno, 'addstudent_secs.schoolid'=>Auth::user()->schoolid])->first();
        }

        if ($getStudentData == null) {
            return back()->with('error', 'Student record not found');
        }



       $feesummary = AmountTable::where("amount_tables.class_id", $getStudentData->classid)
                    ->join('payment_categories', 'payment_categories.id','=','amount_tables.payment_category_id')
                    ->select('amount_tables.*', 'payment_categories.categoryname')->get();

        $totalfees = AmountTable::where("amount_tables.class_id", $getStudentData->classid)->sum('amount');


        return redirect()->back()->with(['data'=>$getStudentData, 'feesummary'=>$feesummary, 'totalfees'=>$totalfees]);


        return response()->json(['data'=>$getStudentData, 'feesummary'=>$feesummary, 'totalfees'=>$totalfees]);
    }

    public function sendMoneyRequest(Request $request)
    {

        $validatedData = $request->validate([
            'amountrequesting' => 'required',
            'reasonforrequest' => 'required'
        ]);

        $schooldetails = Addpost::find(Auth::user()->schoolid);


        $addrequest = new RequestModelAccount();
        $addrequest->amountrequesting = $request->amountrequesting;
        $addrequest->reasonforrequest = $request->reasonforrequest;
        $addrequest->schoolid = (int)Auth::user()->schoolid;
        $addrequest->seeenstatus = false;
        $addrequest->status = "Unattended";
        $addrequest->term = $schooldetails->term;
        $addrequest->session = $schooldetails->schoolsession;
        $addrequest->dateaccepted = "";
        
        $addrequest->sender = (int)Auth::user()->id;
        $addrequest->save();

        return back()->with('success', 'Request sent successfully');  
    }

    public function inventory()
    {
        $schooldetails = Addpost::find(Auth::user()->schoolid);

        $latestInvoiceCheck = Session::get('latestinvoice');

        $itemforInventory = InvoicesInventory::where('id', $latestInvoiceCheck)->first();

        return view('secondary.accounting.inventory.index', compact('schooldetails', 'itemforInventory'));
    }

    public function inventory_add_item(Request $request)
    {
        $validatedData = $request->validate([
            'classid' => 'required',
            'nameofitem' => 'required',
            'amount' => 'required',
            'quantity' => 'required'
        ]);

        if ($request->classid == "Others") {

            $checkforduplicate = InventoryModel::where(['schoolid'=>Auth::user()->schoolid, "nameofitem"=>$request->nameofitem, 'classid'=>$request->classid, 'othersval'=>$request->Otherfield])->get();

            if ($checkforduplicate->count() > 0) {
                return back()->with("error", "Duplicate entry");
            }
    
            $additeminventory = new InventoryModel();
            $additeminventory->classid = $request->classid;
            $additeminventory->nameofitem = $request->nameofitem;
            $additeminventory->amount = $request->amount;
            $additeminventory->quantity = $request->quantity;
            $additeminventory->schoolid = (int)Auth::user()->schoolid;
            $additeminventory->othersval = $request->Otherfield;
            $additeminventory->save();
    
            return back()->with("success", "Item added successfully");
            
        }else{
            $checkforduplicate = InventoryModel::where(['schoolid'=>Auth::user()->schoolid, "nameofitem"=>$request->nameofitem, 'classid'=>$request->classid])->get();

            if ($checkforduplicate->count() > 0) {
                return back()->with("error", "Duplicate entry");
            }
    
            $additeminventory = new InventoryModel();
            $additeminventory->classid = $request->classid;
            $additeminventory->nameofitem = $request->nameofitem;
            $additeminventory->amount = $request->amount;
            $additeminventory->quantity = $request->quantity;
            $additeminventory->schoolid = (int)Auth::user()->schoolid;
            $additeminventory->save();
    
            return back()->with("success", "Item added successfully");
        }



        
    }

    public function addInvoiceOrder(Request $request, $id)
    {

    $latestInvoiceCheck = Session::get('latestinvoice');

    if ($latestInvoiceCheck == NULL) {

        $schooldetails = Addpost::where('id', Auth::user()->schoolid)->first();

        $getId = $schooldetails->shoolinitial.time().Auth::user()->id;
    
        $addinvoice = new InvoicesInventory();
        $addinvoice->invoicenumber = $getId;
        $addinvoice->schoolid = Auth::user()->schoolid;
        $addinvoice->accountant_id = Auth::user()->id;
        $addinvoice->save();
    
        Session::put('latestinvoice', $addinvoice->id);
    
        $addInvoiceitem = new OrderInvoiceModel();
        $addInvoiceitem->item_id = $id;
        $addInvoiceitem->accountant_id = Auth::user()->id;
        $addInvoiceitem->school_id = Auth::user()->schoolid;
        $addInvoiceitem->quantity = $request->quantity;
        $addInvoiceitem->invoice_id = $addinvoice->id;
        $addInvoiceitem->save();
        
    }else{

        $duplicateCheck = OrderInvoiceModel::where(['item_id'=>$id, 'invoice_id'=>$latestInvoiceCheck])->get();

        if ($duplicateCheck->count()>0) {
            return back()->with('error', 'Item already added to cart');
        }

        $addInvoiceitem = new OrderInvoiceModel();
        $addInvoiceitem->item_id = $id;
        $addInvoiceitem->accountant_id = Auth::user()->id;
        $addInvoiceitem->school_id = Auth::user()->schoolid;
        $addInvoiceitem->quantity = $request->quantity;
        $addInvoiceitem->invoice_id = $latestInvoiceCheck;
        $addInvoiceitem->save();

    }
        return back();

    }

    public function update_invoice_items(Request $request, $id)
    {

        $validatedData = $request->validate([
            'quantity' => 'required',
            'amount' => 'required'
        ]);

        $updateInventoryItems = InventoryModel::find($id);
        $updateInventoryItems->amount = (int)$request->amount;
        $updateInventoryItems->quantity += (int)$request->quantity;
        $updateInventoryItems->save();
        
        return back(); 
    }

    public function request_response(Request $request)
    {

        // return $request;

        $updateRequestStatus = RequestModelAccount::find($request->status);


        if ($request->key == "accept" && $updateRequestStatus->status != "accept") {

            $schooldetails = Addpost::find(Auth::user()->schoolid);

            $amountSchoolWallet = AmountBalTableTotal::where('school_id', Auth::user()->schoolid)->first();

            if ($amountSchoolWallet == null) {
                return back()->with('error', 'not enough funds');
            }

            if ((int)$request->amount > (int)$amountSchoolWallet->total_amount) {
                return back()->with('error', 'not enough funds');
            }


            $updateRequestStatus->seeenstatus = true;
            $updateRequestStatus->status = $request->key;
            $updateRequestStatus->dateaccepted = Carbon::now();
            $updateRequestStatus->save();

            $amountSchoolWallet->total_amount -= (int)$request->amount;
            $amountSchoolWallet->save();


            $amountSchoolWalletterm = AmountBalTableTerm::where(['school_id'=> Auth::user()->schoolid, 'term'=>$schooldetails->term, 'session'=>$schooldetails->schoolsession])->first();

            if ($amountSchoolWalletterm == NULL) {

                $createWalletAddMoney = new AmountBalTableTerm();
                $createWalletAddMoney->school_id = (int)$schooldetails->schoolsession;
                $createWalletAddMoney->total_amount = (int)$request->amount;
                $createWalletAddMoney->term = (int)$schooldetails->term;
                $createWalletAddMoney->session = $schooldetails->schoolsession;
                $createWalletAddMoney->save();
                
            }else{
                $amountSchoolWalletterm->total_amount -= (int)$request->amount;
                $amountSchoolWalletterm->save();
            }


            $addHistory = new TransactionRecord();
            $addHistory->transaction_type = 0;
            $addHistory->term = $schooldetails->term;
            $addHistory->session = $schooldetails->schoolsession;
            $addHistory->purpose = "Request Accepted";
            $addHistory->amount = (int)$request->amount;
            $addHistory->school_id = Auth::user()->schoolid;
            $addHistory->system_id = Auth::user()->id;
            $addHistory->status = 'success';
            $addHistory->save();

            return back();

        }else{

            $updateRequestStatus = RequestModelAccount::find($request->status);
            $updateRequestStatus->seeenstatus = true;
            $updateRequestStatus->status = $request->key;
            $updateRequestStatus->dateaccepted = Carbon::now();
            $updateRequestStatus->save();

            return back()->with('success', 'process successful');
        }

        return back();
        
    }

    public function order_invoice_checkout(Request $request)
    {
        $validatedData = $request->validate([
            'invoiceid' => 'required',
            'itemsamount' => 'required'
        ]);

        //InvoicesInventory
        //TransactionRecord
        //AmountBalTableTotal

        $schooldetails = Addpost::find(Auth::user()->schoolid);

        $updateInvoiceStatus = InvoicesInventory::find($request->invoiceid);
        $updateInvoiceStatus->status = "Completed";
        $updateInvoiceStatus->save();

        $addHistory = new TransactionRecord();
        $addHistory->transaction_type = 0;
        $addHistory->term = $schooldetails->term;
        $addHistory->session = $schooldetails->schoolsession;
        $addHistory->purpose = "Inventory trans";
        $addHistory->amount = $request->itemsamount;
        $addHistory->school_id = Auth::user()->schoolid;
        $addHistory->system_id = Auth::user()->id;
        $addHistory->status = 'success';
        $addHistory->save();

        $updateWallet = AmountBalTableTotal::where('school_id', Auth::user()->schoolid)->first();


        if ($updateWallet == NULL) {

            $createWalletAddMoney = new AmountBalTableTotal();
            $createWalletAddMoney->school_id = (int)Auth::user()->schoolid;
            $createWalletAddMoney->total_amount = (int)$request->itemsamount;
            $createWalletAddMoney->save();

        }else{
            $updateWallet->total_amount +=(int)$request->itemsamount;
            $updateWallet->save();
        }


            $updateWalletterm = AmountBalTableTerm::where(['school_id'=> Auth::user()->schoolid, 'term'=>$schooldetails->term, 'session'=>$schooldetails->schoolsession])->first();

        if ($updateWalletterm == NULL) {

            $createWalletAddMoney = new AmountBalTableTerm();
            $createWalletAddMoney->school_id = (int)Auth::user()->schoolid;
            $createWalletAddMoney->total_amount = (int)$request->itemsamount;
            $createWalletAddMoney->term = (int)$schooldetails->term;
            $createWalletAddMoney->session = $schooldetails->schoolsession;
            $createWalletAddMoney->save();

        } else {
            $updateWalletterm->total_amount +=(int)$request->itemsamount;
            $updateWalletterm->save();
        }

        //update item quantity

        $invoice_items = OrderInvoiceModel::where('invoice_id', $request->invoiceid)->get();

        for ($i=0; $i < $invoice_items->count(); $i++) { 
            
            $updateProductQuatity = InventoryModel::find($invoice_items[$i]['item_id']);

            if ((int)$updateProductQuatity->quantity >= (int)$invoice_items[$i]['quantity']) {
                $updateProductQuatity->quantity -= (int)$invoice_items[$i]['quantity'];
                $updateProductQuatity->save();
            }
        }

        $request->session()->forget('latestinvoice');

        return back()->with('success', 'book purchase was successfull');
        
    } 


    public function unpaid_fees()
    {

        $schooldetails = Addpost::find(Auth::user()->schoolid);

        if ($schooldetails->schoolid == "Secondary") {
            $allStudent = Addstudent_sec::join('users', 'users.id','=','addstudent_secs.usernamesystem')
            ->join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
            ->join('addsection_secs', 'addsection_secs.id','=','addstudent_secs.studentsection')
            ->select('addstudent_secs.*', 'users.firstname', 'users.middlename', 'users.lastname', 'classlist_secs.classname', 'addsection_secs.sectionname')
            ->where(['addstudent_secs.schoolid'=>Auth::user()->schoolid, 'addstudent_secs.sessionstatus'=>0])->get();

            $paidInvoices = FeesInvoice::where(['schoolid'=>Auth::user()->schoolid, 'session'=>$schooldetails->schoolsession, 'term'=>$schooldetails->term, 'status'=>1])->pluck('system_id')->toArray();

            $unpaidArray = array();

            for ($i=0; $i < $allStudent->count(); $i++) { 

                if (!in_array ( $allStudent[$i]['usernamesystem'], $paidInvoices )) {
                    array_push($unpaidArray, $allStudent[$i]);
                }
                
            }


            return view('secondary.accounting.unpaidfees', compact('unpaidArray', 'schooldetails'));
        }else{
           $allStudent = Addstudent::join('users', 'users.id','=','addstudents.usernamesystem')
                    ->join('classlists', 'classlists.id','=','addstudents.classid')
                    ->join('addsections', 'addsections.id','=','addstudents.studentsection')
                    ->select('addstudents.*', 'users.firstname', 'users.middlename', 'users.lastname', 'classlists.classnamee as classname', 'addsections.sectionname')
                    ->where(['addstudents.schoolid'=>Auth::user()->schoolid, 'addstudents.sessionstatus'=>0])->get();

            $paidInvoices = FeesInvoice::where(['schoolid'=>Auth::user()->schoolid, 'session'=>$schooldetails->schoolsession, 'term'=>$schooldetails->term, 'status'=>1])->pluck('system_id')->toArray();

            $unpaidArray = array();

            for ($i=0; $i < $allStudent->count(); $i++) { 

                if (!in_array ( $allStudent[$i]['usernamesystem'], $paidInvoices )) {
                    array_push($unpaidArray, $allStudent[$i]);
                }
                
            }


            return view('secondary.accounting.unpaidfees', compact('unpaidArray', 'schooldetails'));
        }


    }
}
