<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MyProfileController extends Controller
{
    public function index()
    {
        //get user role
        // return $roles = Auth::user()->hasAnyRole(['Admin', 'HeadOfSchool']);

        return view('secondary.myprofile.myprofile');
    }

    public function updatePassword(AuthService $authService, Request $request)
    {
        $validatedData = $request->validate([
            'currentpassword' => 'required',
            'newpassword' => 'required',
            'repeatpassword' => 'required'
        ]);

        $res = $authService->changePassword($request);
        if($res == "digits"){
            return back()->with("error", 'new password must be up to six digits');
        }elseif($res == "mismatch"){
            return back()->with("error", 'new password mismatch');
        }elseif($res == "success"){
            return back()->with('success', 'Password change was successful');
        }elseif($res == "wrongpassword"){
            return back()->with('error', 'The current password specified is wrong');
        }else{
            return back()->with('error', 'Password Change failed');
        }
    }

    public function updateProfile(Request $request)
    {

        $validatedData = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required'
        ]);

        try {
            $updateProfile = User::find(Auth::user()->id);
            $updateProfile->firstname = $request->firstname;
            $updateProfile->lastname = $request->lastname;
            $updateProfile->save();

            return back()->with('success', 'Profile updated');
        } catch (\Throwable $th) {
            return back()->with('error', 'profile update failed');
        }
        
    }
}
