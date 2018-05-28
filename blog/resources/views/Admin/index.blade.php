<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站后台管理系统</title>
<link rel="shortcut icon" href="images/favicon.ico" />
</head>
<!--框架样式-->
<frameset rows="95,*,30" cols="*" frameborder="no" border="0">
<!--top样式-->
	<frame src="{{url('admin/common/top')}}" name="topframe" noresize id="topframe" title="topframe" />
<!--contact样式-->
	<frameset id="attachucp" border="0" frameborder="no" cols="194,12,*" rows="*">
		<frame noresize="" frameborder="no" name="leftFrame" src="{{url('admin/common/left')}}"></frame>
		<frame id="leftbar" noresize="" name="switchFrame" src="{{url('admin/common/left_switch')}}"></frame>
		<frame noresize="" border="0" name="mainFrame" src="{{url('admin/sys_info')}}"></frame>
	</frameset>
<!--bottom样式-->
	<frame src="{{url('admin/common/bottom')}}" name="bottomFrame" noresize="noresize" id="bottomFrame" title="bottomFrame" />
</frameset>
<noframes></noframes>
<!--不可以删除-->
</html>