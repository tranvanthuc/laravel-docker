<?php

namespace App\Http\Controllers;

use App\Events\MessagePosted;
use Illuminate\Http\Request;
use Auth;

class MessageController extends Controller
{
    public function __construct()
    {
    }

    public function post(Request $request)
    {
        $message =" abc";
        if (Auth::check()) {
//            event(new MessagePosted(Auth::user(), $message));

        }
        return "true";
    }
}
