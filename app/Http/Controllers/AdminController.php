<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Libraries\Error;
use Auth;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $admin = Auth::guard('admin')->user();
        return $admin->name;
    }

    public function logined()
    {
        $admin = Auth::guard('admin')->user();

        $result = Error::make(0);
        $result['logined'] = true;
        $result['adminname'] = $admin['name'];
        return response()->json($result);
    }

}
