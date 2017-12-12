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

        $results = Error::make(0);

        //当前管理员用户邮箱
        $email = Auth::guard('admin')->user()->email;

        //查询数据库中是否已经存了对应的配置
        $settings = $setting::where('admin', $email)
            ->where('name', 'adminlist')
            ->get();

        //检查配置数据是否为空
        if (!$settings->isEmpty()) {
            $configs = json_decode($settings->first()['setting']);
            $page = $request->input('page', isset($configs->page) ? $configs->page : 1);
            $limit = $request->input('limit', isset($configs->limit) ? $configs->limit : 20);
            $column = $configs->column;
            $order_arr = [$configs->orderkey, $configs->orderby];
            $configs->page = $page;
            $configs->limit = $limit;
            $results['configs'] = $configs;
        } else {
            $page = $request->input('page', 1);
            $limit = $request->input('limit', 20);
            $order_str = $request->input('order', '');

        }

        //搜索
        $search = $request->input('search');
        if (isset($search)) {
            if (isset($results['configs'])) {
                $results['configs']->search = $search;
            }
            $datalist = $admin->where('name', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('desp', 'like', '%'.$search.'%');
            //获取最大页数
            $count = $datalist->count();
        } else {
            //获取最大页数
            $count = $admin->count();
            $datalist = $admin;
        }

        $page = min($page, ceil($count / $limit));

        //limit起始页
        $offset_num = $page == 1 ? 0 : ($page - 1) * $limit;

        //排序
        $order = $request->input('order');
        //如果GET参数中有排序字段
        if (isset($order)) {
            $order_arr = explode(',', $order);
            $datalist = $datalist
                ->offset($offset_num)
                ->limit($limit)
                ->orderBy($order_arr[0], $order_arr[1]);

        } else {
            //如果GET参数中没有排序字段, 但配置中有排序字段
            if (isset($order_arr) && !empty($order_arr[0]) && !empty($order_arr[1])) {
                $datalist = $datalist
                    ->offset($offset_num)
                    ->limit($limit)
                    ->orderBy($order_arr[0], $order_arr[1]);
            } else {
                $datalist = $datalist
                    ->offset($offset_num)
                    ->limit($limit);
            }
        }

        //$datalist = $admin->get();



        $datalist = $datalist->get();

        $results['list'] = $datalist->toArray();
        $results['count'] = $count;


        return response()->json($results);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function add(Admin $admin, Request $request)
    {
        Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'type' => rand(0, 2),
            'ouid' => rand(0, 10),
            'state' => rand(0, 1),
            'desp' => '',
            'password' => bcrypt($data['password']),
        ]);
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
