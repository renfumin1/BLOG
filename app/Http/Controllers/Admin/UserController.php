<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Loginlog;
use App\Http\Model\user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
//| GET|HEAD                       | admin/user                 | user.index        | App\Http\Controllers\Admin\UserController@index          | web,admin.login |
//|        | POST                           | admin/user                 | user.store        | App\Http\Controllers\Admin\UserController@store          | web,admin.login |
//|        | GET|HEAD                       | admin/user/create          | user.create       | App\Http\Controllers\Admin\UserController@create         | web,admin.login |
//|        | DELETE                         | admin/user/{user}          | user.destroy      | App\Http\Controllers\Admin\UserController@destroy        | web,admin.login |
//|        | PUT|PATCH                      | admin/user/{user}          | user.update       | App\Http\Controllers\Admin\UserController@update         | web,admin.login |
//|        | GET|HEAD                       | admin/user/{user}          | user.show         | App\Http\Controllers\Admin\UserController@show           | web,admin.login |
//|        | GET|HEAD                       | admin/user/{user}/edit     | user.edit         | App\Http\Controllers\Admin\UserController@edit           | web,admin.login
    //用户列表
    public function index(){
        $user_list = user::all();
        return view('Admin.manage_user',['user_list'=>$user_list]);
    }
    //添加用户
    public function store(){
        $info= Input::except('_token');
        $validator = Validator::make($info,[
            'real_name'=>'required|min:2|max:6',
            'user_name'=>'required|min:2|max:10',
            'usertel'=>'min:7|max:11',
            'password'=>'required|confirmed',
        ],[
            'required'=>':attribute 必填字段',
            'real_name.min'=>':attribute 不能太短[2]',
            'real_name.max'=>':attribute 不能太长[6]',
            'user_name.min'=>':attribute 不能太短[2]',
            'user_name.max'=>':attribute 不能太长[10]',
            'usertel.min'=>':attribute 输入有错误',
            'usertel.max'=>':attribute 输入有错误',
            'confirmed'=>':attribute 两次密码不一致',
        ],[
            'real_name'=>'姓名',
            'user_name'=>'用户名',
            'usertel'=>'电话',
            'password'=>'密码',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
        //保存用户
        unset($info['password_confirmation']);
        $info['password']= Crypt::encrypt($info['password']);
        $info['create_time']=time();
        if(user::create($info)){
            return redirect('admin/user');
        }
    }
    //修改用户展示
    public function show($uid){
        $user_info = user::find($uid);
        $user_info['url']=url('admin/user',[$uid]);
        return $user_info;
    }
    //修改用户信息PUT|PATCH
    public function update($uid){
        $newinfo = array_filter(Input::except(['_token','_method']));
        $rules=[
            'user_name'=>'required|min:2|max:10',
            'real_name'=>'required|min:2|max:6',
            'usertel'=>'min:7|max:11',
            'password'=>'required_with:password_confirmation|confirmed',
            'password_confirmation'=>'required_with:password',
            'old_password'=>'required',
        ];
        $message=[
            'required'=>':attribute 此项为必填',
            'required_with'=>':attribute 不能为空',
            'confirmed'=>':attribute 两次输入的密码不一致',
            'real_name.min'=>':attribute 不能太短[2]',
            'real_name.max'=>':attribute 不能太长[6]',
            'user_name.min'=>':attribute 不能太短[2]',
            'user_name.max'=>':attribute 不能太长[10]',
            'usertel.min'=>':attribute 输入有错误',
            'usertel.max'=>':attribute 输入有错误',
        ];
        $rules2=[
            'user_name'=>'用户名',
            'real_name'=>'姓名',
            'usertel'=>'电话',
            'password'=>'新密码',
            'password_confirmation'=>'确认密码',
            'old_password'=>'旧密码'
        ];
        $validate = Validator::make($newinfo,$rules,$message,$rules2);
        if($validate->passes()){//验证通过
            $info = user::find($uid);
            //旧密码验证
            if(Crypt::decrypt($info->password)!=$newinfo['old_password']){
                return redirect()->back()->withErrors('原密码错误');
            };
            if(isset($newinfo['password'])){
                $newinfo['password'] = Crypt::encrypt($newinfo['password']);//新密码加密
            }
            unset($newinfo['password_confirmation'],$newinfo['old_password']);
            $newinfo['update_time']=time();
            if(user::where('id',$uid)->update($newinfo)){
                return  redirect('admin/user');
            };
        }else{
            return redirect()->back()->withErrors($validate);
        }
    }
    //删除用户
    public function destroy($uid){
        $is = user::where('id',$uid)->delete();
        if($is){
            $data=['message'=>'删除成功','code'=>200];
        }else{
            $data=['message'=>'删除失败','code'=>500];
        }
        return $data;
    }
    //禁止用户5-0 uid-type
    public function edit($param){
        $arr = explode('-',$param);
        $uid = $arr[0];
        $type = $arr[1]?0:1;
        $is = user::where('id',$arr['0'])->update(['type'=>$type]);
        if($is){
            return redirect('admin/user');
        }else{
            return redirect('admin/user')->withErrors('');
        }
    }
    //用户登录日志
    public function loginlog(){
        $login_log = Loginlog::all();
        return view('admin.loginlog',['login_log'=>$login_log]);
    }
    //删除登录记录
    public function loginlogdelete(Request $request,$id=''){
         if($id){
            $is = Loginlog::where('user_id',$id)->delete();
            $message=$is?'清空登录信息成功':'无数据变更';
            return redirect('admin/loginlog')->with(['message'=>$message]);
         }else{
            if($request->isMethod('post')){
                $id = $request->all()['id'];
                $is = Loginlog::where('id',$id)->delete();
                if($is){
                    $data=['message'=>'删除成功','code'=>200];
                }else{
                    $data=['message'=>'sorry删除失败','code'=>500];
                }
                return $data;
            }else{
                DB::table('log')->truncate();
                return redirect('admin/loginlog')->with(['message'=>'该表数据信息重置成功']);
            }
         }
    }
}
