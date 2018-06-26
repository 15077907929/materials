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
			<h4 class="fl">添加管理</h4>
			<span class="fr rbg"></span>
		</div>
		<div class="main cate">
			<h3 class="note"><img src="{{asset('Admin/images/mime.gif')}}" /> 
				<span>在这里，您可以根据您的需求，填写网站参数！</span>
			</h3>		
			<table width="100%"  class="list">
				<tr>
					<th>排序</th>
					<th>栏目名称</th>
					<th>栏目类型</th>
					<th>显示/隐藏</th>
					<th>栏目位置</th>
					<th>操作</th>
				</tr>
				<tr>
					<td>1</td>
					<td>公司首页</td>
					<td>链接</td>
					<td>显示</td>
					<td>顶部底部</td>
					<td>
						<a href="">编辑</a>
						<a href="">删除</a> 
						<a href="">内容管理</a>
					</td>
				</tr>
				<tr>
					<td>2</td>
					<td>公司首页</td>
					<td>链接</td>
					<td>显示</td>
					<td>顶部底部</td>
					<td>
						<a href="">编辑</a>
						<a href="">删除</a> 
						<a href="">内容管理</a>
					</td>
				</tr>
				<tr>
					<td>3</td>
					<td>公司首页</td>
					<td>链接</td>
					<td>显示</td>
					<td>顶部底部</td>
					<td>
						<a href="">编辑</a>
						<a href="">删除</a> 
						<a href="">内容管理</a>
					</td>
				</tr>
				<tr>
					<td>4</td>
					<td>公司首页</td>
					<td>链接</td>
					<td>显示</td>
					<td>顶部底部</td>
					<td>
						<a href="">编辑</a>
						<a href="">删除</a> 
						<a href="">内容管理</a>
					</td>
				</tr>
				<tr>
					<td>5</td>
					<td>公司首页</td>
					<td>链接</td>
					<td>显示</td>
					<td>顶部底部</td>
					<td>
						<a href="">编辑</a>
						<a href="">删除</a> 
						<a href="">内容管理</a>
					</td>
				</tr>
				<tr>
					<td>6</td>
					<td>公司首页</td>
					<td>链接</td>
					<td>显示</td>
					<td>顶部底部</td>
					<td>
						<a href="">编辑</a>
						<a href="">删除</a> 
						<a href="">内容管理</a>
					</td>
				</tr>
				<tr>
					<td>7</td>
					<td>公司首页</td>
					<td>链接</td>
					<td>显示</td>
					<td>顶部底部</td>
					<td>编辑 删除 内容管理</td>
				</tr>
				<tr>
					<td>5</td>
					<td>公司首页</td>
					<td>链接</td>
					<td>显示</td>
					<td>顶部底部</td>
					<td>
						<a href="">编辑</a>
						<a href="">删除</a> 
						<a href="">内容管理</a>
					</td>
				</tr>
				<tr>
					<td>6</td>
					<td>公司首页</td>
					<td>链接</td>
					<td>显示</td>
					<td>顶部底部</td>
					<td>
						<a href="">编辑</a>
						<a href="">删除</a> 
						<a href="">内容管理</a>
					</td>
				</tr>
			</table>
		</div>
		
	@include('Admin.Common.footer')	
	
</div>
</body>
</html>