<?php

namespace App\Services;

use App\Addpost;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService{

    public function changePassword(Request $request)
    {
        try {
            if(strlen($request->newpassword) < 6){
                return "digits";
            }
    
            if($request->newpassword != $request->repeatpassword){
                return "mismatch";
            }
    
            $user = DB::table('users')->where(['id'=>Auth::user()->id])->first();
    
            if(password_verify($request->currentpassword, $user->password)){
                $getUserRecord = User::find(Auth::user()->id);
                $getUserRecord->password = Hash::make($request->newpassword);
                $getUserRecord->save();
    
                return "success";
            }else{
                return "wrongpassword";
            }

        } catch (\Throwable $th) {
            return "failed";
        }
    }

}