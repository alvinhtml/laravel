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

            // Admin::create([
            //     'name' => 'admin'.$i,
            //     'email' => 'admin'.$i.'@gmail.com',
            //     'type' => rand(0, 2),
            //     'ouid' => rand(0, 10),
            //     'state' => rand(0, 1),
            //     'desp' => '',
            //     'password' => bcrypt('123456'),
            // ]);

        return "ok!";
    }
}
