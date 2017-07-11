<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class indexController extends CommonController
{
    //首页
    public function index(){
        //获取mysql版本信息
        $db_info= DB::select("select VERSION()");
        $db_version = object_get($db_info[0],'VERSION()');
        //浏览器
        $browser = $this->get_user_browser();
        return view('Admin.index',['db_version'=>$db_version,'browser'=>$browser]);
    }
    //获取浏览器信息
    protected function get_user_browser()
    {
        if (empty($_SERVER['HTTP_USER_AGENT']))
        {
            return '';
        }
        $agent  = $_SERVER['HTTP_USER_AGENT'];
        $browser  = '';
        $browser_ver = '';
        if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs))
        {
            $browser  = 'Internet Explorer';
            $browser_ver = $regs[1];
        }
        elseif (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs))
        {
            $browser  = 'FireFox';
            $browser_ver = $regs[1];
        }
        elseif (preg_match('/Maxthon/i', $agent, $regs))
        {
            $browser  = '(Internet Explorer ' .$browser_ver. ') Maxthon';
            $browser_ver = '';
        }
        elseif (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs))
        {
            $browser  = 'Opera';
            $browser_ver = $regs[1];
        }
        elseif (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $agent, $regs))
        {
            $browser  = 'OmniWeb';
            $browser_ver = $regs[2];
        }
        elseif (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $agent, $regs))
        {
            $browser  = 'Netscape';
            $browser_ver = $regs[2];
        }
        elseif (preg_match('/safari\/([^\s]+)/i', $agent, $regs))
        {
            $browser  = 'Safari';
            $browser_ver = $regs[1];
        }
        elseif (preg_match('/NetCaptor\s([^\s|;]+)/i', $agent, $regs))
        {
            $browser  = '(Internet Explorer ' .$browser_ver. ') NetCaptor';
            $browser_ver = $regs[1];
        }
        elseif (preg_match('/Lynx\/([^\s]+)/i', $agent, $regs))
        {
            $browser  = 'Lynx';
            $browser_ver = $regs[1];
        }
        if (!empty($browser))
        {
            return addslashes($browser . ' ' . $browser_ver);
        }
        else
        {
            return 'Unknow browser';
        }
    }
    //修改密码和个人信息
    public function up_userinfo(Request $request){
        $newinfo = array_filter($request->input());
        $rules=[
            'user_name'=>'required',
            'real_name'=>'required',
            'usertel'=>'required',
            'password'=>'required_with:password_confirmation|confirmed',
            'password_confirmation'=>'required_with:password',
            'old_password'=>'required',
        ];
        $message=[
            'required'=>':attribute 此项为必填',
            'required_with'=>':attribute 不能为空',
            'confirmed'=>':attribute 两次输入的密码不一致',
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
             $info = user::find(session('user')['id']);
             //旧密码验证
             if(Crypt::decrypt($info->password)!=$newinfo['old_password']){
                   return redirect()->back()->withErrors('原密码错误');
             };
             if(isset($newinfo['password'])){
                $newinfo['password'] = Crypt::encrypt($newinfo['password']);//新密码加密
             }
             unset($newinfo['_token'],$newinfo['old_password'],$newinfo['password_confirmation']);
             $newinfo['update_time']=time();
             if(user::where('id',session('user')['id'])->update($newinfo)){
                return  redirect('admin/index');
             };
        }else{
            return redirect()->back()->withErrors($validate);
        }
    }
}
