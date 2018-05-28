<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>主要内容区main</title>
<link href="{{asset('Admin/css/base.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('Admin/css/style.css')}}" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{{asset('Admin/js/check.js')}}"></script>
</head>
<body>
<div class="main">
	<div class="breadcrumbs">
		<div class="breadcrumb">
			您的位置：基本设置&nbsp;&nbsp;>&nbsp;&nbsp;
			<a href="{{url('admin/basic_set/category')}}">栏目管理</a>&nbsp;&nbsp;>&nbsp;&nbsp;修改栏目
		</div>
	</div>
    <form method="post" action="{{url('admin/basic_set/category/'.$field->id)}}" name="category" onsubmit="return check_category();">{{csrf_field()}}
		<input type="hidden" name="_method" value="put" />
		<table class="ftab">
			<tr>
				<td align="right" class="bggray" width="8%">&nbsp;</td>
				<td align="left">
					<span class="back_msg"><font color="#f00">{{!empty(session('error'))?session('error'):''}}</font></span>
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">父级分类：</td>
				<td align="left">
					<select name="pid">
						<option value="0" >==顶级分类==</option>
						@foreach($rst['top_c'] as $val) 
							<option value="{{$val->id}}" @if($val->id==$field->pid) selected @endif>&nbsp;&nbsp;{{$val->name}}</option>
						@endforeach
					</select>
					<em class="require"> * </em>
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">分类名称：</td>
				<td align="left">
					<input type="text" name="name" value="{{$field->name}}">
					<em class="require"> * </em>
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">分类标题：</td>
				<td align="left">
					<input type="text" name="title" value="{{$field->title}}">
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">关键词：</td>
				<td align="left">
					<input type="text" name="keywords" value="{{$field->keywords}}">
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">描述：</td>
				<td align="left">
					<textarea name="description">{{$field->description}}</textarea>
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">排序：</td>
				<td align="left">
					<input type="text" name="no_order" value="{{$field->no_order}}">
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
</body>
</html>