<!doctype html>
<html>
<head>
<title>exchange - 后台管理中心</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<link rel="stylesheet" type="text/css" href="{{asset('Admin/css/base.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('Admin/css/style.css')}}" />
<script type="text/javascript" src="http://exchange.hd/Admin/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="http://exchange.hd/Admin/js/base.js"></script>
</head>
<body>

@include('Admin.Common.header')

<div class="container clearfix">
	
	@include('Admin.Common.left')
	
	<div class="content">
		<div class="breadcrumbs clearfix">
			<span class="fl"></span>
			<h4 class="fl">添加栏目</h4>
			<span class="fr rbg"></span>
		</div>
		<div class="main cate">
			<h3 class="note"><img src="{{asset('Admin/images/mime.gif')}}" /> 
				<span>在这里，您可以根据您的需求，填写网站参数！</span>
			</h3>
			<form action="" method="">
				<table width="100%" class="cont">
					<tr>
						<td>栏目名称：</td>
						<td width="20%"><input class="text" type="text" name="cat_name" value="" /></td>
						<td>设置栏目名称</td>
					</tr>
					<tr>
						<td>栏目类型：</td>
						<td>
							<select>
								<option selected="true">请选择...</option>
								<option>单页</option>
								<option>文章列表</option>
							</select>
						</td>
						<td>设置栏目名称</td>
					</tr>
					<tr>
						<td>上级栏目：</td>
						<td>
							<select>
								<option selected="true">请选择...</option>
								<option>顶级栏目</option>
								<option>公司动态</option>
								<option>产品展示</option>
								<option>关于我们</option>
							</select>
						</td>
						<td>本栏目的上级栏目或分类</td>
					</tr>
					<tr>
						<td>是否隐藏：</td>
						<td>
							<input type="radio" name="is_hidden" value="1" /> 是 
							<input type="radio" name="is_hidden" value="0" /> 否
						</td>
						<td>设置该栏目是否隐藏。用户仍可通过URL访问到此栏目</td>
					</tr>
					<tr>
						<td>栏目位置：</td>
						<td>
							<input type="checkbox" name="pos" value="0" /> 顶部 
							<input type="checkbox" name="pos" value="1" /> 底部
						</td>
						<td>设置栏目的显示的范围与位置</td>
					</tr>
					<tr>
						<td>浏览器标题(title)：</td>
						<td><input class="text" style="width:200px;" type="text" name="bro_name" value="" /></td>
						<td>浏览器标题(Title)，有利于SEO</td>
					</tr>
					<tr>
						<td>关键字(Meta Keywords):：</td>
						<td><textarea></textarea></td>
						<td>Keywords 项出现在页面头部的 Meta 标签中，有利于SEO，多个关键字间请用半角逗号 "," 隔开</td>
					</tr>
					<tr>
						<td>描述(Meta Description):：</td>
						<td><textarea></textarea></td>
						<td>Description 出现在页面头部的 Meta 标签中，有利于SEO</td>
					</tr>
					<tr>
						<td colspan="3"><input class="btn" type="submit" value="提交" /></td>
					</tr>
				</table>
			</form>
		</div>
		
		@include('Admin.Common.footer')	
	
	</div>
</div>
</body>
</html>