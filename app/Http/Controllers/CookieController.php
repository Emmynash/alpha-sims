<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CookieController extends Controller
{
    public function setcookie(Request $request){
        $minutes = time()+31556926;
        $response = new Response('1');
        $response->withCookie(cookie('dontwant', '1', $minutes));
        return $response;
    }

    public function getCookie(Request $request){
        $value = $request->cookie('dontwant');
        return response()->json(['success'=> $value]);
    }
}
