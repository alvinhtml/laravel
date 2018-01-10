<?php

namespace App\Http\Controllers;

use App\Term;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Error;
use Auth;

class TermController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function showTermList(Term $term, Setting $setting, Request $request)
    {


        $results = Error::make(0);

        //当前管理员用户邮箱
        $email = Auth::guard('admin')->user()->email;

        //查询数据库中是否已经存了对应的配置
        $settings = $setting::where('admin', $email)
            ->where('name', 'termlist')
            ->get();

        //检查配置数据是否为空
        if ( $settings->isEmpty() ) {
            $configs = [];
            $configs['page'] = 1;
            $configs['limit'] = 20;
            $configs['search'] = '';
            $configs['order'] = [];
        } else {
            //转化列表配置为数组
            $configs = json_decode($settings->first()['setting'], true);
        }

        //当前页码
        $page = $request->input('page', $configs['page']);

        //每页显示条数
        $limit = $request->input('limit', $configs['limit']);

        //$order 排序方式 [字段, 升序or降序]
        $orderString = $request->input('order');
        if (empty($orderString)) {
            $order =  $configs['order'];
        } else {
            $order =  explode(',', $orderString);
        }

        //搜索条件
        $search = $request->input('search');

        if (!isset($search)) {
            $search = $configs['search'];
        }

        if (empty($search)) {
            //获取最大页数
            $count = $term->count();
            $datalist = $term;
        } else {
            $datalist = $term->where('name', 'like', '%'.$search.'%')
                ->orWhere('os', 'like', '%'.$search.'%')
                ->orWhere('hostname', 'like', '%'.$search.'%')
                ->orWhere('desp', 'like', '%'.$search.'%');
            //获取最大页数
            $count = $datalist->count();
        }

        //页码不能超过最大页码
        $page = min($page, ceil($count / $limit));

        //limit offset
        $offset = $page == 1 ? 0 : ($page - 1) * $limit;

        //排序
        if (empty($order)) {
            $datalist = $datalist
            ->offset($offset)
            ->limit($limit);
        } else {
            $datalist = $datalist
                ->offset($offset)
                ->limit($limit)
                ->orderBy($order[0], $order[1]);
        }

        $datalist = $datalist->get(); //取到了 20条数据(终端表)
        // macs 是 mac 表,  一台终端会有多个 mac


        $list = [];
        $datalist->each(function ($item, $key) use (&$list) {
            $mac = array();
            $ip = array();
            $item->macs()->each(function($item2, $key) use (&$mac, &$ip) {
                $mac[] = $item2->mac;
                $ip[] = $item2->ip;
            });
            $ouname = $item->ou()->first()->name;
            $username = $item->user()->first()->name;
            $list[] = array_merge($item->toArray(), [
                'mac'=>$mac,
                'ip'=>$ip,
                'ou'=>$ouname,
                'user'=>$username,
            ]);
        });

        //dd($list);


        $configs['page'] = $page;
        $configs['limit'] = $limit;
        $configs['search'] = $search;
        $configs['order'] = $order;
        $results['configs'] = $configs;
        $results['list'] = $list;
        $results['count'] = $count;

        return response()->json($results);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function add(Term $term, Request $request, $id = null)
    {
        if (isset($id)) {
            $datalist = $term::find($id);

            if ($datalist) {
                $datalist->name = $request->input("name");
                $datalist->type = $request->input("type");
                $datalist->ou_id = $request->input("ou_id");
                $datalist->hostname = $request->input("hostname");
                $datalist->os = $request->input("os");
                $datalist->desp = $request->input("desp");
                $datalist->save();

                $results = Error::make(0);

                $results['info'] = $datalist->toArray();

                return response()->json($results);
            }
        } else {
            $datalist = new Term;

            $datalist->name = $request->input("name");
            $datalist->type = $request->input("type");
            $datalist->ou_id = $request->input("ou_id");
            $datalist->hostname = $request->input("hostname");
            $datalist->os = $request->input("os");
            $datalist->desp = $request->input("desp");
            $datalist->save();

            $results = Error::make(0);

            $results['info'] = $datalist->toArray();

            return response()->json($results);
        }
    }

    public function view(Term $term, Request $request, $id)
    {

        //查询数据库中是否已经存了对应的配置
        $datalist = $term::where('id', $id)
            ->get();

        $results = Error::make(0);

        $results['info'] = $datalist->first();

        return response()->json($results);

    }

    public function del(Request $request, Term $term, $id)
    {
        $idArray = explode(',', $id);
        $term::destroy($idArray);

        $results = Error::make(0);
        $results['ids'] = $idArray;

        return response()->json($results);


    }

    public function edit_state(Request $request, Term $term, $id)
    {
        $idArray = explode(',', $id);

        $results = Error::make(0);

        $state = (int)$request->input("state");

        $term::whereIn('id', $idArray)
            ->update(['state' => $state]);


        $results['ids'] = $idArray;
        $results['state'] = $state;

        return response()->json($results);
    }
}
