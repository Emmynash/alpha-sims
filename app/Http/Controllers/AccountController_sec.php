<?php

namespace App\Http\Controllers;

use App\Addpost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\PaymentCategory;

class AccountController_sec extends Controller
{
    public function feesManageSetup()
    {
        $schooldetails = Addpost::find(Auth::user()->schoolid);

        return view('pages.accounting.index_fees', compact('schooldetails'));
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
}
