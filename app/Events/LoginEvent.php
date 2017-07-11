<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LoginEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var User 用户模型
     */
    protected $user;

    /**
     * @var string IP地址
     */
    protected $ip;
    /**
     * @var int type状态
     */
    protected $type;

    /**
     * @var int 登录时间戳
     */
    protected $timestamp;

    /**
     * 实例化事件时传递这些信息
     */
    public function __construct($user, $ip, $timestamp,$type=0)
    {
        $this->user = $user;
        $this->type = $type;
        $this->ip = $ip;
        $this->timestamp = $timestamp;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getIp()
    {
        return $this->ip;
    }
    public function getType()
    {
        return $this->type;
    }
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-default');
    }
}
