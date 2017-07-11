<!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>异清轩博客管理系统</title>
<link rel="stylesheet" type="text/css" href="{{asset('public/Admin/css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('public/Admin/css/style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('public/Admin/css/login.css')}}">
<link rel="apple-touch-icon-precomposed" href="images/icon/icon.png">
<link rel="shortcut icon" href="images/icon/favicon.ico">
<script src="{{asset('public/Admin/js/jquery-2.1.4.min.js')}}"></script>
<!--[if gte IE 9]>
  <script src="{{asset('public/Admin/js/jquery-1.11.1.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('public/Admin/js/html5shiv.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('public/Admin/js/respond.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('public/Admin/js/selectivizr-min.js')}}" type="text/javascript"></script>
<![endif]-->
<!--[if lt IE 9]>
  <script>window.location.href='upgrade-browser.html';</script>
<![endif]-->
</head>

<body class="user-select">
<div class="container">
  <div class="siteIcon"><img src="images/icon/icon.png" alt="" data-toggle="tooltip" data-placement="top" title="欢迎使用异清轩博客管理系统" draggable="false" /></div>
  <form action="" method="post" autocomplete="off" class="form-signin">
    {{csrf_field()}}
    <h2 class="form-signin-heading">管理员登录</h2>
    @if(Session::has('Codemessage'))
      <p style="color:red;text-align: center">{{Session::get('Codemessage')}}</p>
    @else
      <p style="color:red;text-align: center">{{Session::get('up')}}</p>
    @endif
    <label for="userName" class="sr-only">用户名</label>
    <input type="text" id="userName" name="user_name" class="form-control" placeholder="请输入用户名" required autofocus autocomplete="off" maxlength="10">
    <label for="userPwd" class="sr-only">密码</label>
    <input type="password" id="userPwd" name="userpwd" class="form-control" placeholder="请输入密码" required autocomplete="off" maxlength="18">
    <label for="userPwd" class="sr-only">验证码</label>
    <img src="{{url('admin/code')}}" alt="验证码" onclick="this.src='{{route("admin/code")}}?'+Math.random()">
    <input type="text" id="code" name="code" class="form-control" placeholder="请输验证码" required autocomplete="off" maxlength="18">
    <a href="main.html"><button class="btn btn-lg btn-primary btn-block" type="submit" id="signinSubmit">登录</button></a>
  </form>
  <div class="footer">
    <p><a href="index.html" data-toggle="tooltip" data-placement="left" title="不知道自己在哪?">回到后台 →</a></p>
  </div>
</div>
<script src="{{asset('public/Admin/js/bootstrap.min.js')}}"></script>
<script>
$('[data-toggle="tooltip"]').tooltip();
window.oncontextmenu = function(){
	//return false;
};
$('.siteIcon img').click(function(){
	window.location.reload();
});
$('#signinSubmit').click(function(){
	if($('#userName').val() === ''){
		$(this).text('用户名不能为空');
	}else if($('#userPwd').val() === ''){
		$(this).text('密码不能为空');
	}else{
		$(this).text('请稍后...');
	}
});
</script>
</body>
</html>
