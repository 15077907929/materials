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
		<div class="breadcrumb">您的位置：基本设置&nbsp;&nbsp;>&nbsp;&nbsp;栏目管理</div>
	</div>
	<form method="post" action="" name="search">
		<a href="{{url('admin/basic_set/category/create')}}" target="mainFrame">新增栏目</a>
	</form>
	<form method="post" action="" name="category">{{csrf_field()}}
		<table>
			<tr>
				<th>顺序</th>
				<th>分类树</th>
				<th>ID</th>
				<th>栏目名</th>
				<th>栏目标题</th>
				<th>启用</th>
				<th>添加时间</th>
				<th>栏目管理</th>
			</tr>
			@foreach($category as $val)
				<tr class="bggray">
					<td><input type="text" onchange="change_order(this,{{$val->id}});" name="ord[]" value="{{$val->no_order}}"></td>
					<td align="left"><img src="{{asset('Admin/images/main/dirfirst.gif')}}" width="15" height="13"></td>
					<td>{{$val->id}}</td>
					<td align="left">{{$val->name}}</td>
					<td align="left">{{$val->title}}</td>
					<td>
						@if($val->status==1)
							是
						@else
							否
						@endif
					</td>
					<td>{{date('Y-m-d',$val->addtime)}}</td>
					<td>
						<a href="{{url('admin/basic_set/category/'.$val->id.'/edit')}}" target="mainFrame">修改</a>
						<span>&nbsp;|&nbsp;</span>
						<a onclick="javascript:check_del(category._token.value,'{{url('admin/basic_set/category/'.$val->id)}}',this)">删除</a>
					</td>
				</tr>	
				@foreach($val['sub'] as $v)
					<tr>
						<td><input type="text" onchange="change_order(this,{{$v->id}});" name="ord[]" value="{{$v->no_order}}"></td>
						<td align="left"><img src="{{asset('Admin/images/main/dirsecond.gif')}}" width="29" height="29"></td>
						<td>{{$v->id}}</td>
						<td align="left">{{$v->name}}</td>
						<td align="left">{{$v->title}}</td>
						<td>
							@if($v->status==1)
								是
							@else
								否
							@endif
						</td>
						<td>{{date('Y-m-d',$v->addtime)}}</td>
						<td>
							<a href="{{url('admin/basic_set/category/'.$v->id.'/edit')}}" target="mainFrame">修改</a>
							<span>&nbsp;|&nbsp;</span>
							<a onclick="javascript:check_del(category._token.value,'{{url('admin/basic_set/category/'.$v->id)}}',this)">删除</a>
						</td>
					</tr>
				@endforeach
			@endforeach
		</table>
	</form>
</div>
</body>
</html>