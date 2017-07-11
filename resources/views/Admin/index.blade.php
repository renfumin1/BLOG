@extends('Admin.common.index')
@section('title', '博客后台首页')
@section('content')
    <h1 class="page-header">信息总览</h1>
    <div class="row placeholders">
        <div class="col-xs-6 col-sm-3 placeholder">
            <h4>文章</h4>
            <span class="text-muted">0 条</span> </div>
        <div class="col-xs-6 col-sm-3 placeholder">
            <h4>评论</h4>
            <span class="text-muted">0 条</span> </div>
        <div class="col-xs-6 col-sm-3 placeholder">
            <h4>友链</h4>
            <span class="text-muted">0 条</span> </div>
        <div class="col-xs-6 col-sm-3 placeholder">
            <h4>访问量</h4>
            <span class="text-muted">0</span> </div>
    </div>
    <h1 class="page-header">状态</h1>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <tbody>
            <tr>
                <td>登录者: <span>{{Session::get('user')['user_name']}}</span>，这是您第 <span>13</span> 次登录</td>
            </tr>
            <tr>
                <td>上次登录时间: 2016-01-08 15:50:28 , 上次登录IP: ::1:55570</td>
            </tr>
            </tbody>
        </table>
    </div>
    <h1 class="page-header">系统信息</h1>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr> </tr>
            </thead>
            <tbody>
            <tr>
                <td>管理员个数:</td>
                <td>1人</td>
                <td>服务器软件:</td>
                <td>{{$_SERVER['SERVER_SOFTWARE']}}</td>
            </tr>
            <tr>
                <td>浏览器:</td>
                <td>{{$browser}}</td>
                <td>PHP版本:</td>
                <td>{{PHP_VERSION}}</td>
            </tr>
            <tr>
                <td>操作系统:</td>
                <td>{{PHP_OS}}</td>
                <td>PHP运行方式:</td>
                <td>{{PHP_SAPI}}</td>
            </tr>
            <tr>
                <td>登录者IP:</td>
                <td>{{$_SERVER['REMOTE_ADDR'] }}</td>
                <td>MYSQL版本:</td>
                <td>{{$db_version}}</td>
            </tr>
            <tr>
                <td>程序版本:</td>
                <td class="version">YlsatCMS 1.0 <font size="-6" color="#BBB">(20160108160215)</font></td>
                <td>上传文件:</td>
                <td>可以 <font size="-6" color="#BBB">(最大文件：{{get_cfg_var('upload_max_filesize')}})</font></td>
            </tr>
            <tr>
                <td>程序编码:</td>
                <td>UTF-8</td>
                <td>当前时间:</td>
                <td>{{date('Y-m-d H:i:s',time())}}</td>
            </tr>
            </tbody>
            <tfoot>
            <tr></tr>
            </tfoot>
        </table>
    </div>
@stop
