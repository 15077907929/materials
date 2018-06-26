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
</head>
<body>

@include('Admin/Common/header')

@include('Admin/Common/left')

<section class="container">
	<div class="breadcrumbs">
		<div class="location">文章管理</div>
		<div class="breadcrumb">
			<img src="{{asset('Admin/images/home.png')}}" /> 
			<a href="{{url('admin/index')}}">首页</a> &gt; 文章管理 &gt; 添加文章
			<a class="back fr" href="javascript:history.back();">返回</a>
		</div>
	</div>
	<div class="main">
		@foreach($errors->all() as $key=>$error)
			<font color="#f00">@if(count($errors->all())>1){{$key+1}}.@endif{{$error}}</font>&nbsp;&nbsp;&nbsp;
		@endforeach
		<form name="article" action="{{url('admin/article')}}" method="post" onsubmit="return check();">
			{{csrf_field()}}
			<table>
				<tr>
					<td width="18%"><font color="#f00">*</font>文章标题：</td>
					<td><input type="text" name="title" /></td>
				</tr>				
				<tr>
					<td><font color="#f00">*</font>文章分类：</td>
					<td>
						<select name="cate_id">
							<option value="">文章分类</option>
							@foreach($cate as $val)
								<option value="{{$val->id}}">{{$val->name}}</option>
								@foreach($val['sub'] as $v)
									<option value="{{$v->id}}">|-{{$v->name}}</option>
								@endforeach
							@endforeach
						</select>
					</td>
				</tr>
				<tr>
					<td>排序：</td>
					<td><input type="text" name="no_order" /></td>
				</tr>				
				<tr>
					<td>关键词：</td>
					<td><input type="text" name="tag" /></td>
				</tr>
				<tr>
					<td>文章摘要：</td>
					<td><textarea name="description"></textarea></td>
				</tr>
				<tr>
					<td>文章编辑：</td>
					<td><input type="text" name="editor" /></td>
				</tr>
				<tr>
					<td>文章内容：</td>
					<td>
						<script type="text/javascript" src="{{asset('Common/org/ueditor/ueditor.config.js')}}"></script>
						<script type="text/javascript" src="{{asset('Common/org/ueditor/ueditor.all.min.js')}}"> </script>
						<script type="text/javascript" src="{{asset('Common/org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
						<script id="editor" name="content" type="text/plain" style="line-height:20px;width:860px;height:360px;"></script>
						<script type="text/javascript">
							var ue = UE.getEditor('editor');
						</script>
					</td>
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
				if(article.title.value==''){
					alert('文章标题不能为空');
					article.title.focus();
					return false;
				}				
				if(article.cate_id.value==''){
					alert('文章分类不能为空');
					article.cate_id.focus();
					return false;
				}
				if(article.no_order.value!=''){
					var reg = /^[0-9]*$/;
					if (!reg.test(article.no_order.value)){
						alert("请输入数字!");
						article.no_order.focus();
						return false;
					}
				}
			}
		</script>
	</div>
</section>
</body>
</html>