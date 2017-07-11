<?php

namespace App\Listeners;

use App\Events\LoginEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LoginEvent  $event
     * @return void
     */
    public function handle(LoginEvent $event)
    {
        //获取事件中保存的信息
        $user = $event->getUser();
        //$agent = $event->getAgent();
        $ip = $event->getIp();
        $type = $event->getType();
        $timestamp = $event->getTimestamp();
        //登录信息
        $login_info = [
            'login_ip' => $ip,
            'login_time' => $timestamp,
            'user_id' => $user->id,
            'user_name' => $user->user_name,
            'type'=>$type,
        ];
        //插入到数据库
        \DB::table('log')->insert($login_info);
    }
}
