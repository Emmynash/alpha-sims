<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailController extends Controller
{
    public function index()
    {
        return view('secondary.mailbox.index');
    }

    public function compose()
    {
        return view('secondary.mailbox.composemail');
    }
}
