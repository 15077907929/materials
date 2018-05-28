<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台页面头部</title>
<link href="{{asset('Admin/css/top.css')}}" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{{asset('Admin/js/clock.js')}}"></script>
</head>
<body>
<noscript><iframe scr="*.htm"></iframe></noscript>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="header">
	<tr>
		<td rowspan="2" align="left" valign="top" id="logo"><img src="{{asset('Admin/images/top/logo.jpg')}}" width="74" height="64"></td>
		<td align="left" valign="bottom">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="left" valign="bottom" id="header-name">BLOG</td>
					<td align="right" valign="top" id="header-right">
						<a href="{{url('admin/logout')}}" target="_top" class="admin-out">注销</a>
						<a href="{{url('admin/index')}}" target="_top" class="admin-home">管理首页</a>
						<a href="{{url('/')}}" target="_blank" class="admin-index">网站首页</a>       	
						<span>
							<!-- 日历 -->
							<script type="text/javascript">showcal();</script>
						</span>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left" valign="bottom">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="left" valign="top" id="header-admin">后台管理系统</td>
					<td align="left" valign="bottom" id="header-menu">
						<a href="index.html" target="left" id="menuon">后台首页</a>
						<a href="index.html" target="left">用户管理</a>
						<a href="index.html" target="left">栏目管理</a>
						<a href="index.html" target="left">信息管理</a>
						<a href="index.html" target="left">留言管理</a>
						<a href="index.html" target="left">附件管理</a>
						<a href="index.html" target="left">站点管理</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>