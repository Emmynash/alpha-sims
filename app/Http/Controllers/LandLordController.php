<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Multitenancy\Models\Tenant;

class LandLordController extends Controller
{
    public function dashUltimate()
    {
        return view('landlord.home');
    }

    public function schoolList()
    {

        $allSchools = Tenant::all();

        return view('landlord.schoollist', compact('allSchools'));
    }

    public function onBoard(Request $request)
    {
        $rules = [
            'name' => 'required',
            'domain' => 'required',
            'database' => 'required'
        ];
    
        $customMessages = [
            'required' => 'The :attribute field can not be blank.'
        ];
    
        $this->validate($request, $rules, $customMessages);

        //onboard school

        $addSchool = new Tenant();
        $addSchool->name = $request->name;
        $addSchool->domain = $request->domain;
        $addSchool->database = $request->database;
        $addSchool->save();

        return back()->with('success', 'Process successful');
    }
}
