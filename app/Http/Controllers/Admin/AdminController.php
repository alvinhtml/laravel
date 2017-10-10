<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Error;
use Auth;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * common auth info
     * @return [type] [description]
     */
    public function authInfo()
    {
        $admin = Auth::guard('admin')->user();
        $result = Error::make(0);
        $result['logined'] = true;
        $result['adminname'] = $admin['name'];
        $result['adminemail'] = $admin['email'];
        return response()->json($result);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function showAdminList(Admin $admin, Setting $setting, Request $request)
    {

        $email = Auth::guard('admin')->user()->email;

        //查询数据库中是否已经存了对应的配置
        $settings = $setting::where('admin', $email)
            ->where('name', 'adminlist')
            ->get();
        $results = Error::make(0);

        if (!$settings->isEmpty()) {
            $results['configs'] = json_decode($settings->first()['setting']);
        }

        $limit_num = $request->input('limit',20);
        $datalist = $admin->limit($limit_num)->get();


        $results['list'] = $datalist->toArray();
        //$results['count'] = $datalist->count();
        $results['count'] = $admin->count();
        $results['page'] = $request->input('page', 1);


        return response()->json($results);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
