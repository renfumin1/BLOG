<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
//| POST                           | admin/menu                 | menu.store        | App\Http\Controllers\Admin\MenuController@store          | web,admin.login |
//|        | GET|HEAD                       | admin/menu                 | menu.index        | App\Http\Controllers\Admin\MenuController@index          | web,admin.login |
//|        | GET|HEAD                       | admin/menu/create          | menu.create       | App\Http\Controllers\Admin\MenuController@create         | web,admin.login |
//|        | DELETE                         | admin/menu/{menu}          | menu.destroy      | App\Http\Controllers\Admin\MenuController@destroy        | web,admin.login |
//|        | GET|HEAD                       | admin/menu/{menu}          | menu.show         | App\Http\Controllers\Admin\MenuController@show           | web,admin.login |
//|        | PUT|PATCH                      | admin/menu/{menu}          | menu.update       | App\Http\Controllers\Admin\MenuController@update         | web,admin.login |
//|        | GET|HEAD                       | admin/menu/{menu}/edit     | menu.edit         | App\Http\Controllers\Admin\MenuController@edit           | web,admin.login |
    public function index(){
        //菜单获取
        $menu_list = $this->subtree(json_decode(json_encode(DB::table('adminleft')->get()),true));
        session(['leftmenu'=>$menu_list]);//存储用户信息
        return view('Admin.extended_menu',compact('menu_list'));
    }
    //公共的排序
    public function subtree($arr,$id=0,$lev=0) {
        $subs = array(); // 子孙数组
        foreach($arr as $v) {
            if($v['pid'] == $id) {
                $v['lev'] = $lev;
                //$v['name']=str_repeat('|——',$lev).$v['name'];
                $subs[] = $v; // 举例说找到array('id'=>1,'name'=>'安徽','parent'=>0),
                $subs = array_merge($subs,$this->subtree($arr,$v['id'],$lev+1));
            }
        }
        return json_decode(json_encode($subs));
    }
    //添加菜单
    public function store(){
        $info = Input::except('_token');
        $info['create_time']=time();
        $validator = Validator::make($info,[
                'name'=>'required',
                'name_url'=>'required'
            ],
            [
                'required'=>':attrbuite 必填'
            ],
            [
                'name'=>'菜单名称',
                'name_url'=>'菜单地址'
            ]
        );
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
        $is =DB::table('adminleft')->insert($info);
        if($is){
            return redirect('admin/menu');
        }else{
            return redirect()->back()->withErrors('添加失败了');//放回上一个请求页面
        }
    }
    //修改菜单
    public function edit($id){
        $m_info = DB::table('adminleft')->find($id);
        $menu_list = $this->subtree(json_decode(json_encode(DB::table('adminleft')->get()),true));
        return view('Admin.update_menu',compact('m_info'),compact('menu_list'));
    }
    public function update($id){
        $info = Input::except('_method','_token');
        $validator = Validator::make($info,[
            'name'=>'required',
            'name_url'=>'required'
        ],
            [
                'required'=>':attrbuite 必填'
            ],
            [
                'name'=>'菜单名称',
                'name_url'=>'菜单地址'
            ]
        );
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
        $is =DB::table('adminleft')->where('id',$id)->update($info);
        if($is){
            return redirect('admin/menu');
        }else{
            return redirect()->back()->withErrors('修改失败了');//放回上一个请求页面
        }
    }
    //删除菜单
    public function destroy($id){
        $pid=DB::table('adminleft')->select('pid')->where('id',$id)->get();
        $is =DB::table('adminleft')->delete($id);
        if($is){
            DB::table('adminleft')->where('pid',$id)->update(['pid'=>$pid[0]->pid]);
            $data=['message'=>'删除成功','code'=>200];
        }else{
            $data=['message'=>'删除失败','code'=>500];
        }
        return $data;
    }
}
