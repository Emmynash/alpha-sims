<?php

namespace App\Services;

use App\Addpost;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Imageupload{

    public function imageUpload(Request $request)
    {
        try {

            $response = cloudinary()->upload($request->file('image')->getRealPath())->getSecurePath();

            if($request->key == "logo"){

                $updateProfile = Addpost::find(Auth::user()->schoolid);
                $updateProfile->schoolLogo = $response;
                $updateProfile->save();
        
                return "Success";

            }elseif($request->key == "signature"){

                $updateProfile = Addpost::find(Auth::user()->schoolid);
                $updateProfile->schoolprincipalsignature = $response;
                $updateProfile->save();

                return "Success";

            }elseif($request->key == "profile"){

                $updateProfile = User::find(Auth::user()->id);
                $updateProfile->profileimg = $response;
                $updateProfile->save();
                return "Success";
            }
            
            

        } catch (\Throwable $th) {
            //throw $th;
            return "failed";
        }
    }

}