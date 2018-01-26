<?php /* Smarty version Smarty-3.1.6, created on 2018-01-26 14:47:07
         compiled from "../shop/Admin/View/Template/modules.html" */ ?>
<?php /*%%SmartyHeaderCode:11451321545a6acbeda70357-51578288%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f1530dc94c8e92cdbe77bcb4152fe351eb177eca' => 
    array (
      0 => '../shop/Admin/View/Template/modules.html',
      1 => 1516949225,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11451321545a6acbeda70357-51578288',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a6acbedae4f6',
  'variables' => 
  array (
    'result_arr' => 0,
    'item' => 0,
    'sub_item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a6acbedae4f6')) {function content_5a6acbedae4f6($_smarty_tpl) {?><!doctype html>
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
		<div class="modules">
			<div class="top_tool">
				<a href="">添加</a>
			</div>	
			<table class="stable">
				<tr>
					<th>模块名称</th>
					<th>描述</th>
					<th>转发页面</th>
					<th>访问权限</th>
					<th>操作</th>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['result_arr']->value['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<tr>
						<td  style="text-align:left;"> <?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</td>
						<td> <?php echo $_smarty_tpl->tpl_vars['item']->value['link_type'];?>
 </td>
						<td></td>
						<td></td>
						<td>
							<a href="">删除</a>
							<a href="">修改</a>
							<a href="">编辑样式</a>
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
							<td style="text-align:left;"> ---- <?php echo $_smarty_tpl->tpl_vars['sub_item']->value['name'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['sub_item']->value['link_type'];?>
</td>
							<td>
							</td>
							<td></td>
							<td>
								<a href="">删除</a>
								<a href="">修改</a>
								<a href="">编辑样式</a>
							</td>
						</tr>					
					<?php } ?>
				<?php } ?>
			</table>		
			<div class="sub_tool">
				<a href="">添加</a>
			</div>
			<div class="page"><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['page'];?>
</div>
		</div>
	</div>
</div>
</body>
</html>










<?php }} ?>