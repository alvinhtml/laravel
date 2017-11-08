<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use App\Libraries\Error;
use Auth;

class SettingController extends Controller
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

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Display the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function list_configs(Request $request, Setting $setting)
    {


        $listPath = $request->input('listPath');

        if ($listPath) {
            $setting_str = $request->input('configs');
            $admin = Auth::guard('admin')->user()->email;

            //查询数据库中是否已经存了对应的配置
            $result = $setting::where('admin', $admin)
                ->where('name', $listPath)
                ->get();
            if ($result->isEmpty()) {
                //如果不存在, 创建一条
                $settings = new Setting;
                $settings->admin = $admin;
                $settings->name = $listPath;
                $settings->setting = $setting_str;
                $settings->save();
            } else {
                //如果存在, 更新已存在数据
                $setting::where('admin', $admin)
                    ->where('name', $listPath)
                    ->update(['setting' => $setting_str]);
            }
            $results = Error::make(0);
            return response()->json($results);
        }else{
            $results = Error::make(201);
            return response()->json($results);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
