<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>后台登录</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="{{asset('Admin/css/base.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('Admin/css/style.css')}}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{asset('Common/js/jquery-3.3.1.min.js')}}"></script>
</head>
<body class="login">
<div class="header">
	<h4>后台管理系统</h4>
</div>
<form action="{{url('admin/login')}}" method="post">
	{{csrf_field()}}
	<table>
		<tr>
			<td width="25%">账户：</td>
			<td><input name="user_name" type="text" placeholder="账户" /></td>
		</tr>
		<tr>
			<td>密码：</td>
			<td><input name="user_pass" type="password" placeholder="密码" /></td>
		</tr>
		<tr>
			<td>验证码：</td>
			<td>
				<input name="code" type="text" placeholder="验证码" value="" />
				<img src="{{url('admin/code')}}" onclick="this.src='{{url('admin/code')}}?'+Math.random()" />
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input name="sub" type="submit" value="登 录" />
				<input name="res" type="reset" value="取 消" />
				<font color="#fcc">{{session('msg')}}</font>
			</td>
		</tr>
	</table>
</form>
<div class="footer">Copyright mike</div>
</body>
</html>