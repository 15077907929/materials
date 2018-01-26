<?php /* Smarty version Smarty-3.1.6, created on 2018-01-25 14:59:37
         compiled from "../shop/Admin/View/Goods/category.html" */ ?>
<?php /*%%SmartyHeaderCode:19667932035a697cb4d01bf9-68832219%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8b3cd9d28a3c9baf5f09ceb5a4ff46b64fe66774' => 
    array (
      0 => '../shop/Admin/View/Goods/category.html',
      1 => 1516863577,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19667932035a697cb4d01bf9-68832219',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a697cb4d619e',
  'variables' => 
  array (
    'result_arr' => 0,
    'item' => 0,
    'sub_item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a697cb4d619e')) {function content_5a697cb4d619e($_smarty_tpl) {?><!doctype html>
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
		<div class="category">
			<div class="top_tool">
				<a href="">添加</a>
				<a href="">发布</a>
				<a href="">不发布</a>
			</div>	
			<table class="stable">
				<tr>
					<th>ID</th>
					<th>分类名称</th>
					<th>链接类型</th>
					<th>排序号</th>
					<th>发布</th>
					<th>操作</th>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['result_arr']->value['category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<tr>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
</td>
						<td style="text-align:left;"><input type="checkbox" /> <?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['link_type'];?>
</td>
						<td width="12%">
							<input placeholder="序号" class="form-control" value="" name="" type="text">
							<a href="">修改</a>
						</td>
						<td></td>
						<td>
							<a href="">删除</a>
							<a href="">修改</a>
						</td>
					</tr>
					<?php  $_smarty_tpl->tpl_vars['sub_item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['sub_item']->_loop = false;
 $_smarty_tpl->tpl_vars['sub_key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value['sub']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['sub_item']->key => $_smarty_tpl->tpl_vars['sub_item']->value){
$_smarty_tpl->tpl_vars['sub_item']->_loop = true;
 $_smarty_tpl->tpl_vars['sub_key']->value = $_smarty_tpl->tpl_vars['sub_item']->key;
?>
						<tr>
							<td><?php echo $_smarty_tpl->tpl_vars['sub_item']->value['id'];?>
</td>
							<td style="text-align:left;"> ---- <input type="checkbox" /> <?php echo $_smarty_tpl->tpl_vars['sub_item']->value['name'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['sub_item']->value['link_type'];?>
</td>
							<td width="12%">
								<input placeholder="序号" class="form-control" value="" name="" type="text">
								<a href="">修改</a>
							</td>
							<td></td>
							<td>
								<a href="">删除</a>
								<a href="">修改</a>
							</td>
						</tr>					
					<?php } ?>
				<?php } ?>
			</table>		
			<div class="sub_tool">
				<a href="">添加</a>
				<a href="">发布</a>
				<a href="">不发布</a>
			</div>
			<div class="page"><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['page'];?>
</div>
		</div>
	</div>
</div>
</body>
</html>










<?php }} ?>