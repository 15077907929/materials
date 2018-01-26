<?php /* Smarty version Smarty-3.1.6, created on 2018-01-25 17:12:50
         compiled from "../shop/Admin/View/Goods/orders.html" */ ?>
<?php /*%%SmartyHeaderCode:14689334555a699cbb871924-28815605%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fbcaa90d4feefed6370842dfb6d7cca25299bba7' => 
    array (
      0 => '../shop/Admin/View/Goods/orders.html',
      1 => 1516871567,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14689334555a699cbb871924-28815605',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a699cbb8e528',
  'variables' => 
  array (
    'result_arr' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a699cbb8e528')) {function content_5a699cbb8e528($_smarty_tpl) {?><!doctype html>
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
		<div class="orders">
			<form name="search" method="post" action="">
				<table>
					<tr>
						<td width="50%"></td>
						<td>
							订购用户：
							<input type="text" class="form-control" name="order_people" />					
						</td>						
						<td width="20%">
							状态：
							<select class="form-control" name="status">
								<option value=""></option>
							</select>						
						</td>
						<td><button type="button" onclick="" class="btn btn-default">查询</button></td>
					</tr>
				</table>
			</form>	
			<table class="stable">
				<tr>
					<th></th>
					<th>订单日期</th>
					<th>订购用户</th>
					<th>处理日期</th>
					<th>处理人</th>
					<th>状态</th>
					<th>操作</th>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['result_arr']->value['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<tr>
						<td><input type="checkbox" name="" /></td>
						<td><?php echo date('Y-m-d',$_smarty_tpl->tpl_vars['item']->value['order_time']);?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['order_people'];?>
</td>
						<td></td>
						<td></td>
						<td>
							<?php if ($_smarty_tpl->tpl_vars['item']->value['status']==1){?>
								处理中
							<?php }?>							
						</td>
						<td>
							<a href="">删除</a>
							<a href="">浏览</a>
						</td>
					</tr>
				<?php } ?>
			</table>
			
			<div class="sub_tool">
				<input type="checkbox" /> 选择所有
				<a href="">添加</a>
				<a href="">删除</a>
				<a href="">完成</a>
				<a href="">未完成</a>
			</div>
			<div class="page"><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['page'];?>
</div>
		</div>
	</div>
</div>
</body>
</html>










<?php }} ?>