<?php

namespace App\Http\Controllers;

use App\Ou;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Error;
use Auth;

class OuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Ou  $ou
     * @return \Illuminate\Http\Response
     */
    public function showOuList(Ou $ou, Setting $setting, Request $request)
    {

        $results = Error::make(0);

        //当前管理员用户邮箱
        $email = Auth::guard('admin')->user()->email;

        //查询数据库中是否已经存了对应的配置
        $settings = $setting::where('admin', $email)
            ->where('name', 'oulist')
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
            $count = $ou->count();
            $datalist = $ou;
        } else {
            $datalist = $ou->where('name', 'like', '%'.$search.'%')
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

        $datalist = $datalist->get();

        $list = [];
        $datalist->each(function ($item, $key) use (&$list) {
            $ouname = $item->ou()->first()->name;
            $list[] = array_merge($item->toArray(), ['ou'=>$ouname]);
        });

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
     * @param  \App\Ou  $ou
     * @return \Illuminate\Http\Response
     */
    public function add(Ou $ou, Request $request, $id = null)
    {

        if (isset($id)) {


            // if ($id == 1) {
            //     $results = Error::make(202);
            //     $results['ids'] = $idArray;
            //     return response()->json($results);
            // }


            $datalist = $ou::find($id);

            if ($datalist) {
                $datalist->name = $request->input("name");
                $datalist->ou_id = (int) $request->input("ou_id");
                $path = $ou->where('id', $datalist->ou_id)->first()->path;
                $datalist->path = $path . '/' . $datalist->name;
                $datalist->desp = $request->input("desp", '');
                $datalist->save();


                $results = Error::make(0);

                $results['info'] = $datalist->toArray();

                return response()->json($results);
            }
        } else {
            $datalist = new Ou;

            $datalist->name = $request->input("name");
            $datalist->ou_id = (int) $request->input("ou_id");
            $path = $ou->where('id', $datalist->ou_id)->first()->path;
            $datalist->path = $path . '/' . $datalist->name;
            $datalist->desp = $request->input("desp", '');
            $datalist->save();

            $results = Error::make(0);

            $results['info'] = $datalist->toArray();

            return response()->json($results);
        }
    }

    public function view(Ou $ou, Request $request, $id)
    {

        //查询数据库中是否已经存了对应的配置
        $datalist = $ou::where('id', $id)
            ->get();

        $results = Error::make(0);

        $results['info'] = $datalist->first();

        return response()->json($results);

    }

    public function del(Request $request, Ou $ou, $id)
    {
        $idArray = explode(',', $id);
        $ou::destroy($idArray);

        $results = Error::make(0);
        $results['ids'] = $idArray;

        return response()->json($results);


    }

    public function componentlist(Request $request, Ou $ou)
    {

        // dd($request->has('search'));
        if ($request->has('search')) {
            $search = $request->input('search');
            $datalist = $ou->where('name', 'like', '%'.$search.'%')
                ->limit(10)
                ->get();
        } else {
            $datalist = $ou
                ->limit(10)
                ->get();
        }

        $list = [];

        $datalist->each(function ($item, $key) use (&$list) {
            $list[] = [
                'id'=>$item->id,
                'name'=>$item->name,
                'path'=>$item->path
            ];
        });

        $results = Error::make(0);

        $results['ouObjectList'] = $list;

        return response()->json($results);
    }
}
