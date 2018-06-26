<!doctype html>
<html>
<head>
<title>exchange - 后台管理中心</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<link rel="stylesheet" type="text/css" href="{{asset('Admin/css/base.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('Admin/css/style.css')}}" />
<script type="text/javascript" src="{{asset('Admin/js/check.js')}}"></script>
</head>
<body class="loginbd">
<div class="top"></div>
<div class="container clearfix">
	<div class="fl note">
		<div class="logo">
			<img src="{{asset('Admin/images/logo.gif')}}" title="exchange" alt="exchange" />
		</div>
		<ul>
			<li>1- 企业门户站建立的首选方案...</li>
			<li>2- 一站通式的整合方式，方便用户使用...</li>
			<li>3- 强大的后台系统，管理内容易如反掌...</li>
			<li><img src="{{asset('Admin/images/icon_demo.gif')}}" />&nbsp;
				<a href="javascript:void(0)">使用说明</a>&nbsp;&nbsp;
			</li>
		</ul>
	</div>
	<div class="fr login">
		<form name="log" action="" method="post" onsubmit="return user_login_check();">{{csrf_field()}}
			<h4>RainMan 网站管理后台</h4>
			<div class="tip">
			@if(session('msg'))
				{{session('msg')}}
			@endif
			</div>
			<table>
				<tr><td width="16%">管理员：</td><td><input type="text" name="user_name" value="" /></td></tr>
				<tr><td>密&nbsp;&nbsp;&nbsp;&nbsp;码：</td><td><input type="password" name="user_pass" value="" /></td></tr>
				<tr><td>验证码：</td>
					<td><input class="fl" type="text" name="code" value="" />
						<img class="fl" src="{{url('admin/code')}}" onclick="this.src='{{url('admin/code')}}?'+Math.random()" />
					</td>
				</tr>
				<tr>
					<td>&nbsp;<input type="submit" value="登陆" name="sub" /></td>
					<td>&nbsp;<input type="reset" value="重填" name="res" /></td>
				</tr>
			</table>
		</form>
	</div>
</div>
<div class="login_bottom">Copyright © 2015-2018 RainMan 网络工作室</div>
</body>
</html>