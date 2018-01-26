<?php /* Smarty version Smarty-3.1.6, created on 2018-01-26 14:13:21
         compiled from "../shop/Admin/View/Template/template.html" */ ?>
<?php /*%%SmartyHeaderCode:4486722505a6ac5df3adc03-64434411%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ae39e9a35278989a4052b24c54eef4dc7d463d4d' => 
    array (
      0 => '../shop/Admin/View/Template/template.html',
      1 => 1516947200,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4486722505a6ac5df3adc03-64434411',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a6ac5df41da6',
  'variables' => 
  array (
    'result_arr' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a6ac5df41da6')) {function content_5a6ac5df41da6($_smarty_tpl) {?><!doctype html>
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
		<div class="template">
			<form name="search" method="post" action="">
				<table>
					<tr>
						<td width="40%"></td>
						<td>
							模板名称：
							<select class="form-control" name="">
								<option value="">请选择模板名称</option>
							</select>						
						</td>						
						<td>
							默认：
							<select class="form-control" name="">
								<option value="">请选择是否默认</option>
							</select>						
						</td>
						<td><button type="button" onclick="" class="btn btn-default">查询</button></td>
					</tr>
				</table>
			</form>	
			<table class="stable">
				<tr>
					<th></th>
					<th>模板名称</th>
					<th>默认</th>
					<th>操作</th>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['result_arr']->value['template']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<tr>
						<td><input type="radio" name="" /></td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['is_default'];?>
</td>
						<td>
							<a href="">删除</a>
						</td>
					</tr>
				<?php } ?>
			</table>
			<div class="sub_tool">
				<a href="">默认</a>	
			</div>
			<div class="page"><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['page'];?>
</div>
		</div>
	</div>
</div>
</body>
</html>










<?php }} ?>