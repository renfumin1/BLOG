<?php

namespace App\Http\Controllers\Admin;

use App\Events\LoginEvent;
use App\Http\Model\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
require_once 'resources/org/code/code.class.php';
class LoginController extends CommonController
{
    //登录
    public function login(Request $request){
        //$request->session()->flush();die();清空所有的session
        if($request->isMethod('POST')){
            $login_info = $request->input();
            $login_info['id']=0;//登陆失败者的默认用户id
            //验证码
            if(strtoupper($login_info['code'])!=strtoupper($request->session()->get('CODE'))){
                        $login_info=json_decode(json_encode($login_info));
                        event(new LoginEvent($login_info,$request->getClientIp(), time(),1));//监听用户登录
                        return  redirect()->back()->with('Codemessage','验证码错误');//验证码出错
            }
            $arr = user::where('user_name',$login_info['user_name'])->get();
            //用户名密码(请检查用户名密码)
            $type_info='';
            foreach($arr as $key=>$v){
                if(Crypt::decrypt($v->password)==$login_info['userpwd']){
                    $type_info=$v->password;//用户名和密码相互拼配的用户
                    $type=$v->type;//[用户是否被禁用 1禁用 0未禁用]
                    $user_info=$v;
                    break;
                };
            }
            if(!count($arr) || !$type_info || $type){
                $login_info=json_decode(json_encode($login_info));
                event(new LoginEvent($login_info,$request->getClientIp(), time(),2));//监听用户登录
                return redirect()->back()->with('up','请检查用户名密码');
            }
            //更新用户的登陆时间
            user::where('id',$user_info['id'])->update(['last_login_time'=>time()]);
            event(new LoginEvent($user_info,$request->getClientIp(), time()));//监听用户登录
            $leftmenu=DB::table('adminleft')->select('name','name_url','id','pid')->get();
            $leftmenu=$this->subtree(json_decode(json_encode($leftmenu),true));
            session(['user'=>$user_info,'leftmenu'=>$leftmenu]);//存储用户信息
            return redirect('admin/index');//跳转到后台首页
        }else {
            return view('Admin.login');
        }
    }
    //公共的排序
    public function subtree($arr,$id=0,$lev=0) {
        $subs = array(); // 子孙数组
        foreach($arr as $key=>$v) {
            if($v['pid'] == $id) {
                $v['lev'] = $lev;
                $subs[] = $v; // 举例说找到array('id'=>1,'name'=>'安徽','parent'=>0),
                $subs = array_merge($subs,$this->subtree($arr,$v['id'],$lev+1));
            }
        }
        return json_decode(json_encode($subs));
    }
    //验证码类扩展
    public function code(){
        $a = new \Vcode(300,30);
        $a->outimg();
        session(['CODE'=>$a->getcode()]);//验证码
    }
    //退出登录
    public function quitlogin(){
        session(['user'=>null]);
        return redirect('admin/login');
    }
}