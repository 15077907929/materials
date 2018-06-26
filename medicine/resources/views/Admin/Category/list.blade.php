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
			<a href="{{url('admin/index')}}">首页</a> &gt; 系统管理 &gt; 文章分类 &gt; 分类列表
		</div>
	</div>
	<div class="main category">
		<form name="search" action="" method="post">
			<input type="text" name="keyword" placeholder="分类名称" />
			{{csrf_field()}}
			<input type="submit" name="sub" value="搜索" />
		</form>
		<div class="catebar">
			<a class="del" href=""><img src="{{asset('Admin/images/trash.png')}}" height="12" /> 批量删除</a>
			<a class="add" href="{{url('admin/category/create')}}"><img src="{{asset('Admin/images/add.png')}}" /> 添加分类</a>
			<span class="fr">共有数据：<b>54</b> 条</span>
		</div>
		<table>	
			<tr>
				<th width="4%"><input value="" name="" type="checkbox" /></th>
				<th width="4%">ID</th>
				<th width="6%">排序</th>
				<th>分类名称</th>
				<th width="6%">操作</th>
			</tr>
			@foreach($cate as $val)
			<tr>
				<td><input value="" name="" type="checkbox" /></td>
				<td>{{$val->id}}</td>
				<td><input onchange="change_order(this,{{$val->id}});" type="text" value="{{$val->no_order}}" name="no_order" /></td>
				<td align="left">{{$val->name}}</td>
				<td>
					<a href="{{url('admin/category/'.$val->id.'/edit')}}"><img src="{{asset('Admin/images/edit.png')}}" /></a>
					<a onclick="javascript:check_del('{{url('admin/category/'.$val->id)}}',this)">
						<img src="{{asset('Admin/images/delete.png')}}" />
					</a>
				</td>
			</tr>
				@foreach($val['sub'] as $v)
				<tr>
					<td><input value="" name="" type="checkbox" /></td>
					<td>{{$val->id}}</td>
					<td><input onchange="change_order(this,{{$v->id}});" type="text" value="{{$v->no_order}}" name="no_order" /></td>
					<td align="left">|-{{$v->name}}</td>
					<td>
						<a href="{{url('admin/category/'.$v->id.'/edit')}}"><img src="{{asset('Admin/images/edit.png')}}" /></a>
						<a onclick="javascript:check_del('{{url('admin/category/'.$v->id)}}',this)">
							<img src="{{asset('Admin/images/delete.png')}}" />
						</a>
					</td>
				</tr>	
				@endforeach			
			@endforeach
		</table>
		<script type="text/javascript">
			//修改排序
			function change_order(obj,id){
				var _token=search._token.value;
				var no_order=$(obj).val();
				if(no_order==""){
					alert('分类排序不能为空！');
					setTimeout(function(){$(obj).focus();},100);
					return false;
				}else{
					if(!check_num(no_order)){
						alert('请输入数字！');
						setTimeout(function(){$(obj).focus();},100);
						return false;
					}		
				}
				$.post(
					"/admin/category/change_order",
					{'_token':_token,'id':id,'no_order':no_order},
					function(data){
						if(data.status==1){
							alert(data.msg);
						}else if(data.status==2){
							alert(data.msg);
							$(obj).focus();
						}else{
							alert(data.msg);
						}
					}
				)
			}	

			//确定删除
			function check_del(url,obj){  
				var mymessage=confirm("确认要删除该条记录吗？");  
				if(mymessage==true){  
					del(url,obj);
				} 
			} 

			//删除
			function del(url,obj){  
				var _token=search._token.value;
				$.post(
					url,
					{'_token':_token,'_method':'delete'},
					function(data){
						if(data.status==1){
							$(obj).parent().parent().remove();
							alert(data.msg);
						}else{
							alert(data.msg);
						}
					}
				)
			}			
		</script>
		<div class="pages">
			<a href="">上一页</a>
			<a href="">1</a>
			<a href="">2</a>
			<a href="">3</a>
			<a href="">下一页</a>
		</div>
	</div>
</section>
</body>
</html>