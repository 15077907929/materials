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
		<div class="breadcrumb">您的位置：基本设置&nbsp;&nbsp;>&nbsp;&nbsp;网站配置</div>
	</div>
	<form method="post" action="" name="search">
		<a href="{{url('admin/config/create')}}" target="mainFrame">新增配置</a>
	</form>
	<form class="config" method="post" action="{{url('admin/config/change_content')}}" name="config">{{csrf_field()}}
		<table>
			<tr>
				<td colspan="9">
					<font color="#c00">
						@if(!empty(session('msg')))
							{{session('msg')}}
						@endif
					</font>
				</td>
			</tr>
			<tr>
				<th>顺序</th>
				<th>ID</th>
				<th>标题</th>
				<th>名称</th>
				<th>内容</th>
				<th>类型</th>
				<th>类型值</th>
				<th>描述</th>
				<th>配置管理</th>
			</tr>
			@foreach($config as $val)
				<tr>
					<td><input type="text" onchange="change_config_order(this,{{$val->id}});" name="ord[]" value="{{$val->no_order}}"></td>
					<td>{{$val->id}}</td>
					<td align="left">{{$val->name}}</td>
					<td align="left">{{$val->title}}</td>
					<td align="left">
						{!!$val->content!!}
						<input type="hidden" value="{{$val->id}}" name="id[]" />
					</td>
					<td>
						@if($val->field_type==1)
							input
						@elseif($val->field_type==2)
							textarea
						@else
							radio
						@endif
					</td>
					<td>{{$val->field_value}}</td>
					<td>{{$val->tips}}</td>
					<td>
						<a href="{{url('admin/config/'.$val->id.'/edit')}}" target="mainFrame">修改</a>
						<span>&nbsp;|&nbsp;</span>
						<a onclick="javascript:check_del(config._token.value,'{{url('admin/config/'.$val->id)}}',this)">删除</a>
					</td>
				</tr>	
			@endforeach
		</table>
		<div class="sub">
			<input name="sub" value="提交" type="submit" />
			<input name="res" value="重置" type="reset" />
		</div>
	</form>
	<div class="page">
	{{$config->links()}}
	</div>
</div>
</body>
</html>