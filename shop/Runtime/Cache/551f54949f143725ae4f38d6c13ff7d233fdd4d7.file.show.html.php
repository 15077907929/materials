<?php /* Smarty version Smarty-3.1.6, created on 2018-01-25 13:33:36
         compiled from "../shop/Admin/View/Menu/show.html" */ ?>
<?php /*%%SmartyHeaderCode:11733662845a6952d1dc10f5-58656046%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '551f54949f143725ae4f38d6c13ff7d233fdd4d7' => 
    array (
      0 => '../shop/Admin/View/Menu/show.html',
      1 => 1516858415,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11733662845a6952d1dc10f5-58656046',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a6952d1e2b2a',
  'variables' => 
  array (
    'result_arr' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a6952d1e2b2a')) {function content_5a6952d1e2b2a($_smarty_tpl) {?><!doctype html>
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
		<div class="mainmenu">
			<form name="search" method="post" action="">
				<table>
					<tr>
						<td width="65%"></td>
						<td>菜单名称：<input placeholder="菜单名称" class="form-control" type="text" name="name" /></td>
						<td><button type="button" onclick="" class="btn btn-default">查询</button></td>
					</tr>
				</table>
			</form>	
			<table class="stable">
				<tr>
					<th></th>
					<th>编号</th>
					<th>菜单名称</th>
					<th>描述</th>
					<th>操作</th>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['result_arr']->value['mainmenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<tr>
						<td><input type="checkbox" name="" /></td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['no_order'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['description'];?>
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
			</div>
			<div class="page"><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['page'];?>
</div>
		</div>
	</div>
</div>
</body>
</html>










<?php }} ?>