<?php

namespace App\Http\Controllers;

use App\Addpost;
use App\Addstudent_sec;
use Illuminate\Http\Request;
use App\PaymentCategory;
use App\AmountTable;
use App\InventoryModel;
use App\RequestModelAccount;
use App\OrderInvoiceModel;
use Carbon\Carbon;
use App\InvoicesInventory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

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
        return view('secondary.accounting.summary');
    }

    public function invoices()
    {
        return view('secondary.accounting.inoivces');
    }

    public function orderRequest()
    {
        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('secondary.accounting.request', compact('schooldetails'));
    }

    public function feecollection()
    {
        return view('secondary.accounting.feecollection');
    }

    public function fetchstudentdataforfee(Request $request)
    {

        $regno = $request->admission_no;

        $getStudentData = Addstudent_sec::join('classlist_secs', 'classlist_secs.id','=','addstudent_secs.classid')
                        ->join('addsection_secs', 'addsection_secs.id','=','addstudent_secs.studentsection')
                        ->join('users', 'users.id','=','addstudent_secs.usernamesystem')
                        ->select('addstudent_secs.*', 'classlist_secs.classname', 'addsection_secs.sectionname', 'users.firstname', 'users.middlename', 'users.lastname')
                        ->where('addstudent_secs.id', $regno)->first();

        $feesummary = AmountTable::where("amount_tables.class_id", $getStudentData->classid)
                    ->join('payment_categories', 'payment_categories.id','=','amount_tables.payment_category_id')
                    ->select('amount_tables.*', 'payment_categories.categoryname')->get();

        $totalfees = AmountTable::where("amount_tables.class_id", $getStudentData->classid)->sum('amount');


        return response()->json(['data'=>$getStudentData, 'feesummary'=>$feesummary, 'totalfees'=>$totalfees]);
    }

    public function sendMoneyRequest(Request $request)
    {

        $validatedData = $request->validate([
            'amountrequesting' => 'required',
            'reasonforrequest' => 'required'
        ]);

        $addrequest = new RequestModelAccount();
        $addrequest->amountrequesting = $request->amountrequesting;
        $addrequest->reasonforrequest = $request->reasonforrequest;
        $addrequest->schoolid = (int)Auth::user()->schoolid;
        $addrequest->seeenstatus = false;
        $addrequest->status = "Unattended";
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
}
