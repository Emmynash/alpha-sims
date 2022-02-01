<?php

namespace App\Repository\Schoolsetup;

use App\Addpost;
use App\Classlist_sec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolSetup
{


    public function setupClasses(Request $request)
    {

        try {
            $schoolDetails = Addpost::find(Auth::user()->schoolid);

            $addclasses = Classlist_sec::updateOrCreate(
                ['classname' => strtoupper($request->classname), 'schoolid' => Auth::user()->schoolid],
                [
                    'schoolid' => Auth::user()->schoolid,
                    'classname' => strtoupper($request->classname),
                    'studentcount' => 0,
                    'classtype' => $request->classtype,
                    'status' => 1,
                    'index' => $request->classindex
                ]
            );

            return "success";
        } catch (\Throwable $th) {
            return "unsuccessful";
        }
    }
}
