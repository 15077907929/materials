<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>Medicine后台</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="{{asset('Admin/css/base.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('Admin/css/style.css')}}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{asset('Common/js/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('Admin/js/check.js')}}"></script>
</head>
<body>

@include('Admin/Common/header')

@include('Admin/Common/left')

<section class="container">
	<div class="breadcrumbs">
		<div class="location">系统管理</div>
		<div class="breadcrumb">
			<img src="{{asset('Admin/images/home.png')}}" /> 
			<a href="{{url('admin/index')}}">首页</a> &gt; 系统管理 &gt; 文章分类 &gt; 添加分类
			<a class="back fr" href="javascript:history.back();">返回</a>
		</div>
	</div>
	<div class="main">
		@foreach($errors->all() as $key=>$error)
			<font color="#f00">@if(count($errors->all())>1){{$key+1}}.@endif{{$error}}</font>&nbsp;&nbsp;&nbsp;
		@endforeach
		<form name="category" action="{{url('admin/category')}}" method="post" onsubmit="return check();">
			{{csrf_field()}}
			<table>				
				<tr>
					<td width="18%">上级分类：</td>
					<td>
						<select name="pid">
							<option value="">顶级分类</option>
							@foreach($cate as $val)
								<option value="{{$val->id}}">{{$val->name}}</div>
							@endforeach
						</select>
					</td>
				</tr>
				<tr>
					<td><font color="#f00">*</font>分类名称：</td>
					<td><input type="text" name="name" /></td>
				</tr>				
				<tr>
					<td><font color="#f00">*</font>分类标题：</td>
					<td><input type="text" name="title" /></td>
				</tr>					
				<tr>
					<td>排序：</td>
					<td><input type="text" name="no_order" /></td>
				</tr>				
				<tr>
					<td>关键词：</td>
					<td><input type="text" name="keywords" /></td>
				</tr>
				<tr>
					<td>描述：</td>
					<td><textarea name="description"></textarea></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" name="sub" value="保存" />
						<input type="reset" name="res" value="重置" />
					</td>
				</tr>
			</table>
		</form>
		<script type="text/javascript">
			function check(){
				if(category.name.value==''){
					alert('分类名称不能为空!');
					category.name.focus();
					return false;
				}
				if(category.title.value==''){
					alert('分类标题不能为空!');
					category.title.focus();
					return false;
				}
				if(category.no_order.value!=''){
					var reg = /^[0-9]*$/;
					if (!reg.test(category.no_order.value)){
						alert("请输入数字!");
						category.no_order.focus();
						return false;
					}
				}
			}
		</script>
	</div>
</section>
</body>
</html>