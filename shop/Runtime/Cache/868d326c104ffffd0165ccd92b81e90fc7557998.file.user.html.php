<?php /* Smarty version Smarty-3.1.6, created on 2018-01-24 17:07:02
         compiled from "../shop/Admin/View/System/user.html" */ ?>
<?php /*%%SmartyHeaderCode:19324513745a683d2ceee2c6-79138109%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '868d326c104ffffd0165ccd92b81e90fc7557998' => 
    array (
      0 => '../shop/Admin/View/System/user.html',
      1 => 1516784820,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19324513745a683d2ceee2c6-79138109',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a683d2cf4226',
  'variables' => 
  array (
    'result_arr' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a683d2cf4226')) {function content_5a683d2cf4226($_smarty_tpl) {?><!doctype html>
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
		<div class="user">
			<form name="search" method="post" action="">
				<table>
					<tr>
						<td>
							用户组：
							<select class="form-control" name="">
								<option value="">请选择用户组</option>
							</select>
						</td>
						<td>国家：<input placeholder="国家" class="form-control" type="text" name="country" /></td>
						<td>
							性别：
							<select class="form-control" name="sex">
								<option value="">请选择性别</option>
							</select>						
						</td>
						<td>用户名：<input placeholder="用户名" class="form-control" type="text" name="username" /></td>
						<td><button type="button" onclick="" class="btn btn-default">查询</button></td>
					</tr>
				</table>
			</form>	
			<table class="stable">
				<tr>
					<th></th>
					<th>用户组</th>
					<th>用户名</th>
					<th>出生日期</th>
					<th>国家</th>
					<th>性别</th>
					<th>注册日期</th>
					<th>操作</th>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['result_arr']->value['user']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<tr>
						<td><input type="checkbox" name="" /></td>
						<td></td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['username'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['birthday'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['country'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['sex'];?>
</td>
						<td></td>
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