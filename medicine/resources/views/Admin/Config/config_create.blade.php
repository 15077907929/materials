<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>主要内容区main</title>
<link href="{{asset('Admin/css/base.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('Admin/css/style.css')}}" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{{asset('Common/js/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('Admin/js/check.js')}}"></script>
<script type="text/javascript" src="{{asset('Admin/js/function.js')}}"></script>
</head>
<body>
<div class="main">
	<div class="breadcrumbs">
		<div class="breadcrumb">
			您的位置：<a href="{{url('admin/config')}}">网站配置</a>&nbsp;&nbsp;>&nbsp;&nbsp;新增配置
		</div>
	</div>
    <form method="post" action="{{url('admin/config')}}" name="config" onsubmit="return check_config();">{{csrf_field()}}
		<table class="ftab">
			<tr>
				<td align="right" class="bggray" width="8%">&nbsp;</td>
				<td align="left">
					<span class="back_msg">
						@foreach($errors->all() as $key=>$error)
							<font color="#f00">@if(count($errors->all())>1){{$key+1}}.@endif{{$error}}</font>&nbsp;&nbsp;&nbsp;
						@endforeach
					</span>
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">标题：</td>
				<td align="left">
					<input type="text" name="title" value="" />
					<em class="require"> * </em>
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">名称：</td>
				<td align="left">
					<input type="text" name="name" value="" />
					<em class="require"> * </em>
				</td>
			</tr>

			<tr>
				<td align="right" class="bggray">类型：</td>
				<td align="left">
					<input onclick="showTr();" checked type="radio" name="field_type" value="1" />input 
					<input onclick="showTr();" type="radio" name="field_type" value="2" />textarea 
					<input onclick="showTr();" type="radio" name="field_type" value="3" />radio 
				</td>
			</tr>						
			<tr class="field_value">
				<td align="right" class="bggray">类型值：</td>
				<td align="left">
					<input type="text" name="field_value" value="" />
				</td>
			</tr>			
			<tr>
				<td align="right" class="bggray">序号：</td>
				<td align="left">
					<input type="text" name="no_order" value="0" />
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">说明：</td>
				<td align="left">
					<textarea name="tips"></textarea
				</td>
			</tr>			
			<tr>
				<td align="right" class="bggray">&nbsp;</td>
				<td align="left">
					<input name="sub" type="submit" value="提交">
					<input name="res" type="reset" value="重置">
				</td>
			</tr>
		</table>
    </form>
	<script type="text/javascript">
		showTr();
	</script>
</body>
</html>