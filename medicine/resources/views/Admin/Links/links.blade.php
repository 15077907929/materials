<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>主要内容区main</title>
<link href="{{asset('Admin/css/base.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('Admin/css/style.css')}}" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{{asset('Common/js/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('Common/js/layer/layer.js')}}"></script>
<script type="text/javascript" src="{{asset('Admin/js/server.js')}}"></script>
<script type="text/javascript" src="{{asset('Admin/js/check.js')}}"></script>
</head>
<body>
<div class="main">
	<div class="breadcrumbs">
		<div class="breadcrumb">您的位置：基本设置&nbsp;&nbsp;>&nbsp;&nbsp;友情链接管理</div>
	</div>
	<form method="post" action="" name="search">
		<a href="{{url('admin/links/create')}}" target="mainFrame">新增友情链接</a>
	</form>
	<form method="post" action="" name="link">{{csrf_field()}}
		<table>
			<tr>
				<th>顺序</th>
				<th>ID</th>
				<th>链接名称</th>
				<th>链接标题</th>
				<th>链接地址</th>
				<th>链接管理</th>
			</tr>
			@foreach($links as $val)
				<tr>
					<td><input type="text" onchange="change_links_order(this,{{$val->id}});" name="ord[]" value="{{$val->no_order}}"></td>
					<td>{{$val->id}}</td>
					<td align="left">{{$val->name}}</td>
					<td align="left">{{$val->title}}</td>
					<td>{{$val->url}}</td>
					<td>
						<a href="{{url('admin/links/'.$val->id.'/edit')}}" target="mainFrame">修改</a>
						<span>&nbsp;|&nbsp;</span>
						<a onclick="javascript:check_del(link._token.value,'{{url('admin/links/'.$val->id)}}',this)">删除</a>
					</td>
				</tr>	
			@endforeach
		</table>
	</form>
	<div class="page">
	{{$links->links()}}
	</div>
</div>
</body>
</html>