<?php

namespace App\Http\Controllers;

use App\Events\MessagePosted;
use Illuminate\Http\Request;
use Auth;

class FirebaseController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
       return view('firebase.index');
    }
}
