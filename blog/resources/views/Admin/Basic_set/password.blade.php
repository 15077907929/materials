<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>主要内容区main</title>
<link href="{{asset('Admin/css/base.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('Admin/css/style.css')}}" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{{asset('Common/js/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('Admin/js/check.js')}}"></script>
<script type="text/javascript" src="{{asset('Admin/js/server.js')}}"></script>
</head>
<body>
<div class="main">
	<div class="breadcrumbs">
		<div class="breadcrumb">您的位置：基本设置&nbsp;&nbsp;>&nbsp;&nbsp;修改密码</div>
	</div>
	<form name="password">
		<table class="ftab">{{csrf_field()}}
			<tr>
				<td align="right" class="bggray" width="8%">&nbsp;</td>
				<td align="left">
					<span class="back_msg"></span>
				</td>
			</tr>			
			<tr>
				<td align="right" class="bggray"><b>管理员账号：</b></td>
				<td align="left">
					<input type="text" name="user_name" value="{{session('user')['user_name']}}" disabled />
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray"><b>原始密码：</b></td>
				<td align="left">
					<input type="password" name="pass_o" value="" maxlength="20" />
				</td>
			</tr>			
			<tr>
				<td align="right" class="bggray"><b>新密码：</b></td>
				<td align="left">
					<input type="password" name="pass_n" value="" maxlength="20" />
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray"><b>确认新密码：</b></td>
				<td align="left">
					<input type="password" name="pass_n_confirmation" value="" maxlength="20" />
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">&nbsp;</td>
				<td align="left">
					<input name="sub" type="button" onclick="change_pass();" value="提交" />
					<input name="res" type="reset" value="重置" />
				</td>
			</tr>
		</table>
	</form>
</div>
</body>
</html>