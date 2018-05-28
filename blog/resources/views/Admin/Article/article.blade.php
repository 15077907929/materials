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
		<div class="breadcrumb">您的位置：基本设置&nbsp;&nbsp;>&nbsp;&nbsp;文章管理</div>
	</div>
	<form method="post" action="" name="search">
		<a href="{{url('admin/article/create')}}" target="mainFrame">新增文章</a>
	</form>
	<form method="post" action="" name="article">{{csrf_field()}}
		<table>
			<tr>
				<th>顺序</th>
				<th>ID</th>
				<th>标题</th>
				<th>点击</th>
				<th>编辑</th>
				<th>发布时间</th>
				<th>审核状态</th>
				<th>文章管理</th>
			</tr>
			@foreach($article as $val)
				<tr>
					<td><input type="text" onchange="change_articles_order(this,{{$val->id}});" name="ord[]" value="{{$val->no_order}}"></td>
					<td>{{$val->id}}</td>
					<td align="left">{{$val->title}}</td>
					<td>{{$val->view}}</td>
					<td>{{$val->editor}}</td>
					<td>{{date('Y-m-d',$val->addtime)}}</td>
					<td>
						@if($val->status==1)
							已审核
						@else
							未审核
						@endif
					</td>
					<td>
						<a href="{{url('admin/article/'.$val->id.'/edit')}}" target="mainFrame">修改</a>
						<span>&nbsp;|&nbsp;</span>
						<a onclick="javascript:check_del(article._token.value,'{{url('admin/article/'.$val->id)}}',this)">删除</a>
					</td>
				</tr>	
			@endforeach
		</table>
	</form>
	<div class="page">
	{{$article->links()}}
	</div>
</div>
</body>
</html>