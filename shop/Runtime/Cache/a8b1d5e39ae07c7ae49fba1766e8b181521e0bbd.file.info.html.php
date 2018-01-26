<?php /* Smarty version Smarty-3.1.6, created on 2018-01-25 16:29:25
         compiled from "../shop/Admin/View/Goods/info.html" */ ?>
<?php /*%%SmartyHeaderCode:18556927225a6990793b9f90-17753732%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a8b1d5e39ae07c7ae49fba1766e8b181521e0bbd' => 
    array (
      0 => '../shop/Admin/View/Goods/info.html',
      1 => 1516868963,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18556927225a6990793b9f90-17753732',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a69907940644',
  'variables' => 
  array (
    'result_arr' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a69907940644')) {function content_5a69907940644($_smarty_tpl) {?><!doctype html>
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
		<div class="product_info">
			<form name="search" method="post" action="">
				<table>
					<tr>
						<td>
							产品分类：
							<select class="form-control" name="category">
								<option value="">请选择产品分类</option>
							</select>
						</td>
						<td>
							产品名称：
							<input type="text" class="form-control" name="name" />
						</td>
						<td>
							审核：
							<select class="form-control" name="is_verify">
								<option value="">是</option>
							</select>						
						</td>						
						<td>
							推荐：
							<select class="form-control" name="is_recommend">
								<option value="">是</option>
							</select>						
						</td>
						<td><button type="button" onclick="" class="btn btn-default">查询</button></td>
					</tr>
				</table>
			</form>	
			<table class="stable">
				<tr>
					<th></th>
					<th>产品分类</th>
					<th>产品名称</th>
					<th>价格</th>
					<th>审核</th>
					<th>推荐</th>
					<th>操作</th>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['result_arr']->value['product']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<tr>
						<td><input type="checkbox" name="" /></td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['category'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['price'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['is_verify'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['is_recommend'];?>
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
					<option value=""></option>
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