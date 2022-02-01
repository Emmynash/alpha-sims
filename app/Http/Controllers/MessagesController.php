<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Auth;

class MessagesController extends Controller
{
    public function fetchMessages(Request $request){

        $messages = Message::where('senderid', Auth::user()->id)->get();

        // $userdetails = "msg";


        return response()->json($messages, 200);
    }
}
