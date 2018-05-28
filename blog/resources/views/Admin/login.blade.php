<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>login</title>
<link href="{{asset('Admin/css/base.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('Admin/css/login.css')}}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{asset('Common/js/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('Admin/js/fun.base.js')}}"></script>
<script type="text/javascript" src="{{asset('Admin/js/script.js')}}"></script>
<script type="text/javascript" src="{{asset('Admin/js/check.js')}}"></script>
</head>
<body>
<div class="login">
    <div class="box png">
		<div class="logo png"></div>
		<form class="log" name="log" action="" method="post" onsubmit="return user_login_check();">
			<div class="tip">
			@if(session('msg'))
				{{session('msg')}}
			@endif
			</div>
			{{csrf_field()}}
			<div class="name">
				<label>用户名</label><input type="text" class="text" placeholder="用户名" name="user_name" tabindex="1" value="{{$xd}}" />
			</div>
			<div class="pwd">
				<label>密　码</label><input type="password" class="text" placeholder="密码" name="user_pass" tabindex="2" value="" />
			</div>
			<div class="code">
				<label>验证码</label><input type="text" class="text" placeholder="验证码" name="code" tabindex="3" value="" />
				<img src="{{url('admin/code')}}" onclick="this.src='{{url('admin/code')}}?'+Math.random()" />
			</div>
			<div class="sub">
				<input type="submit" class="submit" tabindex="4" value="登录" />
			</div>
		</form>
	</div>
    <div class="air-balloon ab-1 png"></div>
	<div class="air-balloon ab-2 png"></div>
    <div class="footer"></div>
</div>
</body>
</html>
