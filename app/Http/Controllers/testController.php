<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;

class testController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        return "ok!";
    }
}
