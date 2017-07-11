@extends('admin.common.index')
@section('title','登录日志')
@section('header')
@parent
@stop
@section('left')
@parent
@stop
@section('content')
  <h1 class="page-header">操作</h1>
  <ol class="breadcrumb">
    <li><a href="{{url('admin/delloginlog')}}">清除所有登录记录</a></li>
    <li><a href="{{url('admin/delloginlog',[session('user')['id']])}}">清除本人登录记录</a></li>
    @if(Session::has('message'))
      <li style="color:orange">{{Session::get('message')}}</li>
    @endif
  </ol>
  <h1 class="page-header">管理 <span class="badge">{{count($login_log)}}</span>
  </h1>
  <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead>
      <tr>
        <th><span class="glyphicon glyphicon-th-large"></span> <span class="visible-lg">ID</span></th>
        <th><span class="glyphicon glyphicon-user"></span> <span class="visible-lg">用户</span></th>
        <th><span class="glyphicon glyphicon-time"></span> <span class="visible-lg">时间</span></th>
        <th><span class="glyphicon glyphicon-adjust"></span> <span class="visible-lg">IP</span></th>
        <th><span class="glyphicon glyphicon-adjust"></span> <span class="visible-lg">状态</span></th>
        <th><span class="glyphicon glyphicon-remove"></span> <span class="visible-lg">删除</span></th>
      </tr>
      </thead>
      <tbody>
        @foreach($login_log as $v)
          <tr>
            <td>{{$v->id}}</td>
            <td class="article-title">{{$v->user_name}}</td>
            <td>{{date('Y-m-d H:i:s',$v->login_time)}}</td>
            <td>{{$v->login_ip}}</td>
            <td>
            @if($v->type==0)
                成功登录
            @elseif($v->type==1)
                <strong style="color:orange">验证码错误</strong>
            @elseif($v->type==2)
                </strong  style="color:red">密码用户名错误</strong>
            @else
                未知
            @endif
            </td>
            <td><a rel="{{$v->id}}">删除</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <footer class="message_footer">
    <nav>
      <ul class="pagination pagenav">
        <li class="disabled"><a aria-label="Previous"> <span aria-hidden="true">&laquo;</span> </a> </li>
        <li class="active"><a>1</a></li>
        <li class="disabled"><a aria-label="Next"> <span aria-hidden="true">&raquo;</span> </a> </li>
      </ul>
    </nav>
  </footer>
@stop
@section('javascript')
<script>
//是否确认删除
$(function(){
	$("#main table tbody tr td a").click(function(){
		var name = $(this);
		var id = name.attr("rel"); //对应id
		if (event.srcElement.outerText === "删除")
		{
			if(window.confirm("此操作不可逆，是否确认？"))
			{
				$.ajax({
					type: "POST",
					url: "{{url('admin/delloginlog')}}",
					data: {"id":id,'_token':'{{csrf_token()}}'},
					cache: false, //不缓存此页面
					success: function (data) {
					    if(data.code==200){
						   window.location.reload();
                        }else{
					       alert(data.message);
                        }
					}
				});
			};
		};
	});
});
</script>
@stop
