<?php /* Smarty version Smarty-3.1.6, created on 2018-01-25 14:37:42
         compiled from "../shop/Admin/View/Content/content.html" */ ?>
<?php /*%%SmartyHeaderCode:18515852275a697758c3e3e4-45097358%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '74932fdf37a3cc69a947c229f3c25a38a9d157a2' => 
    array (
      0 => '../shop/Admin/View/Content/content.html',
      1 => 1516862259,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18515852275a697758c3e3e4-45097358',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a697758ca42c',
  'variables' => 
  array (
    'result_arr' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a697758ca42c')) {function content_5a697758ca42c($_smarty_tpl) {?><!doctype html>
<html>
<head>
<meta http-equiv='content-type' content='text/html;charset=utf-8' />
<meta name='description' content=''>
<meta name='keywords' content=''>
<link rel="stylesheet" type="text/css" href="/shop/Public/Common/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="/shop/Public/Common/css/base.css" />
<link rel="stylesheet" type="text/css" href="/shop/Public/Admin/css/admin.css" />
<script type="text/javascript" src="/shop/Public/Common/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/shop/Public/Common/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/shop/Public/Common/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/shop/Public/Admin/js/base.js"></script>
<script type="text/javascript" src="/shop/Public/Admin/js/function.js"></script>
<script type="text/javascript" src="/shop/Public/Admin/js/server.js"></script>
<title>商城后台管理</title>
</head>
<body>

<?php echo $_smarty_tpl->getSubTemplate ("Public/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="main_container clearfix">
	
	<?php echo $_smarty_tpl->getSubTemplate ("Public/left.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	
	<div class="main fr">
		<div class="content">
			<form name="search" method="post" action="">
				<table>
					<tr>
						<td>
							菜单栏目：
							<select class="form-control" name="">
								<option value="">请选择菜单栏目</option>
							</select>
						</td>
						<td>
							标题：
							<select class="form-control" name="">
								<option value="">请选择标题</option>
							</select>
						</td>
						<td>
							审核：
							<select class="form-control" name="">
								<option value="">请选择是否审核</option>
							</select>						
						</td>						
						<td>
							推荐：
							<select class="form-control" name="">
								<option value="">请选择是否推荐</option>
							</select>						
						</td>
						<td><button type="button" onclick="" class="btn btn-default">查询</button></td>
					</tr>
				</table>
			</form>	
			<table class="stable">
				<tr>
					<th></th>
					<th>菜单栏目</th>
					<th>标题</th>
					<th>发布日期</th>
					<th>审核</th>
					<th>推荐</th>
					<th>操作</th>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['result_arr']->value['content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<tr>
						<td><input type="checkbox" name="" /></td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['category'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['add_date'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['is_verify'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['featured'];?>
</td>
						<td>
							<a href="">删除</a>
							<a href="">修改</a>
						</td>
					</tr>
				<?php } ?>
			</table>
			
			<div class="sub_tool">
				<input type="checkbox" /> 选择所有
				<a href="">添加</a>
				<a href="">删除</a>
				<a href="">审核</a>
				<a href="">不审核</a>
				<a href="">推荐</a>
				<a href="">不推荐</a>
				<a href="">内容转移到</a>
				<select class="form-control" name="">
					<option value="">请选择转移到的栏目</option>
				</select>	
			</div>
			<div class="page"><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['page'];?>
</div>
		</div>
	</div>
</div>
</body>
</html>










<?php }} ?>