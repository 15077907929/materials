<?php /* Smarty version Smarty-3.1.6, created on 2018-01-25 13:50:47
         compiled from "../shop/Admin/View/Menu/column.html" */ ?>
<?php /*%%SmartyHeaderCode:13548071865a696d6164e655-38214111%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2285ec3db2a11a069956f97ed07406c496dd2c7d' => 
    array (
      0 => '../shop/Admin/View/Menu/column.html',
      1 => 1516859444,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13548071865a696d6164e655-38214111',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a696d616a602',
  'variables' => 
  array (
    'result_arr' => 0,
    'item' => 0,
    'sub_item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a696d616a602')) {function content_5a696d616a602($_smarty_tpl) {?><!doctype html>
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
		<div class="column">
			<div class="top_tool">
				<a href="">添加</a>
				<a href="">发布</a>
				<a href="">不发布</a>
			</div>
			<table class="stable">
				<tr>
					<th>ID</th>
					<th>菜单名称</th>
					<th>链接方式</th>
					<th>排序号</th>
					<th>发布</th>
					<th>访问权限</th>
					<th>操作</th>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['result_arr']->value['column']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<tr>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
</td>
						<td><input type="checkbox" /> <?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['link_type'];?>
</td>
						<td style="text-align:center;" width="12%">
							<input placeholder="序号" class="form-control" type="text" value="<?php echo $_smarty_tpl->tpl_vars['sub_item']->value['no_order'];?>
" name="" />
							<a href="">修改</a>
						</td>
						<td></td>
						<td></td>
						<td class="toolbar">
							<a href="">删除</a>
							<a href="">修改</a>
						</td>
					</tr>
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