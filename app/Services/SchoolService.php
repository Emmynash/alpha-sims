<?php

namespace App\Services;

use App\Addpost;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolService{

    public function addSchools(Request $request)
    {
        try {
            $key = $request->input('schooltypeselect');

            //add school to database now
            $addschool = new Addpost;
            $addschool->schooltype = $key;
            $addschool->schoolname = $request->input('schoolname');
            $addschool->schoolemail = $request->input('schoolemail');
            $addschool->schoolstate = $request->input('schoolstate');
            $addschool->mobilenumber = $request->input('mobilenumber');
            $addschool->schoolwebsite = $request->input('schoolwebsite');
            $addschool->dateestablished = $request->input('dateestablished');
            $addschool->schooladdress = $request->input('schooladdress');
            $addschool->status = 'Pending';
            $addschool->periodfrom = '';
            $addschool->periodto = '';
            $addschool->save();

            //update schoolId field
            $schoolIdUpdate = User::find(Auth::user()->id);
            $schoolIdUpdate->schoolid = $addschool->id;
            $schoolIdUpdate->role = "Admin";
            $schoolIdUpdate->save();

            Auth::user()->assignRole('HeadOfSchool');
            
            return "success";
        } catch (\Throwable $th) {
            return "failed";
        }
    }

}